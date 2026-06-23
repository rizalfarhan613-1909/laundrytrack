<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function downloadFinancialReport(Request $request)
    {
        // 1. Ambil filter tanggal dari URL (default ke bulan ini jika kosong)
        $from = $request->query('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->query('to', today()->format('Y-m-d'));

        // Ambil ID Toko dari Admin yang sedang login, atau dari parameter URL
        $laundryId = $request->query('laundry_id') ?? (auth()->check() ? auth()->user()->laundry_id : null);

        // 2. Ambil data transaksi utama (Kunci berdasarkan laundry_id)
        $ordersQuery = Order::with(['laundry', 'customer', 'payment', 'service'])
                            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        
        if ($laundryId) {
            $ordersQuery->where('laundry_id', $laundryId);
        }
        
        $orders = $ordersQuery->get();

        // 3. Kalkulasi Ringkasan (Summary Box)
        $totalRevenue = $orders->sum('total_price'); 
        $totalWeight = $orders->sum('weight_kg'); 
        $avgTransaction = $orders->avg('total_price');

        // Tambahan: Hitung total potongan komisi aplikasi 8% dari semua order terverifikasi
        $totalSystemFee = $orders->filter(function($o) {
            return $o->payment && $o->payment->status === 'verified';
        })->sum('system_fee');

        // Tambahan: Omset Bersih yang didapatkan toko bulanan ini
        $totalNetRevenue = $totalRevenue - $totalSystemFee;
        
        // 4. Hitung Uang Diterima (Hanya status 'finished' AND Status Pembayaran Harus 'verified')
        $realRevenueQuery = Order::where('status', 'finished')
                                 ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        
        if ($laundryId) {
            $realRevenueQuery->where('laundry_id', $laundryId);
        }
        
        $realRevenueQuery->whereHas('payment', function($q) {
            $q->where('status', 'verified'); 
        });
        
        $realRevenue = $realRevenueQuery->sum('total_price'); 

        // Tambahan: Hitung Potongan Komisi Khusus dari orderan yang cair/selesai tersebut
        $realSystemFee = $realRevenueQuery->sum('system_fee');

        // Tambahan: Uang diterima bersih nyata yang masuk ke rekening/laci toko laundry
        $realNetRevenue = $realRevenue - $realSystemFee;

        // 5. Statistik Metode Pembayaran (Kunci berdasarkan laundry_id)
        $paymentMethodsQuery = Order::join('payments', 'orders.id', '=', 'payments.order_id')
                            ->select('payments.method', DB::raw('count(*) as total'))
                            ->whereBetween('orders.created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        
        if ($laundryId) {
            $paymentMethodsQuery->where('orders.laundry_id', $laundryId);
        }
        
        $paymentMethodsQuery->where('payments.status', 'verified');

        $paymentMethods = $paymentMethodsQuery->groupBy('payments.method')->get();

        // 6. Performa Layanan (✨ FIX AMBIGUOUS: Tambah prefix 'orders.' agar SQL tidak bingung)
        $servicePerformanceQuery = Order::whereBetween('orders.created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                                ->where('orders.status', 'finished')
                                ->whereHas('payment', function($q) {
                                    $q->where('status', 'verified'); 
                                });
        
        if ($laundryId) {
            $servicePerformanceQuery->where('orders.laundry_id', $laundryId);
        }
        
        // Gabungkan dengan tabel services untuk menarik nama layanannya
        $servicePerformance = $servicePerformanceQuery->join('services', 'orders.service_id', '=', 'services.id')
                                ->select('services.name as service_name', DB::raw('sum(orders.total_price) as revenue'))
                                ->groupBy('services.name')
                                ->get();

        // 7. Kirim data ke PDF/View
        $data = [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalSystemFee' => $totalSystemFee,
            'totalNetRevenue' => $totalNetRevenue,
            'realRevenue' => $realRevenue, 
            'realSystemFee' => $realSystemFee,
            'realNetRevenue' => $realNetRevenue, 
            'totalWeight' => $totalWeight,
            'avgTransaction' => $avgTransaction,
            'paymentMethods' => $paymentMethods,
            'servicePerformance' => $servicePerformance,
            'date' => date('d-m-Y'),
            'period' => $from . ' s/d ' . $to
        ];

        $pdf = Pdf::loadView('pdf.financial-report', $data);
        return $pdf->download('Laporan-Keuangan-'.$from.'-'.$to.'.pdf');
    }
}