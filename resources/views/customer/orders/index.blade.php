@extends('layouts.app')
@section('title', 'Riwayat Order')
@section('page-title', 'Riwayat Order')

@section('header-actions')
<a href="{{ route('customer.orders.create') }}"
   class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
    <i data-lucide="plus" class="w-4 h-4"></i> Order Baru
</a>
@endsection

@section('content')
<div class="space-y-3">

    {{-- Filter Status --}}
    <div class="flex gap-2 flex-wrap">
        @foreach(['all'=>'Semua','pending'=>'Pending','in_process'=>'Diproses','ready'=>'Siap','finished'=>'Selesai'] as $key=>$label)
        <a href="{{ route('customer.orders.index', ['status'=>$key]) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                  {{ request('status',$key==='all'?'all':'x') === $key || (!request('status') && $key==='all') ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Orders List --}}
    @forelse($orders as $order)
    @php $badge = $order->getStatusBadge(); @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
        <a href="{{ route('customer.orders.show', $order) }}" class="block">
            <div class="flex items-start gap-4 p-5">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="{{ $order->service->icon ?? 'shirt' }}" class="w-5 h-5 text-blue-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-bold text-gray-800 font-mono text-sm">{{ $order->order_code }}</p>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $order->service->name }}</p>
                        </div>
                        <span class="status-{{ $order->status }} text-xs px-2.5 py-1 rounded-full font-medium flex-shrink-0">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <i data-lucide="{{ $order->pickup_type === 'jemput' ? 'truck' : 'user' }}" class="w-3 h-3"></i>
                            {{ $order->pickup_type === 'jemput' ? 'Jemput' : 'Antar Sendiri' }}
                        </span>
                        <span>{{ $order->created_at->isoFormat('D MMM Y, HH:mm') }}</span>
                        @if($order->weight_kg)
                        <span class="font-semibold text-blue-600">Rp {{ number_format($order->total_price,0,',','.') }}</span>
                        @else
                        <span class="italic">Menunggu timbang</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Payment status bar --}}
            @if($order->payment)
            <div class="border-t border-gray-50 px-5 py-2.5 flex items-center gap-2 bg-gray-50">
                @if($order->payment->isVerified())
                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-green-500"></i>
                    <span class="text-xs text-green-600 font-medium">Lunas · {{ strtoupper($order->payment->method) }}</span>
                @elseif($order->payment->status === 'rejected')
                    <i data-lucide="x-circle" class="w-3.5 h-3.5 text-red-500"></i>
                    <span class="text-xs text-red-600 font-medium">Pembayaran ditolak</span>
                @else
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span class="text-xs text-amber-600 font-medium">Menunggu verifikasi pembayaran</span>
                @endif
            </div>
            @elseif($order->weight_kg && $order->status !== 'finished' && $order->status !== 'cancelled')
            <div class="border-t border-gray-50 px-5 py-2.5 flex items-center justify-between bg-amber-50">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span class="text-xs text-amber-700 font-medium">Belum dibayar · Rp {{ number_format($order->total_price,0,',','.') }}</span>
                </div>
                <span class="text-xs text-amber-600 font-semibold">Bayar →</span>
            </div>
            @endif
        </a>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i data-lucide="inbox" class="w-8 h-8 text-blue-200"></i>
        </div>
        <p class="font-semibold text-gray-600">Tidak ada order</p>
        <p class="text-sm text-gray-400 mt-1">Buat order pertama kamu sekarang!</p>
        <a href="{{ route('customer.orders.create') }}"
           class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700">
            <i data-lucide="plus" class="w-4 h-4"></i> Order Sekarang
        </a>
    </div>
    @endforelse

    @if($orders->hasPages())
    <div class="pt-2">{{ $orders->links() }}</div>
    @endif
</div>
@endsection