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
    </style>
</head>
<body class="bg-white overflow-x-hidden">

    {{-- ─── NAVBAR ──────────────────────────────────────────────────── --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Logo" class="h-12 w-auto object-contain">
                <span class="font-extrabold text-blue-400 text-lg">LaundryTrack</span>
            </div>
            <div class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                <a href="#alur-sistem" class="hover:text-blue-600 transition">Cara Kerja</a>
                <a href="#harga" class="hover:text-blue-600 transition">Harga Berlangganan</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('order.track') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors hidden sm:block">
                    Track Order
                </a>
                @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-400 transition-colors">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-blue-600 transition-colors">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-blue-400 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-600 transition-colors">
                    Daftar Gratis
                </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ─── HERO SECTION ────────────────────────────────────────────── --}}
    <section class="gradient-mesh min-h-screen flex items-center pt-20">
        <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Kolom Kiri: Copywriting --}}
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-xs font-semibold px-4 py-2 rounded-full border border-blue-100 mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Solusi Digital untuk Laundry UMKM
                </div>
                <h1 class="text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-5">
                    Kelola Laundry<br>
                    <span class="text-blue-400">Lebih Cerdas</span> 🧺
                </h1>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    Sistem manajemen laundry berbasis web lengkap — dari order online, tracking real-time,
                    hingga push notifikasi otomatis. Solusi #1 untuk UMKM Laundry modern.
                </p>
                <div class="flex flex-wrap gap-3">
                    @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-blue-600 hover:bg-blue-400 text-white font-bold px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Buka Dashboard
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                       class="bg-blue-400 hover:bg-blue-400 text-white font-bold px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
                        Mulai Gratis <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('order.track') }}"
                       class="bg-white text-gray-700 font-semibold px-6 py-3.5 rounded-xl border border-gray-200 hover:border-blue-300 transition-all flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4"></i> Track Order
                    </a>
                    @endauth
                </div>

                <div class="flex items-center gap-6 mt-8 pt-8 border-t border-gray-100">
                    @php
                    $badges = [
                        ['val'=>'4 Role', 'label'=>'Akses User'],
                        ['val'=>'Real-time','label'=>'Tracking'],
                        ['val'=>'Push Notif','label'=>'Otomatis'],
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

            {{-- Kolom Kanan: Logo Utama Besar & Prominent (Revisi Dosen) --}}
            <div class="hidden lg:flex items-center justify-center">
                <div class="relative p-12 bg-white/40 backdrop-blur-md rounded-3xl border border-white/60 shadow-2xl flex items-center justify-center w-full max-w-md aspect-square group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-400/20 to-indigo-500/10 rounded-3xl blur-2xl group-hover:scale-105 transition-transform duration-500 -z-10"></div>
                    <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Brand Logo" 
                         class="w-full h-auto object-contain drop-shadow-2xl transition-transform duration-500 group-hover:scale-105">
                </div>
            </div>

        </div>
    </section>

    {{-- ─── BARU: VISI & MISI (Kebutuhan Presentasi Akademik) ───────── --}}
    <section class="py-16 bg-white border-t border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 text-xs font-semibold px-4 py-2 rounded-full mb-6 border border-indigo-100">
                        <i data-lucide="target" class="w-4 h-4"></i> Visi & Misi Kami
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Tujuan Besar LaundryTrack</h2>
                    <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 mb-6 shadow-sm">
                        <h3 class="font-bold text-blue-800 mb-2 flex items-center gap-2">
                            <i data-lucide="eye" class="w-5 h-5"></i> Visi
                        </h3>
                        <p class="text-gray-700 leading-relaxed italic">"Mewujudkan digitalisasi dan modernisasi pada sektor UMKM laundry guna meningkatkan produktivitas layanan dan kepuasan konsumen."</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="flag" class="w-5 h-5 text-indigo-600"></i> Misi
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-200">1</div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">Pemberdayaan UMKM (B2B)</h4>
                                <p class="text-sm text-gray-500 mt-1">Mengembangkan sistem manajemen terjangkau untuk otomatisasi pembukuan dan operasional laundry.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-200">2</div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">Optimalisasi Layanan (B2C)</h4>
                                <p class="text-sm text-gray-500 mt-1">Menerapkan teknologi self-service tracking terintegrasi untuk memberikan kepastian waktu bagi pelanggan.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-200">3</div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">Keamanan & Kepercayaan</h4>
                                <p class="text-sm text-gray-500 mt-1">Memfasilitasi jalur komunikasi yang aman (In-App Chat) tanpa perlu membagikan nomor pribadi.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── FEATURES ────────────────────────────────────────────────── --}}
    <section id="fitur" class="py-20 bg-gray-50">
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
                ['icon'=>'message-circle',  'title'=>'In-App Chat Internal',   'color'=>'purple', 'desc'=>'Komunikasi instan antara owner, kurir, dan customer di dalam sistem tanpa perlu sebar nomor pribadi.'],
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

    {{-- ─── BARU: HIGHLIGHT STIKER QR CODE (Inovasi B2C) ────────────── --}}
    <section class="py-16 bg-blue-600 relative overflow-hidden">
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-blue-500 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/4 w-72 h-72 bg-indigo-500 rounded-full blur-3xl opacity-50"></div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center gap-10 shadow-2xl">
                <div class="w-48 h-48 shrink-0 bg-white rounded-2xl p-4 shadow-inner flex flex-col items-center justify-center transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                    <i data-lucide="qr-code" class="w-24 h-24 text-gray-900 mb-2"></i>
                    <span class="text-xs font-bold text-gray-500 tracking-widest uppercase">Scan Me</span>
                </div>
                
                <div class="text-center md:text-left text-white">
                    <div class="inline-flex items-center gap-2 bg-blue-500/50 text-blue-50 text-xs font-semibold px-4 py-2 rounded-full mb-4 border border-blue-400/50">
                        <i data-lucide="smartphone" class="w-4 h-4"></i> Inovasi Layanan B2C
                    </div>
                    <h2 class="text-3xl font-extrabold mb-4 leading-tight">Lacak Cucian Real-Time dengan <span class="text-blue-200">Stiker QR Code</span></h2>
                    <p class="text-blue-100 text-lg mb-6 max-w-2xl leading-relaxed">
                        Pelanggan tidak perlu lagi repot bertanya lewat WhatsApp. Cukup tempel stiker QR di nota/keranjang, scan menggunakan kamera HP, dan pantau status cucian secara mandiri hingga siap diambil!
                    </p>
                    <a href="{{ route('order.track') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-6 py-3 rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        Coba Fitur Scan QR <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── ALUR PENGGUNAAN SISTEM ────────────────────────────── --}}
    <section id="alur-sistem" class="py-20 bg-white relative">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-wider bg-blue-50 px-3 py-1.5 rounded-full">WorkFlow Sistem</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-3 mb-4">Cara Kerja LaundryTrack</h2>
                <p class="text-gray-500 max-w-xl mx-auto">4 langkah mudah digitalisasi dan pemrosesan operasional transaksi laundry pada sistem kami.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="flex flex-col items-center text-center group relative">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xl mb-4 border border-blue-100 group-hover:bg-blue-400 group-hover:text-white transition-all duration-300 shadow-sm z-10">
                        01
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-blue-500 transition-colors">Registrasi Mitra</h3>
                    <p class="text-sm text-gray-400 leading-relaxed px-2">Pemilik UMKM mendaftarkan toko laundry, mengatur daftar outlet, karyawan, jenis layanan, dan konfigurasi harga.</p>
                </div>

                <div class="flex flex-col items-center text-center group relative">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xl mb-4 border border-blue-100 group-hover:bg-blue-400 group-hover:text-white transition-all duration-300 shadow-sm z-10">
                        02
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-blue-500 transition-colors">Input Transaksi</h3>
                    <p class="text-sm text-gray-400 leading-relaxed px-2">Kasir menginput data cucian (berat/satuan) milik pelanggan. Invoice digital dan kalkulasi nominal otomatis terbuat.</p>
                </div>

                <div class="flex flex-col items-center text-center group relative">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xl mb-4 border border-blue-100 group-hover:bg-blue-400 group-hover:text-white transition-all duration-300 shadow-sm z-10">
                        03
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-blue-500 transition-colors">Pelacakan Transparan</h3>
                    <p class="text-sm text-gray-400 leading-relaxed px-2">Karyawan memperbarui status pengerjaan cucian di dashboard, dan customer memantau proses secara real-time.</p>
                </div>

                <div class="flex flex-col items-center text-center group relative">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xl mb-4 border border-blue-100 group-hover:bg-blue-400 group-hover:text-white transition-all duration-300 shadow-sm z-10">
                        04
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-blue-500 transition-colors">Notifikasi & Selesai</h3>
                    <p class="text-sm text-gray-400 leading-relaxed px-2">Ketika cucian selesai diproses, Notifikasi otomatis agar pakaian siap diambil/diantar.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── STATUS FLOW ─────────────────────────────────────────────── --}}
    <section class="py-20 bg-gray-50/50">
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

    {{-- ─── HARGA ───────────────────────────────────────────────────── --}}
    <section id="harga" class="py-20 bg-gradient-to-b from-transparent to-blue-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Opsi Rencana Bisnis Fleksibel</h2>
                <p class="mt-4 text-slate-600">Pilih skema paket keuangan yang paling sesuai dengan kapasitas omzet usaha Anda.</p>
            </div>

            <div class="mt-16 grid max-w-md gap-8 mx-auto sm:max-w-none sm:grid-cols-2 lg:max-w-4xl">
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Bebas Risiko / UMKM</span>
                        <h3 class="text-xl font-bold text-slate-900 mt-4">Paket Freemium</h3>
                        <p class="text-sm text-slate-500 mt-1">Gunakan sistem secara gratis tanpa iuran bulanan.</p>
                        <div class="mt-6 flex items-baseline">
                            <span class="text-4xl font-extrabold text-slate-900">Rp 0</span>
                            <span class="text-sm text-slate-500 ml-2">/ selamanya</span>
                        </div>
                        <ul class="mt-8 space-y-4 text-sm text-slate-600">
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-500"></i> Akses Fitur Kasir & Chat Internal</li>
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-500"></i> Rekap Finansial Otomatis</li>
                            <li class="flex items-center gap-3 text-blue-600 font-semibold"><i class="fa-solid fa-circle-info"></i> Potongan Komisi 8% / Transaksi</li>
                        </ul>
                    </div>
                    <a href="{{ route('register.mitra') }}" class="mt-8 block w-full text-center bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 rounded-xl transition text-sm">Mulai Gratis</a>
                </div>

                <div class="bg-white p-8 rounded-3xl border-2 border-blue-600 shadow-xl shadow-blue-600/5 relative flex flex-col justify-between">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold uppercase tracking-widest px-4 py-1 rounded-full shadow-md">Rekomendasi Enterprise</div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Skala Besar / Banyak Cabang</span>
                        <h3 class="text-xl font-bold text-slate-900 mt-4">Premium Flat Rate</h3>
                        <p class="text-sm text-slate-500 mt-1">Keuntungan 100% mutlak milik Anda.</p>
                        <div class="mt-6 flex items-baseline">
                            <span class="text-4xl font-extrabold text-slate-900">Rp 150K</span>
                            <span class="text-sm text-slate-500 ml-2">/ bulan</span>
                        </div>
                        <ul class="mt-8 space-y-4 text-sm text-slate-600">
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-500"></i> Semua Fitur Freemium Terbuka</li>
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-500"></i> Manajemen Multi-Cabang / Multi-Role</li>
                            <li class="flex items-center gap-3 text-emerald-600 font-semibold"><i class="fa-solid fa-bolt"></i> 0% Potongan Komisi Transaksi</li>
                        </ul>
                    </div>
                    <a href="{{ route('register.mitra') }}" class="mt-8 block w-full text-center bg-blue-600 hover:bg-blue-400 text-white font-semibold py-3 rounded-xl transition text-sm shadow-md shadow-blue-600/10">Langganan Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CTA ─────────────────────────────────────────────────────── --}}
    <section class="py-20 bg-gradient-to-br from-blue-400 to-indigo-700">
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

    {{-- ─── FOOTER & INTEGRASI PURE SVG SOSIAL MEDIA ─────────────────── --}}
    <footer class="bg-gray-900 text-gray-400 py-12 border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-6">
            
            {{-- Bagian Kiri: Logo Utama & Deskripsi Hak Cipta --}}
            <div class="flex flex-col items-center sm:items-start gap-2">
                <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Logo" class="h-10 w-auto object-contain brightness-0 invert">
                <p class="text-xs text-slate-500">© {{ date('Y') }} LaundryTrack. Bersih, Cepat, Terpercaya.</p>
            </div>

            {{-- Bagian Tengah: Tautan Cepat --}}
            <div class="flex gap-6 text-sm font-medium">
                <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                <a href="#alur-sistem" class="hover:text-white transition-colors">Cara Kerja</a>
                <a href="{{ route('order.track') }}" class="hover:text-white transition-colors">Track Order</a>
            </div>

            {{-- Bagian Kanan: Tombol Jejaring Sosial Media (Pure SVG) --}}
            <div class="flex items-center gap-3">
                {{-- Tautan Instagram (Pure SVG Outline) --}}
                <a href="https://instagram.com/" target="_blank" rel="noopener noreferrer" 
                   class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gradient-to-tr hover:from-amber-500 hover:to-purple-600 hover:text-white transition-all duration-300 shadow-sm" title="Instagram">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                    </svg>
                </a>

                {{-- Tautan Facebook (Pure SVG Fill) --}}
                <a href="https://facebook.com/" target="_blank" rel="noopener noreferrer" 
                   class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm" title="Facebook">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                    </svg>
                </a>

                {{-- Tautan TikTok (Pure SVG) --}}
                <a href="https://tiktok.com/" target="_blank" rel="noopener noreferrer" 
                   class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white hover:border hover:border-cyan-400/50 transition-all duration-300 shadow-sm" title="TikTok">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.02 1.71 4.1 1.1 1.05 2.59 1.58 4.1 1.63v3.9c-1.33-.08-2.64-.53-3.73-1.32-.32-.23-.62-.49-.89-.78V14.7c.03 2.37-.8 4.74-2.45 6.45-1.95 2.08-4.97 2.97-7.73 2.27-2.92-.72-5.32-3.14-5.88-6.13-.68-3.46 1.15-7.1 4.41-8.31 1.01-.38 2.09-.5 3.16-.36V12.7c-.89-.26-1.89-.04-2.58.59-.68.61-.99 1.58-.82 2.48.18 1.09 1.13 1.95 2.23 1.98 1.13.04 2.19-.74 2.43-1.85.07-.31.09-.63.08-.95V.02z"/>
                    </svg>
                </a>
            </div>

        </div>
    </footer>

    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>