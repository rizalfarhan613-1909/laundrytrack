@extends('layouts.app')
@section('title', 'Manajemen Kurir')
@section('page-title', 'Manajemen Kurir')

@section('header-actions')
{{-- Toggle layanan kurir global --}}
<form method="POST" action="{{ route('admin.toggle.kurir') }}">
    @csrf
    <button type="submit"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all
                   {{ $kurirEnabled ? 'bg-green-100 text-green-700 hover:bg-green-200 border border-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 border border-gray-200' }}">
        <span class="w-2 h-2 rounded-full {{ $kurirEnabled ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
        Layanan Kurir: {{ $kurirEnabled ? 'AKTIF' : 'NONAKTIF' }}
    </button>
</form>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ── Info toggle ─────────────────────────────────────────────── --}}
    <div class="rounded-2xl border px-5 py-4 flex items-start gap-3
                {{ $kurirEnabled ? 'bg-green-50 border-green-100' : 'bg-amber-50 border-amber-100' }}">
        <i data-lucide="{{ $kurirEnabled ? 'truck' : 'truck-off' }}"
           class="w-5 h-5 flex-shrink-0 mt-0.5 {{ $kurirEnabled ? 'text-green-600' : 'text-amber-500' }}"></i>
        <div class="text-sm">
            @if($kurirEnabled)
                <p class="font-semibold text-green-800">Layanan kurir sedang <strong>AKTIF</strong>.</p>
                <p class="text-green-600 text-xs mt-0.5">Customer bisa memilih opsi "Jemput ke Rumah" saat membuat order.</p>
            @else
                <p class="font-semibold text-amber-800">Layanan kurir sedang <strong>NONAKTIF</strong>.</p>
                <p class="text-amber-600 text-xs mt-0.5">Opsi "Jemput" tidak muncul di halaman order customer. Aktifkan via tombol di atas.</p>
            @endif
        </div>
    </div>

    {{-- ── Grid: Stats + Order pending jemput ─────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Daftar kurir --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="font-bold text-gray-800">Daftar Kurir</h2>
                <span class="text-xs text-gray-400">{{ $kurirs->count() }} kurir terdaftar</span>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($kurirs as $kurir)
                @php
                    $activeCount   = $kurir->deliveries->whereIn('status', ['pickup'])->count();
                    $todayCount    = $kurir->deliveries->filter(fn($o) => $o->pickup_at?->isToday())->count();
                    $finishedTotal = $kurir->deliveries->where('status', 'finished')->count();
                @endphp
                <div class="px-6 py-4 flex items-start gap-4">

                    {{-- Avatar --}}
                    <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 font-extrabold text-lg
                                {{ $kurir->is_active ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-400' }}">
                        {{ strtoupper(substr($kurir->name, 0, 1)) }}
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="font-bold text-gray-800">{{ $kurir->name }}</p>
                            @if(!$kurir->is_active)
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Nonaktif</span>
                            @endif
                            @if($activeCount > 0)
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-semibold">
                                {{ $activeCount }} tugas aktif
                            </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $kurir->phone ?? 'HP belum diisi' }}</p>
                        <div class="flex gap-4 mt-1.5 text-xs text-gray-400">
                            <span>Hari ini: <strong class="text-gray-600">{{ $todayCount }}</strong></span>
                            <span>Total selesai: <strong class="text-gray-600">{{ $finishedTotal }}</strong></span>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex flex-col gap-1.5 flex-shrink-0">
                        <form method="POST" action="{{ route('admin.users.toggle', $kurir) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors w-full
                                           {{ $kurir->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                {{ $kurir->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <i data-lucide="users" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                    <p class="text-sm">Belum ada kurir terdaftar.</p>
                    <p class="text-xs mt-1">Tambah user dengan role "kurir" di halaman
                        <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline">Manajemen User</a>.
                    </p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Order jemput pending (belum diambil kurir) --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-50 flex items-center gap-2">
                <i data-lucide="package" class="w-4 h-4 text-amber-500"></i>
                <h2 class="font-bold text-gray-800 text-sm">Menunggu Kurir</h2>
                @if($pendingPickups->count())
                <span class="ml-auto bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $pendingPickups->count() }}
                </span>
                @endif
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingPickups as $order)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="font-mono text-xs font-bold text-gray-700">{{ $order->order_code }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $order->customer->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ Str::limit($order->pickup_address, 40) }}</p>
                            <p class="text-xs text-amber-500 mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Assign ke kurir tertentu --}}
                    <form method="POST" action="{{ route('kasir.orders.kurir', $order) }}" class="mt-2 flex gap-1">
                        @csrf @method('PATCH')
                        <select name="kurir_id"
                                class="flex-1 border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($kurirs->where('is_active', true) as $k)
                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <button class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-blue-700 font-medium">
                            Assign
                        </button>
                    </form>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-xs text-gray-400">
                    <i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 text-green-300"></i>
                    Semua order jemput sudah ditangani kurir.
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection