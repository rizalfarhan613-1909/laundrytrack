@extends('layouts.app')
@section('title', 'Detail Order ' . $order->order_code)
@section('page-title', 'Detail Order')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    <a href="{{ route('kurir.dashboard') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
    </a>

    {{-- ── Status Banner ───────────────────────────────────────── --}}
    @php $badge = $order->getStatusBadge(); @endphp
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-200 text-xs">No. Order</p>
                <p class="font-extrabold text-2xl font-mono mt-0.5">{{ $order->order_code }}</p>
            </div>
            <span class="bg-white/20 text-white text-sm px-3 py-1.5 rounded-xl font-semibold">
                {{ $badge['label'] }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-3 mt-4">
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Layanan</p>
                <p class="font-semibold text-sm mt-0.5">{{ $order->service->name }}</p>
            </div>
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Ditugaskan</p>
                <p class="font-semibold text-sm mt-0.5">{{ $order->pickup_at?->isoFormat('D MMM, HH:mm') ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- ── Info Customer ────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
            Info Customer
        </h3>
        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-extrabold text-lg flex-shrink-0">
                    {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-800">{{ $order->customer->name }}</p>
                    <p class="text-sm text-blue-600 font-mono">{{ $order->customer->phone }}</p>
                </div>
                @if($order->customer->phone)
                <a href="{{ $waLink }}" target="_blank"
                   class="ml-auto flex items-center gap-2 bg-green-600 text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-green-700 transition-colors">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    Chat WA
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Alamat Jemput ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-4 h-4 text-red-500"></i>
            Alamat Jemput
        </h3>
        <p class="text-gray-700 leading-relaxed">{{ $order->pickup_address }}</p>
        @if($order->pickup_note)
        <div class="mt-2 bg-amber-50 rounded-xl px-4 py-2.5 text-sm text-amber-700 flex items-start gap-2">
            <i data-lucide="message-square" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
            <span>{{ $order->pickup_note }}</span>
        </div>
        @endif
        <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}"
           target="_blank"
           class="mt-3 flex items-center justify-center gap-2 w-full bg-blue-50 text-blue-700 border border-blue-200 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-100 transition-colors">
            <i data-lucide="map" class="w-4 h-4"></i>
            Buka Google Maps
        </a>
    </div>

    {{-- ── Rincian Order ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="clipboard" class="w-4 h-4 text-blue-500"></i>
            Rincian Order
        </h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>Layanan</span>
                <span class="font-semibold">{{ $order->service->name }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Estimasi selesai</span>
                <span>{{ $order->service->estimated_days == 0 ? '6 jam' : $order->service->estimated_days . ' hari kerja' }}</span>
            </div>
            @if($order->weight_kg)
            <div class="flex justify-between text-gray-600">
                <span>Berat</span>
                <span class="font-semibold">{{ $order->weight_kg }} kg</span>
            </div>
            <div class="flex justify-between font-bold text-blue-700 text-base border-t border-gray-100 pt-2 mt-2">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            @else
            <div class="flex justify-between text-gray-400 italic">
                <span>Total</span>
                <span>Menunggu timbang kasir</span>
            </div>
            @endif
        </div>
        @if($order->notes)
        <div class="mt-3 bg-gray-50 rounded-xl px-4 py-2.5 text-xs text-gray-500">
            📝 Catatan customer: {{ $order->notes }}
        </div>
        @endif
    </div>

    {{-- ── Aksi (hanya jika status pickup) ─────────────────────── --}}
    @if($order->status === 'pickup')
    <div class="space-y-3">
        <form method="POST" action="{{ route('kurir.pickup.confirm', $order) }}">
            @csrf @method('PATCH')
            <button type="submit"
                    onclick="return confirm('Konfirmasi cucian sudah dijemput dan sedang dalam perjalanan ke laundry?')"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-colors text-sm">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                Konfirmasi Sudah Dijemput & Di Laundry
            </button>
        </form>

        <button onclick="document.getElementById('reject-section').classList.toggle('hidden')"
                class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-600 border border-red-200 py-2.5 rounded-xl text-sm font-medium hover:bg-red-100 transition-colors">
            <i data-lucide="x" class="w-4 h-4"></i>
            Tidak Bisa Menjemput — Lepas Tugas
        </button>

        <div id="reject-section" class="hidden bg-red-50 rounded-2xl p-4 border border-red-100">
            <form method="POST" action="{{ route('kurir.pickup.reject', $order) }}" class="space-y-3">
                @csrf @method('PATCH')
                <label class="block text-sm font-semibold text-red-700 mb-1">Alasan melepas tugas</label>
                <textarea name="reason" rows="2" placeholder="Motor mogok, kedaruratan, dll."
                          class="w-full border border-red-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none bg-white"></textarea>
                <button class="w-full bg-red-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-red-700">
                    Lepas Tugas Ini
                </button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection