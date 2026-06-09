@extends('layouts.app')
@section('title', 'Dashboard Kurir')
@section('page-title', 'Dashboard Kurir')

@section('content')
<div class="space-y-6">

    {{-- ── Selamat datang + stat bar ────────────────────────────────── --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 w-48 h-48 bg-white/5 rounded-full -translate-y-20 translate-x-20"></div>
        <div class="relative">
            <p class="text-blue-200 text-sm">Selamat datang,</p>
            <h2 class="text-2xl font-extrabold">{{ auth()->user()->name }} 🛵</h2>
            <p class="text-blue-200 text-xs mt-1">{{ auth()->user()->phone ?? 'Nomor HP belum diisi' }}</p>

            <div class="grid grid-cols-3 gap-4 mt-5">
                @php
                $badges = [
                    ['label' => 'Pickup Hari Ini', 'value' => $todayStats['pickup'],   'icon' => 'truck'],
                    ['label' => 'Selesai Hari Ini', 'value' => $todayStats['finished'], 'icon' => 'check-circle'],
                    ['label' => 'Total Semua',      'value' => $todayStats['total_all'],'icon' => 'list'],
                ];
                @endphp
                @foreach($badges as $b)
                <div class="bg-white/10 rounded-xl p-3 text-center backdrop-blur-sm">
                    <p class="text-2xl font-extrabold">{{ $b['value'] }}</p>
                    <p class="text-blue-200 text-xs mt-0.5">{{ $b['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Alert jika nomor HP belum diisi (WA tidak bisa kirim) ───── --}}
    @if(!auth()->user()->phone)
    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-center gap-3">
        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500 flex-shrink-0"></i>
        <div class="flex-1 text-sm">
            <p class="font-semibold text-amber-800">Nomor HP belum diisi!</p>
            <p class="text-amber-600 text-xs mt-0.5">Notifikasi WhatsApp ke kamu tidak akan berfungsi. Isi nomor HP di halaman profil.</p>
        </div>
        <a href="{{ route('kurir.profile') }}"
           class="flex-shrink-0 bg-amber-500 text-white text-xs font-semibold px-3 py-1.5 rounded-xl hover:bg-amber-600 transition-colors">
            Isi Sekarang
        </a>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         BAGIAN 1 — TUGAS AKTIF (yang sedang kamu tangani)
    ═══════════════════════════════════════════════════════════════ --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="navigation" class="w-5 h-5 text-blue-500"></i>
                Tugas Aktif Kamu
                @if($myActiveOrders->count())
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $myActiveOrders->count() }}
                </span>
                @endif
            </h2>
            <a href="{{ route('kurir.history') }}" class="text-xs text-blue-600 hover:underline">
                Lihat riwayat →
            </a>
        </div>

        @forelse($myActiveOrders as $order)
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden mb-3">

            {{-- Header card --}}
            <div class="bg-blue-50 px-5 py-3 flex items-center justify-between border-b border-blue-100">
                <div class="flex items-center gap-2">
                    <span class="font-mono text-sm font-bold text-blue-800">{{ $order->order_code }}</span>
                    <span class="status-pickup text-xs px-2 py-0.5 rounded-full font-medium">Dijemput</span>
                </div>
                <span class="text-xs text-blue-500">{{ $order->pickup_at?->diffForHumans() }}</span>
            </div>

            <div class="p-5">
                <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">

                    {{-- Info customer & alamat --}}
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-700 font-bold">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $order->customer->name }}</p>
                                <p class="text-sm text-blue-600 font-mono">{{ $order->customer->phone }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-3 text-sm">
                            <p class="flex items-start gap-2 text-gray-700">
                                <i data-lucide="map-pin" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5"></i>
                                <span>{{ $order->pickup_address }}</span>
                            </p>
                            @if($order->pickup_note)
                            <p class="flex items-center gap-2 text-gray-400 text-xs mt-1.5">
                                <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                {{ $order->pickup_note }}
                            </p>
                            @endif
                        </div>

                        <p class="text-xs text-gray-400 flex items-center gap-1.5">
                            <i data-lucide="shirt" class="w-3.5 h-3.5"></i>
                            {{ $order->service->name }}
                        </p>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex flex-col gap-2 min-w-[150px] w-full sm:w-auto">

                        {{-- Chat WA ke customer --}}
                        @if($order->customer->phone)
                        <a href="{{ app(\App\Services\WhatsAppService::class)->kurirToCustomerLink($order) }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            Chat WA Customer
                        </a>
                        @endif

                        {{-- Lihat di Maps --}}
                        @if($order->pickup_address)
                        <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors border border-blue-200">
                            <i data-lucide="map" class="w-4 h-4"></i>
                            Buka di Maps
                        </a>
                        @endif

                        {{-- Konfirmasi sudah dijemput --}}
                        <form method="POST" action="{{ route('kurir.pickup.confirm', $order) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Konfirmasi cucian sudah dijemput dan kamu sedang menuju laundry?')"
                                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Sudah Dijemput ✓
                            </button>
                        </form>

                        {{-- Lepas tugas (jika tidak bisa menjemput) --}}
                        <button onclick="showRejectModal({{ $order->id }}, '{{ $order->order_code }}')"
                                class="flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium px-4 py-2 rounded-xl transition-colors border border-red-200">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            Lepas Tugas
                        </button>
                    </div>
                </div>
            </div>

            {{-- Detail order link --}}
            <div class="border-t border-gray-50 px-5 py-2.5 bg-gray-50">
                <a href="{{ route('kurir.order.detail', $order) }}"
                   class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                    <i data-lucide="external-link" class="w-3 h-3"></i>
                    Lihat detail order lengkap
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-circle" class="w-8 h-8 text-green-400"></i>
            </div>
            <p class="font-semibold text-gray-600">Tidak ada tugas aktif</p>
            <p class="text-sm text-gray-400 mt-1">Ambil order dari daftar di bawah!</p>
        </div>
        @endforelse
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         BAGIAN 2 — ORDER TERSEDIA (belum ada yang ambil)
    ═══════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i data-lucide="package" class="w-5 h-5 text-amber-500"></i>
            Order Jemput Tersedia
            @if($availableOrders->count())
            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                {{ $availableOrders->count() }} baru
            </span>
            @endif
        </h2>

        @forelse($availableOrders as $order)
        <div class="bg-white rounded-2xl border border-amber-100 overflow-hidden mb-3 hover:shadow-md transition-shadow">
            <div class="p-5 flex flex-col sm:flex-row gap-4 items-start justify-between">

                <div class="flex-1 space-y-2">
                    {{-- Order code & waktu --}}
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-sm font-bold text-gray-800">{{ $order->order_code }}</span>
                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">
                            {{ $order->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Customer --}}
                    <p class="font-semibold text-gray-700">{{ $order->customer->name }}</p>

                    {{-- Alamat --}}
                    <p class="text-sm text-gray-500 flex items-start gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5"></i>
                        {{ $order->pickup_address }}
                    </p>

                    @if($order->pickup_note)
                    <p class="text-xs text-gray-400">📝 {{ $order->pickup_note }}</p>
                    @endif

                    {{-- Info layanan --}}
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <i data-lucide="shirt" class="w-3.5 h-3.5"></i>
                            {{ $order->service->name }}
                        </span>
                        <span>·</span>
                        <span>Est. {{ $order->service->estimated_days == 0 ? '6 jam' : $order->service->estimated_days . ' hari' }}</span>
                    </div>
                </div>

                {{-- Tombol ambil --}}
                <div class="flex flex-col gap-2 min-w-[140px]">
                    {{-- Lihat lokasi dulu --}}
                    <a href="https://maps.google.com/?q={{ urlencode($order->pickup_address) }}"
                       target="_blank"
                       class="flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-medium px-3 py-2 rounded-xl border border-gray-200 transition-colors">
                        <i data-lucide="map" class="w-3.5 h-3.5"></i>
                        Cek Lokasi
                    </a>

                    {{-- Ambil tugas --}}
                    <form method="POST" action="{{ route('kurir.pickup.accept', $order) }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                            Ambil Tugas
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i data-lucide="inbox" class="w-8 h-8 text-gray-300"></i>
            </div>
            <p class="font-semibold text-gray-500">Belum ada order jemput</p>
            <p class="text-sm text-gray-400 mt-1">Halaman otomatis refresh setiap 60 detik.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ── Modal lepas tugas ─────────────────────────────────────────── --}}
<div id="reject-modal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Lepas Tugas</h3>
            <p class="text-sm text-gray-400 mt-1" id="reject-order-label">Order ...</p>
        </div>
        <form id="reject-form" method="POST" action="" class="p-6 space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alasan (opsional)</label>
                <textarea name="reason" rows="3"
                          placeholder="Contoh: Motor mogok, ban bocor, kedaruratan keluarga..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                <p class="text-xs text-gray-400 mt-1">Order akan kembali ke antrian dan bisa diambil kurir lain.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="hideRejectModal()"
                        class="flex-1 bg-gray-100 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-red-700">
                    Ya, Lepas Tugas
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Modal lepas tugas
function showRejectModal(orderId, orderCode) {
    document.getElementById('reject-order-label').textContent = 'Order: ' + orderCode;
    document.getElementById('reject-form').action = '/kurir/orders/' + orderId + '/reject';
    document.getElementById('reject-modal').classList.remove('hidden');
}
function hideRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
}

// Auto-refresh setiap 60 detik untuk update daftar order tersedia
let countdown = 60;
const refreshTimer = setInterval(() => {
    countdown--;
    if (countdown <= 0) {
        window.location.reload();
    }
}, 1000);

// Refresh saat tab aktif kembali
document.addEventListener('visibilitychange', () => {
    if (!document.hidden) window.location.reload();
});
</script>
@endpush
@endsection