<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryTrack — Laundry Digital untuk UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-mesh {
            background: radial-gradient(at 20% 20%, #dbeafe 0%, transparent 55%),
                        radial-gradient(at 80% 80%, #ede9fe 0%, transparent 55%),
                        radial-gradient(at 50% 50%, #f0f9ff 0%, transparent 70%);
        }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        .float { animation: float 4s ease-in-out infinite; }
        .float-2 { animation: float 4s ease-in-out infinite 1s; }
        .float-3 { animation: float 4s ease-in-out infinite 2s; }
    </style>
</head>
<body class="bg-white overflow-x-hidden">

    {{-- ─── NAVBAR ──────────────────────────────────────────────────── --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <i data-lucide="shirt" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-extrabold text-blue-700 text-lg">LaundryTrack</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('order.track') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors hidden sm:block">
                    Track Order
                </a>
                @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 transition-colors">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                    Daftar Gratis
                </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ─── HERO ────────────────────────────────────────────────────── --}}
    <section class="gradient-mesh min-h-screen flex items-center pt-16">
        <div class="max-w-6xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Left --}}
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-xs font-semibold px-4 py-2 rounded-full border border-blue-100 mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Solusi Digital untuk Laundry UMKM
                </div>
                <h1 class="text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-5">
                    Kelola Laundry<br>
                    <span class="text-blue-600">Lebih Cerdas</span> 🧺
                </h1>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    Sistem manajemen laundry berbasis web lengkap — dari order online, tracking real-time,
                    hingga notifikasi WhatsApp otomatis. Solusi #1 untuk UMKM Laundry modern.
                </p>
                <div class="flex flex-wrap gap-3">
                    @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Buka Dashboard
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
                        Mulai Gratis <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('order.track') }}"
                       class="bg-white text-gray-700 font-semibold px-6 py-3.5 rounded-xl border border-gray-200 hover:border-blue-300 transition-all flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4"></i> Track Order
                    </a>
                    @endauth
                </div>

                {{-- Social Proof --}}
                <div class="flex items-center gap-6 mt-8 pt-8 border-t border-gray-100">
                    @php
                    $badges = [
                        ['val'=>'4 Role', 'label'=>'Akses User'],
                        ['val'=>'Real-time','label'=>'Tracking'],
                        ['val'=>'WA Notif','label'=>'Otomatis'],
                    ];
                    @endphp
                    @foreach($badges as $b)
                    <div class="text-center">
                        <p class="font-extrabold text-gray-900">{{ $b['val'] }}</p>
                        <p class="text-xs text-gray-400">{{ $b['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Floating UI Cards --}}
            <div class="relative h-80 lg:h-auto hidden lg:block">
                {{-- Order Card --}}
                <div class="float absolute top-0 left-8 bg-white rounded-2xl border border-gray-100 shadow-xl p-4 w-64">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="shirt" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">LT-20240101-001</p>
                            <p class="text-xs text-gray-400">Cuci + Setrika</p>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">✓ Siap Diambil</span>
                        <span class="font-bold text-gray-700">Rp 21.000</span>
                    </div>
                </div>

                {{-- Notification Card --}}
                <div class="float-2 absolute top-28 right-0 bg-white rounded-2xl border border-gray-100 shadow-xl p-4 w-56">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="message-circle" class="w-4 h-4 text-green-600"></i>
                        </div>
                        <p class="font-bold text-gray-800 text-xs">WhatsApp Notif</p>
                    </div>
                    <p class="text-xs text-gray-500">🧺 Cucian kamu sudah siap! Silakan diambil...</p>
                </div>

                {{-- Revenue Card --}}
                <div class="float-3 absolute bottom-0 left-16 bg-white rounded-2xl border border-gray-100 shadow-xl p-4 w-52">
                    <p class="text-xs text-gray-400 mb-1">Pemasukan Hari Ini</p>
                    <p class="text-2xl font-extrabold text-blue-600">Rp 875k</p>
                    <div class="flex items-center gap-1 mt-1">
                        <i data-lucide="trending-up" class="w-4 h-4 text-green-500"></i>
                        <span class="text-xs text-green-500 font-medium">+12% dari kemarin</span>
                    </div>
                </div>

                {{-- Inventory Alert --}}
                <div class="absolute top-52 left-4 bg-amber-50 border border-amber-200 rounded-xl p-3 w-44">
                    <div class="flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500 flex-shrink-0"></i>
                        <div>
                            <p class="text-xs font-semibold text-amber-800">Stok Menipis</p>
                            <p class="text-xs text-amber-600">Parfum Laundry: 2L</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── FEATURES ────────────────────────────────────────────────── --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Semua yang Kamu Butuhkan</h2>
                <p class="text-gray-400 max-w-xl mx-auto">Satu platform untuk mengelola seluruh operasional laundry kamu dengan mudah dan efisien.</p>
            </div>
            @php
            $features = [
                ['icon'=>'users',           'title'=>'Multi-Role Access',      'color'=>'blue',   'desc'=>'Admin, Kasir, Kurir, dan Customer punya akses dan tampilan yang berbeda sesuai peran masing-masing.'],
                ['icon'=>'truck',           'title'=>'Layanan Jemput Antar',   'color'=>'purple', 'desc'=>'Kurir bisa lihat dan accept tugas jemputan. Admin bisa toggle layanan ini kapan saja.'],
                ['icon'=>'zap',             'title'=>'Tracking Real-time',     'color'=>'amber',  'desc'=>'Customer bisa lacak status cucian dari Pending hingga Finished tanpa perlu login.'],
                ['icon'=>'message-circle',  'title'=>'WA Notification',        'color'=>'green',  'desc'=>'Notifikasi otomatis via WhatsApp API atau deep-link ke customer & kurir di setiap perubahan status.'],
                ['icon'=>'credit-card',     'title'=>'Multi Payment',          'color'=>'blue',   'desc'=>'Dukung Cash, Transfer Bank, dan QRIS dengan fitur upload bukti bayar dan verifikasi kasir.'],
                ['icon'=>'package',         'title'=>'Manajemen Inventaris',   'color'=>'red',    'desc'=>'Pantau stok bahan (detergen, parfum, dll) dan dapatkan alert otomatis saat stok menipis.'],
                ['icon'=>'bar-chart-2',     'title'=>'Laporan Keuangan',       'color'=>'purple', 'desc'=>'Dashboard revenue harian dan laporan transaksi dengan filter tanggal untuk analisis bisnis.'],
                ['icon'=>'calculator',      'title'=>'Harga Otomatis',         'color'=>'amber',  'desc'=>'Kalkulasi total = Berat × Harga/kg + Service Fee dihitung otomatis setelah kasir input berat.'],
            ];
            $fc = ['blue'=>'bg-blue-100 text-blue-600','purple'=>'bg-purple-100 text-purple-600','amber'=>'bg-amber-100 text-amber-600','green'=>'bg-green-100 text-green-600','red'=>'bg-red-100 text-red-600'];
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($features as $f)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-xl {{ $fc[$f['color']] }} flex items-center justify-center mb-4">
                        <i data-lucide="{{ $f['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── STATUS FLOW ─────────────────────────────────────────────── --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Alur Status Order</h2>
            <p class="text-gray-400 mb-12">Sistem tracking yang transparan dan mudah dipahami</p>
            <div class="flex flex-wrap justify-center items-center gap-2">
                @php
                $flow = [
                    ['label'=>'Pending',    'icon'=>'clock',         'color'=>'bg-amber-100 text-amber-700'],
                    ['label'=>'→'],
                    ['label'=>'Pickup',     'icon'=>'truck',         'color'=>'bg-blue-100 text-blue-700'],
                    ['label'=>'→'],
                    ['label'=>'Diproses',   'icon'=>'zap',           'color'=>'bg-purple-100 text-purple-700'],
                    ['label'=>'→'],
                    ['label'=>'Siap',       'icon'=>'check-circle',  'color'=>'bg-green-100 text-green-700'],
                    ['label'=>'→'],
                    ['label'=>'Selesai',    'icon'=>'star',          'color'=>'bg-gray-100 text-gray-600'],
                ];
                @endphp
                @foreach($flow as $step)
                    @if(isset($step['icon']))
                    <div class="{{ $step['color'] }} px-4 py-2 rounded-xl font-semibold text-sm flex items-center gap-2">
                        <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4"></i>
                        {{ $step['label'] }}
                    </div>
                    @else
                    <span class="text-gray-300 text-xl font-bold">{{ $step['label'] }}</span>
                    @endif
                @endforeach
            </div>
            <p class="text-xs text-gray-400 mt-5">* Status "Pickup" hanya muncul jika customer memilih layanan jemput</p>
        </div>
    </section>

    {{-- ─── CTA ─────────────────────────────────────────────────────── --}}
    <section class="py-20 bg-gradient-to-br from-blue-600 to-indigo-700">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">Siap Digitalisasi Laundry Kamu? 🚀</h2>
            <p class="text-blue-200 mb-8">Daftar sekarang dan mulai kelola laundry kamu dengan lebih profesional.</p>
            <div class="flex gap-3 justify-center">
                @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-white text-blue-600 font-bold px-8 py-3.5 rounded-xl hover:bg-blue-50 transition-colors">
                    Buka Dashboard
                </a>
                @else
                <a href="{{ route('register') }}"
                   class="bg-white text-blue-600 font-bold px-8 py-3.5 rounded-xl hover:bg-blue-50 transition-colors">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                   class="text-white border border-white/30 font-semibold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-colors">
                    Login
                </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ─── FOOTER ──────────────────────────────────────────────────── --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="shirt" class="w-4 h-4 text-white"></i>
                </div>
                <span class="font-bold text-white">LaundryTrack</span>
            </div>
            <p class="text-sm">© {{ date('Y') }} LaundryTrack. Bersih, Cepat, Terpercaya.</p>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('order.track') }}" class="hover:text-white transition-colors">Track Order</a>
                @guest
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
                @endguest
            </div>
        </div>
    </footer>

    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>