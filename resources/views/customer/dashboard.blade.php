@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Beranda')

@section('content')
@php
    $user   = auth()->user();
    $orders = $user->orders()->with(['service', 'payment'])->latest()->take(5)->get();
    
    // Perhitungan statistik utama
    $activeCount   = $user->orders()->whereNotIn('status', ['finished', 'cancelled'])->count();
    $finishedCount = $user->orders()->where('status', 'finished')->count();
    
    // Total belanja dari pembayaran yang sudah verified
    $totalSpent = $user->orders()
        ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
        ->with('payment')
        ->get()
        ->sum(fn($o) => $o->payment->amount ?? 0);
@endphp

<div class="space-y-6">

    {{-- ── Welcome Banner ─────────────────────────────────────────── --}}
    <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute right-12 bottom-0 w-24 h-24 bg-white/5 rounded-full translate-y-8"></div>
        <div class="relative">
            <p class="text-blue-100 text-sm mb-1">Selamat datang kembali,</p>
            <h2 class="text-2xl font-extrabold">{{ $user->name }} 👋</h2>
            <p class="text-blue-200 text-sm mt-1">Pakaian bersih siap dalam hitungan jam!</p>
            <a href="{{ route('customer.orders.create') }}"
               class="inline-flex items-center gap-2 mt-4 bg-white text-blue-600 font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-blue-50 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i> Order Sekarang
            </a>
        </div>
    </div>

    {{-- ── Stats ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        @php
            $stats = [
                ['label'=>'Order Aktif',    'value'=>$activeCount,   'icon'=>'loader',      'color'=>'blue'],
                ['label'=>'Selesai',        'value'=>$finishedCount, 'icon'=>'check-circle','color'=>'green'],
                ['label'=>'Total Belanja',  'value'=>'Rp '.number_format($totalSpent/1000,0).'k', 'icon'=>'wallet','color'=>'purple'],
            ];
            $sc = [
                'blue'   => 'bg-blue-50 text-blue-600',
                'green'  => 'bg-green-50 text-green-600',
                'purple' => 'bg-purple-50 text-purple-600'
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center shadow-sm">
            <div class="w-10 h-10 rounded-xl {{ $sc[$s['color']] }} flex items-center justify-center mx-auto mb-2">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5"></i>
            </div>
            <p class="text-xl font-extrabold text-gray-800">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Recent Orders ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Order Terakhir</h3>
            <a href="{{ route('customer.orders.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($orders as $order)
            @php 
                $badge = $order->getStatusBadge(); 
                
                $iconMap = [
                    'schedule'              => 'clock',
                    'water_drop'            => 'droplet',
                    'dry_cleaning'          => 'shirt',            
                    'local_laundry_service' => 'washing-machine', 
                    'iron'                  => 'iron',            
                    'flash_on'              => 'zap',             
                ];

                $dbIcon = $order->service->icon ?? 'shirt';
                $serviceIcon = $iconMap[$dbIcon] ?? str_replace('_', '-', $dbIcon);
            @endphp
            <a href="{{ route('customer.orders.show', $order) }}"
               class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="{{ $serviceIcon }}" class="w-5 h-5 text-blue-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 font-mono text-sm">{{ $order->order_code }}</p>
                    <p class="text-xs text-gray-400">{{ $order->service->name }} · {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="status-{{ $order->status }} text-xs px-2.5 py-1 rounded-full font-medium">
                        {{ $badge['label'] }}
                    </span>
                    @if($order->total_price > 0)
                    <p class="text-xs font-bold text-gray-700 mt-1">Rp {{ number_format($order->total_price,0,',','.') }}</p>
                    @endif
                </div>
            </a>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="shirt" class="w-8 h-8 text-blue-300"></i>
                </div>
                <p class="font-semibold text-gray-600">Belum ada order</p>
                <p class="text-sm text-gray-400 mt-1">Yuk, mulai order pertama kamu!</p>
                <a href="{{ route('customer.orders.create') }}"
                   class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i> Buat Order
                </a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── Quick Track ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i data-lucide="search" class="w-4 h-4 text-blue-500"></i>
            Lacak Order
        </h3>
        <form method="GET" action="{{ route('order.track') }}" class="flex gap-2" target="_blank">
            <input type="text" name="code" placeholder="Masukkan kode order (Contoh: LT-XXXX-XXXX)"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-50 text-blue-700 font-semibold px-4 py-2.5 rounded-xl text-sm hover:bg-blue-100 transition-colors">
                Track
            </button>
        </form>
    </div>
</div>
@endsection