<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        @page { margin: 30px 40px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #1f2937; line-height: 1.4; }
        
        /* Header Styling */
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 12px; }
        
        /* Summary Box Styling */
        .summary-container { width: 100%; margin-bottom: 25px; border-collapse: separate; border-spacing: 10px 0; }
        .summary-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; text-align: center; width: 18%; vertical-align: top; }
        .summary-card span.title { display: block; font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .summary-card span.value { display: block; font-size: 15px; font-weight: bold; color: #0f172a; margin-bottom: 3px; }
        .summary-card span.note { display: block; font-size: 9px; }
        .text-red { color: #dc2626; }
        .text-green { color: #16a34a; }
        
        /* Sections & Tables */
        .section-title { font-size: 14px; color: #1e40af; border-bottom: 1px solid #bfdbfe; padding-bottom: 5px; margin-top: 25px; margin-bottom: 10px; font-weight: bold; text-transform: uppercase;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 10px; text-align: left; }
        th { background-color: #2563eb; color: #ffffff; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        /* Footer */
        .footer { margin-top: 40px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>Laporan Keuangan LaundryTrack</h1>
        <p><strong>Periode Laporan:</strong> {{ $period }} | <strong>Dicetak Pada:</strong> {{ $date }}</p>
    </div>

    <table class="summary-container">
        <tr>
            <td class="summary-card">
                <span class="title">Total Omset</span>
                <span class="value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</span>
                <span class="note text-gray">(Semua Kotor)</span>
            </td>
            <td class="summary-card">
                <span class="title">Potongan SaaS</span>
                <span class="value">Rp {{ number_format($totalSystemFee ?? 0, 0, ',', '.') }}</span>
                <span class="note text-red">(Komisi 8%)</span>
            </td>
            <td class="summary-card" style="background: #f0fdf4; border-color: #bbf7d0;">
                <span class="title">Pendapatan Bersih</span>
                <span class="value text-green">Rp {{ number_format($realNetRevenue ?? 0, 0, ',', '.') }}</span>
                <span class="note text-green">(Selesai & Lunas)</span>
            </td>
            <td class="summary-card">
                <span class="title">Total Berat</span>
                <span class="value">{{ $totalWeight ?? 0 }} Kg</span>
                <span class="note text-gray">Kapasitas Cuci</span>
            </td>
            <td class="summary-card">
                <span class="title">Rata-Rata/Order</span>
                <span class="value">Rp {{ number_format($avgTransaction ?? 0, 0, ',', '.') }}</span>
                <span class="note text-gray">Per Transaksi</span>
            </td>
        </tr>
    </table>

    @php
        // 1. Grouping Mingguan
        $weeklyData = collect($orders)->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->startOfWeek()->format('d M') . ' - ' . \Carbon\Carbon::parse($date->created_at)->endOfWeek()->format('d M Y');
        });

        // 2. Grouping Bulanan
        $monthlyData = collect($orders)->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->translatedFormat('F Y');
        });

        // 3. Grouping Tahunan
        $yearlyData = collect($orders)->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y');
        });
    @endphp

    <div class="section-title">📊 Rekapitulasi Berdasarkan Waktu</div>
    
    <h3 style="font-size: 12px; color: #475569; margin-bottom: 5px;">A. Pemasukan Mingguan</h3>
    <table>
        <thead>
            <tr>
                <th>Periode Minggu</th>
                <th class="text-right">Jml Order</th>
                <th class="text-right">Omset (Gross)</th>
                <th class="text-right">Potongan Aplikasi</th>
                <th class="text-right">Bersih (Netto)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($weeklyData as $week => $weekOrders)
                @php
                    $wTotal = $weekOrders->sum('total_price');
                    $wFee = $weekOrders->sum(function($o) {
                        return ($o->payment && $o->payment->status === 'verified') ? ($o->system_fee ?? 0) : 0;
                    });
                    $wNetto = $wTotal - $wFee;
                @endphp
                <tr>
                    <td>{{ $week }}</td>
                    <td class="text-right">{{ $weekOrders->count() }}</td>
                    <td class="text-right">Rp {{ number_format($wTotal, 0, ',', '.') }}</td>
                    <td class="text-right text-red">- Rp {{ number_format($wFee, 0, ',', '.') }}</td>
                    <td class="text-right font-bold text-green">Rp {{ number_format($wNetto, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="font-size: 12px; color: #475569; margin-bottom: 5px;">B. Pemasukan Bulanan</h3>
    <table>
        <thead>
            <tr>
                <th>Periode Bulan</th>
                <th class="text-right">Jml Order</th>
                <th class="text-right">Omset (Gross)</th>
                <th class="text-right">Potongan Aplikasi</th>
                <th class="text-right">Bersih (Netto)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $month => $monthOrders)
                @php
                    $mTotal = $monthOrders->sum('total_price');
                    $mFee = $monthOrders->sum(function($o) {
                        return ($o->payment && $o->payment->status === 'verified') ? ($o->system_fee ?? 0) : 0;
                    });
                    $mNetto = $mTotal - $mFee;
                @endphp
                <tr>
                    <td>{{ $month }}</td>
                    <td class="text-right">{{ $monthOrders->count() }}</td>
                    <td class="text-right">Rp {{ number_format($mTotal, 0, ',', '.') }}</td>
                    <td class="text-right text-red">- Rp {{ number_format($mFee, 0, ',', '.') }}</td>
                    <td class="text-right font-bold text-green">Rp {{ number_format($mNetto, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="font-size: 12px; color: #475569; margin-bottom: 5px;">C. Pemasukan Tahunan</h3>
    <table>
        <thead>
            <tr>
                <th>Periode Tahun</th>
                <th class="text-right">Jml Order</th>
                <th class="text-right">Omset (Gross)</th>
                <th class="text-right">Potongan Aplikasi</th>
                <th class="text-right">Bersih (Netto)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yearlyData as $year => $yearOrders)
                @php
                    $yTotal = $yearOrders->sum('total_price');
                    $yFee = $yearOrders->sum(function($o) {
                        return ($o->payment && $o->payment->status === 'verified') ? ($o->system_fee ?? 0) : 0;
                    });
                    $yNetto = $yTotal - $yFee;
                @endphp
                <tr>
                    <td>{{ $year }}</td>
                    <td class="text-right">{{ $yearOrders->count() }}</td>
                    <td class="text-right">Rp {{ number_format($yTotal, 0, ',', '.') }}</td>
                    <td class="text-right text-red">- Rp {{ number_format($yFee, 0, ',', '.') }}</td>
                    <td class="text-right font-bold text-green">Rp {{ number_format($yNetto, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="section-title">📝 Riwayat Detail Transaksi</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Order</th>
                <th>Layanan</th>
                <th>Status</th>
                <th class="text-right">Kotor (Gross)</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Bersih (Netto)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            @php
                $isVerified = $order->payment && $order->payment->status === 'verified';
                $fee = $isVerified ? ($order->system_fee ?? 0) : 0;
                $netto = $order->total_price - $fee;
            @endphp
            <tr>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $order->order_code }}</strong></td>
                <td>{{ $order->service->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-red">Rp {{ number_format($fee, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-green">Rp {{ number_format($netto, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dibuat otomatis oleh Sistem LaundryTrack pada {{ date('d F Y, H:i') }} WIB.
    </div>

</body>
</html>