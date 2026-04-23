<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────
    public function dashboard()
    {
        $today = today();

        // Ringkasan harian
        $dailyRevenue = Payment::whereDate('verified_at', $today)
            ->where('status', 'verified')
            ->sum('amount');

        $dailyOrders = Order::whereDate('created_at', $today)->count();

        $activeOrders = Order::active()->count();

        // Pemasukan 7 hari terakhir (untuk chart)
        $weeklyRevenue = Payment::select(
                DB::raw('DATE(verified_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'verified')
            ->whereBetween('verified_at', [now()->subDays(6), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Isi hari yang kosong dengan 0
        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueChart[$date] = $weeklyRevenue[$date] ?? 0;
        }

        // Stok bahan menipis
        $lowInventories = Inventory::where('stock', '<=', DB::raw('min_stock'))
            ->orderBy('stock')
            ->get();

        // Pembayaran pending verifikasi
        $pendingPayments = Payment::with(['order.customer'])
            ->where('status', 'pending')
            ->whereIn('method', ['transfer', 'qris'])
            ->latest()
            ->limit(5)
            ->get();

        // Order terbaru
        $recentOrders = Order::with(['customer', 'service'])
            ->latest()
            ->limit(10)
            ->get();

        // Statistik status order
        $orderStats = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $kurirEnabled = Setting::get('kurir_enabled', false);

        return view('admin.dashboard', compact(
            'dailyRevenue', 'dailyOrders', 'activeOrders',
            'revenueChart', 'lowInventories', 'pendingPayments',
            'recentOrders', 'orderStats', 'kurirEnabled'
        ));
    }

    // ─── Toggle Kurir ─────────────────────────────────────────────
    public function toggleKurir(Request $request)
    {
        $current = Setting::get('kurir_enabled', false);
        Setting::set('kurir_enabled', !$current);

        $status = !$current ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Layanan kurir berhasil {$status}.");
    }

    public function kurirManagement()
    {
        $kurirs = \App\Models\User::where('role', 'kurir')
            ->with(['deliveries' => function ($q) {
                $q->select('id', 'kurir_id', 'status', 'pickup_at', 'finished_at');
            }])
            ->orderBy('is_active', 'desc')
            ->orderBy('name')
            ->get();

        $pendingPickups = \App\Models\Order::where('status', 'pending')
            ->where('pickup_type', 'jemput')
            ->whereNull('kurir_id')
            ->with(['customer'])
            ->oldest()
            ->get();

        $kurirEnabled = \App\Models\Setting::get('kurir_enabled', false);

        return view('admin.kurir.index', compact('kurirs', 'pendingPickups', 'kurirEnabled'));
    }
    // ─── Inventory Management ─────────────────────────────────────
    public function inventoryIndex()
    {
        $inventories = Inventory::withCount(['logs'])->latest()->paginate(15);
        return view('admin.inventory.index', compact('inventories'));
    }

    public function inventoryStore(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'category'       => 'required|string|max:50',
            'stock'          => 'required|numeric|min:0',
            'unit'           => 'required|string|max:20',
            'min_stock'      => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'notes'          => 'nullable|string|max:255',
        ]);

        Inventory::create($validated);
        return back()->with('success', 'Item inventaris berhasil ditambahkan.');
    }

    public function inventoryAdjust(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'type'        => 'required|in:in,out',
            'quantity'    => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        $inventory->adjustStock(
            $validated['quantity'],
            $validated['type'],
            $validated['description'] ?? ($validated['type'] === 'in' ? 'Restock' : 'Pemakaian'),
            auth()->id()
        );

        return back()->with('success', 'Stok berhasil diperbarui.');
    }

    // ─── Reports ─────────────────────────────────────────────────
    public function reports(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to   = $request->get('to',   now()->format('Y-m-d'));

        $revenue = Payment::where('status', 'verified')
            ->whereBetween('verified_at', [$from, $to . ' 23:59:59'])
            ->sum('amount');

        $totalOrders   = Order::whereBetween('created_at', [$from, $to . ' 23:59:59'])->count();
        $finishedOrders = Order::where('status', 'finished')
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])->count();

        $serviceStats = Order::select('service_id', DB::raw('count(*) as total'))
            ->with('service')
            ->whereBetween('created_at', [$from, $to . ' 23:59:59'])
            ->groupBy('service_id')
            ->get();

        $dailyRevenue = Payment::select(
                DB::raw('DATE(verified_at) as date'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('status', 'verified')
            ->whereBetween('verified_at', [$from, $to . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports', compact(
            'from', 'to', 'revenue', 'totalOrders',
            'finishedOrders', 'serviceStats', 'dailyRevenue'
        ));
    }

    // ─── User Management ─────────────────────────────────────────
    public function users(Request $request)
    {
        $role  = $request->get('role', 'all');
        $query = User::latest();
        if ($role !== 'all') $query->where('role', $role);

        $users = $query->paginate(20);
        return view('admin.users', compact('users', 'role'));
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }
}