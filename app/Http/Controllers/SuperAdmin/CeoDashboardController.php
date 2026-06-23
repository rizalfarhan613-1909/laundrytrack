<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CeoDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan Aplikasi Dinamis (Aman dari salah nama relasi berkat Database Join)
        $totalCeoEarnings = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'verified')
            ->sum('orders.system_fee');

        // 2. Total Omset Bersih Seluruh Ekosistem yang beneran Lunas / Verified
        $globalOmset = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'verified')
            ->sum('orders.total_price');

        // 3. Total Seluruh Transaksi & Berat Baju Global yang beneran sukses dibayar
        $totalTransactions = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'verified')
            ->count();

        $totalGlobalWeight = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'verified')
            ->sum('orders.weight_kg');

        // 4. Grafik Pembanding: Toko dengan Performa Omset Tertinggi (Hanya hitung order lunas)
        $topLaundries = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('laundries', 'orders.laundry_id', '=', 'laundries.id')
            ->where('payments.status', 'verified')
            ->select('laundries.name', DB::raw('SUM(orders.total_price) as total_revenue'))
            ->groupBy('laundries.name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // 5. Layanan Paling Laku di Seluruh Ekosistem LaundryTrack (Hanya hitung order lunas)
        $topServices = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('services', 'orders.service_id', '=', 'services.id')
            ->where('payments.status', 'verified')
            ->select('services.name', DB::raw('COUNT(*) as total_used'))
            ->groupBy('services.name')
            ->orderByDesc('total_used')
            ->take(5)
            ->get();

        // Kirim semua data analisis "Mata Dewa" ke Frontend Blade Super Admin
        return view('superadmin.dashboard', compact(
            'totalCeoEarnings',
            'globalOmset',
            'totalTransactions',
            'totalGlobalWeight',
            'topLaundries',
            'topServices'
        ));
    }
}