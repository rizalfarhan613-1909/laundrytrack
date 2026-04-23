<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KurirController extends Controller
{
    public function __construct(private WhatsAppService $wa) {}

    // ═══════════════════════════════════════════════════════════════
    //  DASHBOARD — Tampilan utama kurir
    // ═══════════════════════════════════════════════════════════════

    public function dashboard()
    {
        // Jika layanan kurir dinonaktifkan admin, tampilkan halaman nonaktif
        if (!Setting::get('kurir_enabled', false)) {
            return view('kurir.disabled');
        }

        $kurirId = Auth::id();

        // Tugas aktif milik kurir ini (status pickup = sedang dijalan)
        $myActiveOrders = Order::where('kurir_id', $kurirId)
            ->where('status', 'pickup')
            ->with(['customer', 'service'])
            ->latest('pickup_at')
            ->get();

        // Order jemput yang belum diambil kurir manapun
        $availableOrders = Order::where('status', 'pending')
            ->where('pickup_type', 'jemput')
            ->whereNull('kurir_id')
            ->with(['customer', 'service'])
            ->oldest() // tampilkan yang paling lama nunggu duluan
            ->get();

        // Statistik ringkas kurir hari ini
        $todayStats = [
            'pickup'    => Order::where('kurir_id', $kurirId)
                                ->whereDate('pickup_at', today())
                                ->count(),
            'finished'  => Order::where('kurir_id', $kurirId)
                                ->where('status', 'finished')
                                ->whereDate('finished_at', today())
                                ->count(),
            'total_all' => Order::where('kurir_id', $kurirId)->count(),
        ];

        return view('kurir.dashboard', compact(
            'myActiveOrders',
            'availableOrders',
            'todayStats'
        ));
    }

    // ═══════════════════════════════════════════════════════════════
    //  DETAIL ORDER — Kurir lihat detail satu order
    // ═══════════════════════════════════════════════════════════════

    public function showOrder(Order $order)
    {
        // Hanya kurir yang di-assign ke order ini yang bisa lihat
        if ($order->kurir_id !== Auth::id()) {
            abort(403, 'Kamu tidak ditugaskan ke order ini.');
        }

        $order->load(['customer', 'service', 'payment']);

        // Generate WA deep-link ke customer
        $waLink = $this->wa->kurirToCustomerLink($order);

        return view('kurir.order-detail', compact('order', 'waLink'));
    }

    // ═══════════════════════════════════════════════════════════════
    //  ACCEPT PICKUP — Kurir ambil tugas jemputan
    // ═══════════════════════════════════════════════════════════════

    public function acceptPickup(Order $order)
    {
        // Validasi order bisa diambil
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Order ini sudah tidak bisa diambil (status bukan pending).']);
        }
        if ($order->pickup_type !== 'jemput') {
            return back()->withErrors(['error' => 'Order ini tidak menggunakan layanan jemput.']);
        }
        if ($order->kurir_id) {
            return back()->withErrors(['error' => 'Order ini sudah diambil kurir lain.']);
        }

        // Cek kurir tidak sedang pegang terlalu banyak order aktif
        $activeCount = Order::where('kurir_id', Auth::id())
            ->where('status', 'pickup')
            ->count();

        $maxActive = (int) Setting::get('kurir_max_active', 5);
        if ($activeCount >= $maxActive) {
            return back()->withErrors([
                'error' => "Kamu sudah punya {$activeCount} tugas aktif. Selesaikan dulu sebelum ambil yang baru."
            ]);
        }

        DB::transaction(function () use ($order) {
            $order->update(['kurir_id' => Auth::id()]);
            $order->advanceStatus(); // pending → pickup

            // Notif ke customer bahwa kurir sudah on the way
            $this->wa->notifyStatusChanged($order->fresh(['customer', 'service']));

            // Notif ke kurir sendiri (konfirmasi tugas)
            $this->wa->notifyKurir($order->fresh(['kurir', 'customer', 'service']));
        });

        return back()->with('success', "✓ Berhasil! Kamu mengambil tugas jemput order {$order->order_code}. Segera hubungi customer.");
    }

    // ═══════════════════════════════════════════════════════════════
    //  CONFIRM PICKUP — Kurir konfirmasi sudah sampai di laundry
    // ═══════════════════════════════════════════════════════════════

    public function confirmPickup(Order $order)
    {
        // Validasi hak akses
        if ($order->kurir_id !== Auth::id()) {
            abort(403, 'Kamu tidak ditugaskan ke order ini.');
        }
        if ($order->status !== 'pickup') {
            return back()->withErrors(['error' => 'Status order tidak bisa dikonfirmasi (harus status Pickup).']);
        }

        // Ubah status ke in_process (kasir yang akan lanjutkan proses pencucian)
        $order->update([
            'status'     => 'in_process',
            'process_at' => now(),
        ]);

        // Notif ke customer bahwa cucian sudah di laundry
        $this->wa->notifyStatusChanged($order->fresh(['customer', 'service']));

        return back()->with('success', "✓ Cucian order {$order->order_code} berhasil diantar ke laundry. Status diubah ke 'Sedang Diproses'.");
    }

    // ═══════════════════════════════════════════════════════════════
    //  REJECT / LEPAS TUGAS — Kurir batalkan tugas yang sudah diambil
    // ═══════════════════════════════════════════════════════════════

    public function rejectPickup(Request $request, Order $order)
    {
        if ($order->kurir_id !== Auth::id()) {
            abort(403);
        }
        if ($order->status !== 'pickup') {
            return back()->withErrors(['error' => 'Hanya bisa melepas tugas yang masih status Pickup.']);
        }

        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($order, $request) {
            // Kembalikan order ke pending, hapus kurir_id
            $order->update([
                'status'    => 'pending',
                'kurir_id'  => null,
                'pickup_at' => null,
                'notes'     => $order->notes . "\n[Kurir melepas tugas: " . ($request->reason ?? 'Tanpa alasan') . "]",
            ]);
        });

        return back()->with('success', "Tugas order {$order->order_code} telah dilepas. Order kembali ke antrian.");
    }

    // ═══════════════════════════════════════════════════════════════
    //  RIWAYAT — Semua order yang pernah ditangani kurir ini
    // ═══════════════════════════════════════════════════════════════

    public function history(Request $request)
    {
        $kurirId = Auth::id();
        $filter  = $request->get('filter', 'all');  // all | today | week | month
        $search  = $request->get('search', '');

        $query = Order::where('kurir_id', $kurirId)
            ->with(['customer', 'service', 'payment'])
            ->latest();

        // Filter periode
        match ($filter) {
            'today' => $query->whereDate('created_at', today()),
            'week'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            default => null,
        };

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(15);

        // Statistik keseluruhan
        $stats = [
            'total'    => Order::where('kurir_id', $kurirId)->count(),
            'finished' => Order::where('kurir_id', $kurirId)->where('status', 'finished')->count(),
            'today'    => Order::where('kurir_id', $kurirId)->whereDate('pickup_at', today())->count(),
            'month'    => Order::where('kurir_id', $kurirId)
                               ->whereMonth('pickup_at', now()->month)
                               ->whereYear('pickup_at', now()->year)
                               ->count(),
        ];

        return view('kurir.history', compact('orders', 'stats', 'filter', 'search'));
    }

    // ═══════════════════════════════════════════════════════════════
    //  PROFIL — Data profil kurir (nama, HP, dll)
    // ═══════════════════════════════════════════════════════════════

    public function profile()
    {
        $kurir = Auth::user();
        return view('kurir.profile', compact('kurir'));
    }

    public function updateProfile(Request $request)
    {
        $kurir = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi agar bisa dihubungi customer.',
        ]);

        $kurir->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}