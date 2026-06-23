@extends('layouts.app')
@section('title', 'Detail Order ' . $order->order_code)
@section('page-title', 'Detail Order')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    <a href="{{ route('customer.orders.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>

    {{-- ── Order Header ────────────────────────────────────────────── --}}
    @php $badge = $order->getStatusBadge(); @endphp
    <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-blue-200 text-xs font-medium">Kode Order</p>
                <p class="font-extrabold text-2xl font-mono mt-0.5">{{ $order->order_code }}</p>
            </div>
            <span class="bg-white/20 text-white text-sm px-3 py-1.5 rounded-xl font-semibold backdrop-blur-sm">
                {{ $badge['label'] }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Layanan</p>
                <p class="font-semibold mt-0.5">{{ $order->service->name }}</p>
            </div>
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Jenis</p>
                <p class="font-semibold mt-0.5">
                    {{ $order->pickup_type === 'jemput' ? '🚴 Jemput' : '🏠 Antar Sendiri' }}
                </p>
            </div>
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Tanggal Order</p>
                <p class="font-semibold mt-0.5">{{ $order->created_at->isoFormat('D MMM Y') }}</p>
            </div>
            <div class="bg-white/10 rounded-xl p-3">
                <p class="text-blue-200 text-xs">Estimasi Selesai</p>
                <p class="font-semibold mt-0.5">
                    {{ $order->service->estimated_days === 0 ? '6 Jam' : $order->service->estimated_days . ' Hari Kerja' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ── Status Timeline ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i data-lucide="git-branch" class="w-4 h-4 text-blue-500"></i>
            Alur Status
        </h3>
        @php
        $allSteps = [
            ['key'=>'pending', 'label'=>'Order Diterima', 'icon'=>'clipboard-check', 'ts' => $order->created_at],
            ['key'=>'pickup', 'label'=>'Kurir Menjemput', 'icon'=>'truck', 'ts' => $order->pickup_at],
            ['key'=>'in_process', 'label'=>'Sedang Diproses', 'icon'=>'zap', 'ts' => $order->process_at],
            ['key'=>'ready', 'label'=>'Siap Diambil', 'icon'=>'check-circle', 'ts' => $order->ready_at],
            ['key'=>'finished', 'label'=>'Selesai', 'icon'=>'star', 'ts' => $order->finished_at],
        ];
        if($order->pickup_type === 'antar_sendiri') {
            $allSteps = array_values(array_filter($allSteps, fn($s) => $s['key'] !== 'pickup'));
        }
        $order_idx = ['pending'=>0,'pickup'=>1,'in_process'=>2,'ready'=>3,'finished'=>4];
        $curIdx = $order_idx[$order->status] ?? 0;
        if($order->pickup_type === 'antar_sendiri' && $curIdx >= 2) $curIdx--;
        @endphp

        <div class="relative">
            <div class="absolute left-5 top-5 bottom-5 w-0.5 bg-gradient-to-b from-blue-500 to-gray-100"></div>
            <div class="space-y-5">
                @foreach($allSteps as $i => $step)
                    @php
                        $done = $i < $curIdx;
                        $current = $i === $curIdx;
                        $future = $i > $curIdx;
                    @endphp
                    <div class="flex items-start gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 z-10 border-2
                            {{ $done ? 'bg-blue-500 border-blue-500' : ($current ? 'bg-blue-600 border-blue-600 ring-4 ring-blue-100' : 'bg-white border-gray-200') }}">
                            @if($done)
                                <i data-lucide="check" class="w-5 h-5 text-white"></i>
                            @else
                                <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 {{ $current ? 'text-white' : 'text-gray-300' }}"></i>
                            @endif
                        </div>
                        <div class="flex-1 pt-1.5">
                            <p class="font-semibold text-sm {{ $future ? 'text-gray-300' : ($current ? 'text-blue-700' : 'text-gray-700') }}">
                                {{ $step['label'] }}
                                @if($current)
                                    <span class="ml-2 bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full">Sekarang</span>
                                @endif
                            </p>
                            @if($step['ts'] && !$future)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $step['ts']->isoFormat('D MMM Y, HH:mm') }}</p>
                            @elseif($current)
                                <p class="text-xs text-blue-400 mt-0.5 animate-pulse">Sedang berlangsung...</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Poin Loyalitas Transaksi (FITUR BARU) ─────────────────────── --}}
     {{--@php
        $loyaltySetting = \App\Models\LoyaltySetting::first();
        $earnedPoints = 0;
        if($loyaltySetting && $loyaltySetting->is_active && $order->total_price >= $loyaltySetting->threshold_amount) {
            $earnedPoints = floor($order->total_price / $loyaltySetting->threshold_amount) * $loyaltySetting->points_earned;
        }
    @endphp

    @if($loyaltySetting && $loyaltySetting->is_active && $earnedPoints > 0)
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
            Poin Loyalitas
        </h3>
        @if($order->status === 'finished')
            <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-amber-900">Poin Berhasil Diklaim!</h4>
                    <p class="text-xs text-amber-700">Transaksi selesai telah menambahkan poin ke akun Anda.</p>
                </div>
                <span class="bg-amber-600 text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-xs">+{{ $earnedPoints }} POIN</span>
            </div>
        @else
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-gray-700">Estimasi Perolehan Poin</h4>
                    <p class="text-xs text-gray-500">Akan masuk ke saldo akun Anda setelah status pesanan <b>Selesai</b>.</p>
                </div>
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-xl border border-amber-200">+{{ $earnedPoints }} POIN</span>
            </div>
        @endif
    </div>
    @endif --}}

    {{-- ── Hubungi Admin Laundry ─────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4 text-blue-500"></i>
            Bantuan & Pertanyaan
        </h3>
        <p class="text-sm text-gray-500 mb-4">Ada kendala atau pertanyaan seputar pesanan ini? Silakan hubungi admin toko tempat Anda memesan.</p>
        
        <form action="{{ route('chat.start') }}" method="POST">
            @csrf
            {{-- Mengambil ID User Admin Toko secara dinamis melalui relasi laundry --}}
            <input type="hidden" name="with_user_id" value="{{ $order->laundry->users->where('role', 'admin')->first()->id ?? 1 }}"> 
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-sm">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                Mulai Chat dengan Admin
            </button>
        </form>
    </div>

    {{-- ── Pickup Info ─────────────────────────────────────────────── --}}
    @if($order->pickup_type === 'jemput' && $order->pickup_address)
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
            Info Jemputan
        </h3>
        <p class="text-sm text-gray-600 bg-gray-50 rounded-xl p-3">{{ $order->pickup_address }}</p>
        @if($order->pickup_note)
            <p class="text-xs text-gray-400 mt-2">📝 {{ $order->pickup_note }}</p>
        @endif
        @if($order->kurir)
            <div class="flex items-center gap-3 mt-3 p-3 bg-blue-50 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-blue-200 flex items-center justify-center">
                    <span class="text-blue-700 font-bold text-sm">{{ strtoupper(substr($order->kurir->name,0,1)) }}</span>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Kurir</p>
                    <p class="font-semibold text-sm text-gray-800">{{ $order->kurir->name }}</p>
                </div>
                <a href="https://wa.me/{{ preg_replace('/^0/','62',preg_replace('/\D/','',$order->kurir->phone ?? '')) }}"
                    target="_blank"
                    class="ml-auto text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-lg font-medium hover:bg-green-200 flex items-center gap-1">
                    <i data-lucide="message-circle" class="w-3 h-3"></i> WA
                </a>
            </div>
        @endif
    </div>
    @endif

    {{-- ── Rincian Harga ───────────────────────────────────────────── --}}
    @if($order->weight_kg)
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="receipt" class="w-4 h-4 text-blue-500"></i>
            Rincian Tagihan
        </h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>{{ $order->service->name }}</span>
                <span>{{ $order->weight_kg }} kg × Rp {{ number_format($order->price_per_kg,0,',','.') }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span></span>
                <span class="font-medium">= Rp {{ number_format($order->weight_kg * $order->price_per_kg,0,',','.') }}</span>
            </div>
            @if($order->service_fee > 0)
                <div class="flex justify-between text-gray-600">
                    <span>Biaya Layanan Jemput</span>
                    <span class="font-medium">Rp {{ number_format($order->service_fee,0,',','.') }}</span>
                </div>
            @endif
            <div class="border-t border-gray-100 pt-2 mt-2 flex justify-between font-extrabold text-blue-700 text-lg">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
            </div>
        </div>
    </div>
    @else
    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 flex items-center gap-3">
        <i data-lucide="scale" class="w-5 h-5 text-amber-500 flex-shrink-0"></i>
        <p class="text-sm text-amber-700">Kasir belum menimbang. Total tagihan akan muncul setelah berat diinput.</p>
    </div>
    @endif

    {{-- ── Pembayaran ───────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="credit-card" class="w-4 h-4 text-blue-500"></i>
            Pembayaran
        </h3>
        @if($order->payment)
            @php $pay = $order->payment; @endphp
            <div class="flex items-center justify-between p-4 rounded-xl
                {{ $pay->isVerified() ? 'bg-green-50 border border-green-100' : ($pay->status==='rejected' ? 'bg-red-50 border border-red-100' : 'bg-amber-50 border border-amber-100') }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="{{ $pay->isVerified() ? 'check-circle' : ($pay->status==='rejected' ? 'x-circle' : 'clock') }}"
                        class="w-5 h-5 {{ $pay->isVerified() ? 'text-green-500' : ($pay->status==='rejected' ? 'text-red-700' : 'text-amber-500') }}"></i>
                    <div>
                        <p class="font-semibold text-sm {{ $pay->isVerified() ? 'text-green-700' : ($pay->status==='rejected' ? 'text-red-700' : 'text-amber-700') }}">
                            {{ $pay->isVerified() ? 'Lunas ✓' : ($pay->status==='rejected' ? 'Ditolak — Hubungi kasir' : 'Menunggu Verifikasi') }}
                        </p>
                        <p class="text-xs text-gray-500">{{ strtoupper($pay->method) }} · {{ $pay->payment_code }}</p>
                    </div>
                </div>
                <span class="font-bold text-gray-800">Rp {{ number_format($pay->amount,0,',','.') }}</span>
            </div>

            {{-- Bukti transfer image --}}
            @if($pay->proof_image)
                <div class="mt-3">
                    <p class="text-xs text-gray-400 mb-2">Bukti Pembayaran:</p>
                    <img src="{{ Storage::url($pay->proof_image) }}"
                        alt="Bukti bayar" class="rounded-xl border border-gray-200 max-h-48 object-contain">
                </div>
            @endif

            {{-- WA link untuk konfirmasi manual --}}
            @if(!$pay->isVerified() && isset($waDeepLink))
                <a href="{{ $waDeepLink }}" target="_blank"
                    class="mt-3 flex items-center justify-center gap-2 w-full bg-green-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Konfirmasi via WhatsApp Admin
                </a>
            @endif

        @elseif($order->weight_kg)
            <p class="text-sm text-gray-500 mb-4">Silakan lakukan pembayaran untuk menyelesaikan order.</p>
            <a href="{{ route('customer.orders.pay', $order) }}"
                class="flex items-center justify-center gap-2 w-full bg-blue-600 text-white py-3 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar Sekarang — Rp {{ number_format($order->total_price,0,',','.') }}
            </a>
        @else
            <p class="text-sm text-gray-400 italic">Pembayaran dapat dilakukan setelah kasir menimbang cucian.</p>
        @endif
    </div>

    {{-- ── Notes ───────────────────────────────────────────────────── --}}
    @if($order->notes)
    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-4">
        <p class="text-xs font-semibold text-gray-500 mb-1">Catatan Khusus:</p>
        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
    </div>
    @endif

</div>
@endsection