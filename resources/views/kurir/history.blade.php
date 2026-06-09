@extends('layouts.app')
@section('title', 'Riwayat Tugas')
@section('page-title', 'Riwayat Tugas')

@section('content')
<div class="space-y-5">

    {{-- ── Statistik ──────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php
        $statCards = [
            ['label' => 'Total Semua',       'value' => $stats['total'],    'color' => 'blue',   'icon' => 'list'],
            ['label' => 'Total Selesai',      'value' => $stats['finished'], 'color' => 'green',  'icon' => 'check-circle'],
            ['label' => 'Hari Ini',           'value' => $stats['today'],    'color' => 'amber',  'icon' => 'sun'],
            ['label' => 'Bulan Ini',          'value' => $stats['month'],    'color' => 'purple', 'icon' => 'calendar'],
        ];
        $sc = [
            'blue'   => 'bg-blue-50 text-blue-600',
            'green'  => 'bg-green-50 text-green-600',
            'amber'  => 'bg-amber-50 text-amber-600',
            'purple' => 'bg-purple-50 text-purple-600',
        ];
        @endphp
        @foreach($statCards as $s)
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $sc[$s['color']] }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xl font-extrabold text-gray-800">{{ $s['value'] }}</p>
                <p class="text-xs text-gray-400">{{ $s['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filter & Search ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap gap-3 items-center justify-between">
        <div class="flex gap-2 flex-wrap">
            @foreach(['all' => 'Semua', 'today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini'] as $key => $label)
            <a href="{{ route('kurir.history', ['filter' => $key, 'search' => $search]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors
                      {{ $filter === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('kurir.history') }}" class="flex gap-2">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari kode / nama..."
                   class="border border-gray-200 rounded-xl px-4 py-2 text-xs w-44 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-xs font-medium">Cari</button>
        </form>
    </div>

    {{-- ── Tabel Riwayat ────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Order</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Customer</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Layanan</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Dijemput</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                @php $badge = $order->getStatusBadge(); @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('kurir.order.detail', $order) }}"
                           class="font-mono text-sm font-bold text-blue-600 hover:underline">
                            {{ $order->order_code }}
                        </a>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->isoFormat('D MMM Y') }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-medium text-gray-700">{{ $order->customer->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->customer->phone }}</p>
                    </td>
                    <td class="px-4 py-4 text-gray-600">{{ $order->service->name }}</td>
                    <td class="px-4 py-4 text-gray-400 text-xs">
                        {{ $order->pickup_at?->isoFormat('D MMM, HH:mm') ?? '—' }}
                    </td>
                    <td class="px-4 py-4">
                        <span class="status-{{ $order->status }} text-xs px-2.5 py-1 rounded-full font-medium">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                        <p>Belum ada riwayat untuk periode ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection