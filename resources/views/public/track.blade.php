<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order — LaundryTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">

<div class="max-w-lg mx-auto px-4 py-16">

    {{-- Logo --}}
    <div class="text-center mb-10">
        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-blue-200">
            <i data-lucide="shirt" class="w-7 h-7 text-white"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-blue-700">LaundryTrack</h1>
        <p class="text-gray-400 text-sm">Lacak status cucian kamu</p>
    </div>

    {{-- Search Form --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('order.track') }}" class="flex gap-2">
            <input type="text" name="code" value="{{ request('code') }}"
                   placeholder="Masukkan kode order... (LT-20240101-001)"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-600 text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors flex-shrink-0">
                Cek
            </button>
        </form>
    </div>

    {{-- Result --}}
    @if(request('code') && !$order)
    <div class="bg-white rounded-2xl border border-red-100 p-6 text-center">
        <i data-lucide="search-x" class="w-10 h-10 text-red-300 mx-auto mb-2"></i>
        <p class="font-semibold text-gray-700">Order tidak ditemukan</p>
        <p class="text-sm text-gray-400 mt-1">Periksa kembali kode order kamu.</p>
    </div>
    @endif

    @if($order)
    @php
        $steps = [
            ['key'=>'pending',    'label'=>'Order Diterima',  'icon'=>'clipboard-check'],
            ['key'=>'pickup',     'label'=>'Dijemput Kurir',  'icon'=>'truck'],
            ['key'=>'in_process', 'label'=>'Sedang Diproses', 'icon'=>'zap'],
            ['key'=>'ready',      'label'=>'Siap Diambil',    'icon'=>'check-circle'],
            ['key'=>'finished',   'label'=>'Selesai',         'icon'=>'star'],
        ];
        $statusOrder = ['pending'=>0,'pickup'=>1,'in_process'=>2,'ready'=>3,'finished'=>4,'cancelled'=>-1];
        $currentIdx  = $statusOrder[$order->status] ?? 0;
        if($order->pickup_type === 'antar_sendiri') {
            $steps = array_values(array_filter($steps, fn($s) => $s['key'] !== 'pickup'));
            if($currentIdx >= 2) $currentIdx--;
        }
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Order Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-xs font-medium">Kode Order</p>
                    <p class="text-white font-extrabold text-xl font-mono">{{ $order->order_code }}</p>
                </div>
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">
                    {{ $order->getStatusBadge()['label'] }}
                </span>
            </div>
            <div class="mt-3 text-sm text-blue-100">
                {{ $order->service->name }} ·
                {{ $order->pickup_type === 'jemput' ? '🚴 Layanan Jemput' : '🏠 Antar Sendiri' }}
            </div>
        </div>

        {{-- Progress Steps --}}
        <div class="px-6 py-6">
            @if($order->status === 'cancelled')
            <div class="text-center py-4">
                <i data-lucide="x-circle" class="w-10 h-10 text-red-400 mx-auto mb-2"></i>
                <p class="font-semibold text-red-600">Order Dibatalkan</p>
            </div>
            @else
            <div class="relative">
                {{-- Line --}}
                <div class="absolute left-4 top-4 bottom-4 w-0.5 bg-gray-100"></div>

                <div class="space-y-6">
                    @foreach($steps as $i => $step)
                    @php
                        $done    = $i < $currentIdx;
                        $current = $i === $currentIdx;
                        $future  = $i > $currentIdx;
                    @endphp
                    <div class="flex items-center gap-4 relative">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 z-10
                                    {{ $done ? 'bg-blue-500' : ($current ? 'bg-blue-600 ring-4 ring-blue-100' : 'bg-gray-100') }}">
                            @if($done)
                                <i data-lucide="check" class="w-4 h-4 text-white"></i>
                            @elseif($current)
                                <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 text-white"></i>
                            @else
                                <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 text-gray-300"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold {{ $future ? 'text-gray-300' : ($current ? 'text-blue-700' : 'text-gray-700') }}">
                                {{ $step['label'] }}
                            </p>
                            @if($current)
                            <p class="text-xs text-blue-500">Status saat ini</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Order Details --}}
        @if($order->weight_kg)
        <div class="border-t border-gray-50 px-6 py-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Berat</span><span class="font-medium">{{ $order->weight_kg }} kg</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Harga/kg</span><span class="font-medium">Rp {{ number_format($order->price_per_kg,0,',','.') }}</span>
            </div>
            @if($order->service_fee > 0)
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Biaya Jemput</span><span class="font-medium">Rp {{ number_format($order->service_fee,0,',','.') }}</span>
            </div>
            @endif
            <div class="flex justify-between font-bold text-blue-700 text-base border-t border-gray-50 pt-2 mt-2">
                <span>Total</span><span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
            </div>
        </div>
        @else
        <div class="border-t border-gray-50 px-6 py-4 text-center text-xs text-gray-400 italic">
            Menunggu penimbangan berat oleh kasir...
        </div>
        @endif

        {{-- Payment Status --}}
        @if($order->payment)
        <div class="border-t border-gray-50 px-6 py-4 bg-gray-50">
            <div class="flex items-center gap-2">
                <i data-lucide="{{ $order->payment->isVerified() ? 'check-circle' : 'clock' }}"
                   class="w-4 h-4 {{ $order->payment->isVerified() ? 'text-green-500' : 'text-amber-500' }}"></i>
                <span class="text-sm font-medium {{ $order->payment->isVerified() ? 'text-green-700' : 'text-amber-700' }}">
                    Pembayaran {{ $order->payment->isVerified() ? 'Terverifikasi ✓' : 'Menunggu Verifikasi' }}
                </span>
            </div>
        </div>
        @endif

    </div>
    @endif

    <p class="text-center text-xs text-gray-300 mt-8">
        © {{ date('Y') }} LaundryTrack — Bersih, Cepat, Terpercaya
    </p>
</div>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>