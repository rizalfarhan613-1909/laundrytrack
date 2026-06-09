@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('header-actions')
    {{-- Kurir Toggle --}}
    <form method="POST" action="{{ route('admin.toggle.kurir') }}">
        @csrf
        <button type="submit"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all
                   {{ $kurirEnabled ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
            <i data-lucide="{{ $kurirEnabled ? 'truck' : 'truck' }}" class="w-4 h-4"></i>
            Kurir: {{ $kurirEnabled ? 'AKTIF' : 'NONAKTIF' }}
            <span class="w-2 h-2 rounded-full {{ $kurirEnabled ? 'bg-green-500 pulse-ring' : 'bg-gray-400' }}"></span>
        </button>
    </form>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ── KPI Cards ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $kpis = [
            ['label' => 'Pemasukan Hari Ini', 'value' => 'Rp ' . number_format($dailyRevenue,0,',','.'), 'icon' => 'banknote',       'color' => 'blue',   'sub' => 'Total terkonfirmasi'],
            ['label' => 'Order Hari Ini',      'value' => $dailyOrders,    'icon' => 'shopping-bag',    'color' => 'purple', 'sub' => 'Order masuk'],
            ['label' => 'Order Aktif',         'value' => $activeOrders,   'icon' => 'loader',          'color' => 'amber',  'sub' => 'Sedang diproses'],
            ['label' => 'Stok Menipis',        'value' => $lowInventories->count(), 'icon' => 'alert-triangle', 'color' => 'red', 'sub' => 'Perlu restock'],
        ];
        $colorMap = ['blue'=>'bg-blue-50 text-blue-600','purple'=>'bg-purple-50 text-purple-600','amber'=>'bg-amber-50 text-amber-600','red'=>'bg-red-50 text-red-600'];
        @endphp

        @foreach($kpis as $kpi)
        <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 mb-1">{{ $kpi['label'] }}</p>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $kpi['value'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $kpi['sub'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl {{ $colorMap[$kpi['color']] }} flex items-center justify-center flex-shrink-0">
                    <i data-lucide="{{ $kpi['icon'] }}" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Revenue Chart ──────────────────────────────────────── --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-bold text-gray-800">Pemasukan 7 Hari Terakhir</h2>
                    <p class="text-xs text-gray-400">Pembayaran terverifikasi</p>
                </div>
                <i data-lucide="trending-up" class="w-5 h-5 text-blue-400"></i>
            </div>

            {{-- Simple Bar Chart with CSS --}}
            @php
                $maxRevenue = max(array_values($revenueChart) ?: [1]);
            @endphp
            <div class="flex items-end gap-2 h-40">
                @foreach($revenueChart as $date => $amount)
                @php
                    $pct = $maxRevenue > 0 ? ($amount / $maxRevenue) * 100 : 0;
                    $label = \Carbon\Carbon::parse($date)->isoFormat('ddd');
                    $isToday = $date === today()->format('Y-m-d');
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-xs text-gray-400">{{ $amount > 0 ? 'Rp'.number_format($amount/1000,0).'k' : '' }}</span>
                    <div class="w-full rounded-t-lg transition-all duration-500 {{ $isToday ? 'bg-blue-500' : 'bg-blue-100' }}"
                         style="height: {{ max(4, $pct * 0.9) }}%"></div>
                    <span class="text-xs {{ $isToday ? 'font-bold text-blue-600' : 'text-gray-400' }}">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Order Status Donut ──────────────────────────────────── --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Status Order</h2>
            @php
            $statusConfig = [
                'pending'    => ['label'=>'Pending',    'color'=>'bg-amber-400'],
                'pickup'     => ['label'=>'Dijemput',   'color'=>'bg-blue-400'],
                'in_process' => ['label'=>'Diproses',   'color'=>'bg-purple-400'],
                'ready'      => ['label'=>'Siap',       'color'=>'bg-green-400'],
                'finished'   => ['label'=>'Selesai',    'color'=>'bg-gray-300'],
            ];
            $total = $orderStats->sum() ?: 1;
            @endphp
            <div class="space-y-3">
                @foreach($statusConfig as $key => $cfg)
                @php $count = $orderStats[$key] ?? 0; $pct = round($count/$total*100); @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-medium text-gray-600">{{ $cfg['label'] }}</span>
                        <span class="text-gray-400">{{ $count }}</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="{{ $cfg['color'] }} h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Recent Orders ────────────────────────────────────────── --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                <h2 class="font-bold text-gray-800">Order Terbaru</h2>
                <a href="{{ route('kasir.dashboard') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                @php $badge = $order->getStatusBadge(); @endphp
                <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shirt" class="w-4 h-4 text-blue-500"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $order->order_code }}</p>
                        <p class="text-xs text-gray-400">{{ $order->customer->name }} · {{ $order->service->name }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="status-{{ $order->status }} text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $badge['label'] }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-400 text-sm">
                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                    Belum ada order hari ini.
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── Sidebar: Inventory Alerts + Pending Payments ─────────── --}}
        <div class="space-y-4">
            {{-- Inventory Low Alert --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Stok Menipis</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($lowInventories as $item)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $item->name }}</p>
                            <p class="text-xs text-red-500">{{ $item->stock }} {{ $item->unit }} tersisa</p>
                        </div>
                        <a href="{{ route('admin.inventory.index') }}"
                           class="text-xs bg-amber-50 text-amber-700 px-2 py-1 rounded-lg hover:bg-amber-100">Restock</a>
                    </div>
                    @empty
                    <div class="px-5 py-6 text-center text-xs text-gray-400">
                        <i data-lucide="check-circle" class="w-6 h-6 mx-auto mb-1 text-green-400"></i>
                        Semua stok aman ✓
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Payments --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50 flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4 text-blue-500"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Bukti Transfer Masuk</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($pendingPayments as $payment)
                    <div class="px-5 py-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $payment->order->order_code }}</p>
                                <p class="text-xs text-gray-400">{{ $payment->order->customer->name }}</p>
                                <p class="text-xs font-semibold text-blue-600">Rp {{ number_format($payment->amount,0,',','.') }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <form method="POST" action="{{ route('kasir.payments.verify', $payment) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action" value="verify">
                                    <button class="w-full text-xs bg-green-100 text-green-700 px-2 py-1 rounded-lg hover:bg-green-200">✓ Verif</button>
                                </form>
                                <form method="POST" action="{{ route('kasir.payments.verify', $payment) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action" value="reject">
                                    <button class="w-full text-xs bg-red-100 text-red-700 px-2 py-1 rounded-lg hover:bg-red-200">✗ Tolak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-6 text-center text-xs text-gray-400">
                        Tidak ada pembayaran pending.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
