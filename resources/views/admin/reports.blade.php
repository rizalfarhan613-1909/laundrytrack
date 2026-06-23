@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Keuangan')

@section('content')
<div class="space-y-6">

    {{-- ── Date Filter ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ $from }}"
                       class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ $to }}"
                       class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Quick Ranges --}}
            <div class="flex gap-2">
                @php
                $presets = [
                    'Hari ini'  => [today()->format('Y-m-d'), today()->format('Y-m-d')],
                    '7 Hari'    => [now()->subDays(6)->format('Y-m-d'), today()->format('Y-m-d')],
                    'Bulan Ini' => [now()->startOfMonth()->format('Y-m-d'), today()->format('Y-m-d')],
                ];
                @endphp
                @foreach($presets as $label => [$pFrom, $pTo])
                <a href="{{ route('admin.reports', ['from'=>$pFrom, 'to'=>$pTo]) }}"
                   class="text-xs px-3 py-2.5 rounded-xl border transition-colors
                          {{ $from === $pFrom && $to === $pTo ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <button class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Tampilkan
            </button>

            {{-- New Export Button --}}
            <a href="{{ route('admin.reports.export', ['from' => $from, 'to' => $to]) }}" 
               class="bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Export PDF
            </a>
        </form>
    </div>

    {{-- ── Summary KPIs ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php
        $kpis = [
            ['label'=>'Total Pemasukan',    'value'=>'Rp '.number_format($revenue,0,',','.'),        'icon'=>'banknote',    'color'=>'blue'],
            ['label'=>'Total Order',        'value'=>$totalOrders,                                   'icon'=>'shopping-bag','color'=>'purple'],
            ['label'=>'Order Selesai',      'value'=>$finishedOrders . ' / ' . $totalOrders,         'icon'=>'check-circle','color'=>'green'],
        ];
        $kc = ['blue'=>['bg'=>'bg-blue-50','text'=>'text-blue-600'],
               'purple'=>['bg'=>'bg-purple-50','text'=>'text-purple-600'],
               'green'=>['bg'=>'bg-green-50','text'=>'text-green-600']];
        @endphp
        @foreach($kpis as $k)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $kc[$k['color']]['bg'] }} {{ $kc[$k['color']]['text'] }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="{{ $k['icon'] }}" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">{{ $k['label'] }}</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $k['value'] }}</p>
                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($from)->isoFormat('D MMM') }} – {{ \Carbon\Carbon::parse($to)->isoFormat('D MMM Y') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Daily Revenue Chart ─────────────────────────────────── --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-5">Pemasukan Harian</h2>
            @if($dailyRevenue->isEmpty())
                <div class="py-16 text-center text-gray-300">
                    <i data-lucide="bar-chart-2" class="w-10 h-10 mx-auto mb-2"></i>
                    <p class="text-sm">Tidak ada data pada periode ini</p>
                </div>
            @else
            @php $maxR = $dailyRevenue->max('total') ?: 1; @endphp
            <div class="overflow-x-auto pb-2">
                {{-- PERBAIKAN: Menambahkan item-end dan pada child div di set h-full justify-end --}}
                <div class="flex items-end gap-3 h-48 min-w-max pt-4">
                    @foreach($dailyRevenue as $row)
                    @php $pct = ($row->total / $maxR) * 100; @endphp
                    <div class="flex flex-col items-center justify-end h-full gap-1.5 w-12 group cursor-pointer">
                        <span class="text-[10px] font-medium text-gray-400 group-hover:text-blue-600 transition-colors">{{ 'Rp'.number_format($row->total/1000,0).'k' }}</span>
                        {{-- PERBAIKAN: Tinggi balok akan dirender sempurna sekarang --}}
                        <div class="w-full bg-blue-500 rounded-t-lg transition-all group-hover:bg-blue-600" style="height: {{ max(4, $pct * 0.85) }}%"></div>
                        <span class="text-[10px] font-semibold text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($row->date)->format('d/m') }}</span>
                        <span class="text-[9px] text-gray-400">{{ $row->count }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ── Service Breakdown ───────────────────────────────────── --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Breakdown Layanan</h2>
            @php $totalSvc = $serviceStats->sum('total') ?: 1; @endphp
            <div class="space-y-4">
                @forelse($serviceStats as $svc)
                @php $pct = round($svc->total / $totalSvc * 100); @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700 truncate">{{ $svc->service->name ?? 'N/A' }}</span>
                        <span class="text-gray-400 ml-2 flex-shrink-0">{{ $svc->total }} order ({{ $pct }}%)</span>
                    </div>
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-8">Tidak ada data.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Daily Table ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-bold text-gray-800">Detail Harian</h2>
            <span class="text-xs text-gray-400">{{ $dailyRevenue->count() }} hari</span>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jumlah Order</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total Pemasukan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($dailyRevenue as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-gray-700">{{ \Carbon\Carbon::parse($row->date)->isoFormat('dddd, D MMMM Y') }}</td>
                    <td class="px-6 py-3 text-right text-gray-600">{{ $row->count }} transaksi</td>
                    <td class="px-6 py-3 text-right font-bold text-blue-600">Rp {{ number_format($row->total,0,',','.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-gray-400 text-sm">Tidak ada data pada periode ini.</td>
                </tr>
                @endforelse
                @if($dailyRevenue->isNotEmpty())
                <tr class="bg-blue-50">
                    <td class="px-6 py-3 font-bold text-blue-800">TOTAL</td>
                    <td class="px-6 py-3 text-right font-bold text-blue-800">{{ $dailyRevenue->sum('count') }} transaksi</td>
                    <td class="px-6 py-3 text-right font-extrabold text-blue-700 text-base">Rp {{ number_format($revenue,0,',','.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection