@extends('layouts.app')

{{-- Inject library CSS Leaflet langsung ke tumpukan stylesheet layout utama --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 260px;
        width: 100%;
        border-radius: 14px;
        z-index: 1;
        display: block;
    }
    /* Mencegah bentrokan CSS Reset Tailwind dengan ubin gambar Leaflet */
    .leaflet-container img {
        max-width: none !important;
        max-height: none !important;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6 flex justify-center">
    <div class="w-full max-w-xl">

        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('ceo.laundries.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Manajemen Tenant
            </a>
            <span class="text-xs font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider border border-blue-100">Back-Office Registration</span>
        </div>

        <div class="flex items-center justify-center gap-3 mb-6 bg-white border border-gray-100 px-5 py-3 rounded-2xl shadow-sm">
            <div id="badge-step-1" class="flex items-center gap-2 text-sm font-bold text-blue-500">
                <span class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs">1</span>
                Profil Owner & Toko
            </div>
            <div class="w-12 h-[2px] bg-gray-200" id="line-step"></div>
            <div id="badge-step-2" class="flex items-center gap-2 text-sm font-bold text-gray-400">
                <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs">2</span>
                Paket Komersial SaaS
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">

                @if ($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5 text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('ceo.laundries.store') }}" enctype="multipart/form-data" class="space-y-4" id="regForm">
                    @csrf
                    
                    <input type="hidden" name="latitude" id="laundry_lat" value="{{ old('latitude', '-6.2088') }}">
                    <input type="hidden" name="longitude" id="laundry_lng" value="{{ old('longitude', '106.8456') }}">
                    <input type="hidden" name="subscription_plan_id" id="subscription_plan_id" value="{{ old('subscription_plan_id', $plans->first()->id ?? '') }}">

                    <div id="html-step-1" class="space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1"><i data-lucide="user-cog" class="w-3.5 h-3.5"></i> Kredensial Akun Pemilik (User)</h3>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap Owner</label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="text" name="owner_name" value="{{ old('owner_name') }}" required id="input_name" placeholder="Budi Santoso"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Sistem</label>
                                <div class="relative">
                                    <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="email" name="owner_email" value="{{ old('owner_email') }}" required id="input_email" placeholder="nama@email.com"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. HP / WhatsApp</label>
                                <div class="relative">
                                    <i data-lucide="phone" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required id="input_phone" placeholder="081234567890"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="password" name="owner_password" required id="input_pass" placeholder="Minimal 8 karakter"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="password" name="owner_password_confirmation" required id="input_pass_confirm" placeholder="Ulangi password"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100 my-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1"><i data-lucide="store" class="w-3.5 h-3.5"></i> Identitas & Titik Koordinat Peta (Laundry)</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Laundry / Brand Mitra</label>
                                <div class="relative">
                                    <i data-lucide="store" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="text" name="name" required value="{{ old('name') }}" id="input_laundry_name" placeholder="Fresh Clean Laundry"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Real Lokasi Outlet</label>
                                <div class="relative">
                                    <i data-lucide="image" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                    <input type="file" name="image" id="input_image" accept="image/*"
                                        class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Fisik Lengkap</label>
                            <div class="relative">
                                <i data-lucide="map-pin" class="absolute left-3.5 top-3 w-4 h-4 text-gray-400"></i>
                                <textarea id="laundry_address" name="address" rows="2" required placeholder="Ketik nama jalan atau daerah toko..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('address') }}</textarea>
                            </div>
                            <div id="autocomplete-results" class="absolute left-0 right-0 bg-white border border-gray-200 rounded-xl mt-1 shadow-lg max-h-48 overflow-y-auto hidden z-50"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Verifikasi Pin Peta Citra Satelit</label>
                            <div id="map" class="border border-gray-200 shadow-inner"></div>
                        </div>

                        <button type="button" onclick="goToStep(2)"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 mt-4 shadow-md shadow-blue-100 text-sm">
                            Lanjut Konfigurasi Paket <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div id="html-step-2" class="space-y-4 hidden">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pilih Paket Ekosistem Kemitraan</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">Tentukan skema operasional awal untuk tenant baru ini berdasarkan persetujuan administrasi.</p>

                        @foreach($plans as $plan)
                        @php 
                            $isComm = Str::contains(Str::lower($plan->name), ['komisi', 'commission', 'bagi hasil', 'free']);
                        @endphp
                        <div id="card-plan-{{ $plan->id }}" onclick="selectPlan({{ $plan->id }})"
                            class="plan-card border p-4 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative {{ $loop->first ? 'border-2 border-blue-500 bg-blue-50/40' : 'border-gray-200 bg-white' }}">
                            
                            <div class="absolute top-4 right-4 text-blue-500 {{ $loop->first ? '' : 'hidden' }} check-indicator" id="check-{{ $plan->id }}">
                                <i data-lucide="check-circle-2" class="w-5 h-5 fill-blue-500 text-white"></i>
                            </div>

                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 rounded-xl text-white {{ $isComm ? 'bg-blue-500' : 'bg-purple-500' }}">
                                    <i data-lucide="{{ $isComm ? 'percent' : 'calendar' }}" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $plan->name }}</h4>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-md {{ $isComm ? 'text-blue-600 bg-blue-100' : 'text-purple-600 bg-purple-100' }}">
                                        {{ $plan->price > 0 ? 'Rp ' . number_format($plan->price, 0, ',', '.') . ' / bln' : 'Skema Bagi Hasil' }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed">{{ $plan->description ?? 'Berikan hak akses penuh ekosistem aplikasi tanpa kendala batasan limit.' }}</p>
                        </div>
                        @endforeach

                        <div class="bg-amber-50 border border-amber-100 p-3 rounded-xl text-[11px] text-amber-700 leading-relaxed mt-4">
                            ⚠️ <strong>Pemberitahuan Sistem:</strong> Selaku Super Admin (CEO Dashboard), Anda memegang otoritas penuh untuk menaikkan atau menurunkan status paket ini kapan saja di masa mendatang.
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="goToStep(1)"
                                class="w-1/3 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-1.5 text-sm">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                            </button>
                            
                            <button type="submit"
                                class="w-2/3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-md shadow-blue-100 text-sm">
                                <i data-lucide="user-plus" class="w-4 h-4"></i> Daftarkan Sekarang
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Inject script peta & otomasi wizard ke tumpukan footer asset layout --}}
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // PERUBAHAN: Nama variabel dibedakan agar tidak tabrakan dengan blueprint layouts.app
    let superadminMap, superadminMarker;

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        initSuperadminMap();
    });

    // 1. LOGIKA NAVIGASI WIZARD FORM
    function goToStep(step) {
        const step1Html = document.getElementById('html-step-1');
        const step2Html = document.getElementById('html-step-2');
        const badge1 = document.getElementById('badge-step-1');
        const badge2 = document.getElementById('badge-step-2');
        const lineStep = document.getElementById('line-step');

        if (step === 2) {
            if (!document.getElementById('input_name').value || 
                !document.getElementById('input_email').value || 
                !document.getElementById('input_laundry_name').value ||
                !document.getElementById('laundry_address').value) {
                alert('Mohon lengkapi seluruh kolom bertanda wajib pada informasi Toko terlebih dahulu.');
                return;
            }

            step1Html.classList.add('hidden');
            step2Html.classList.remove('hidden');

            badge1.className = "flex items-center gap-2 text-sm font-bold text-gray-400";
            badge1.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs";
            lineStep.className = "w-12 h-[2px] bg-blue-500";
            badge2.className = "flex items-center gap-2 text-sm font-bold text-blue-500";
            badge2.querySelector('span').className = "w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs";
        } else {
            step2Html.classList.add('hidden');
            step1Html.classList.remove('hidden');

            badge1.className = "flex items-center gap-2 text-sm font-bold text-blue-500";
            badge1.querySelector('span').className = "w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs";
            lineStep.className = "w-12 h-[2px] bg-gray-200";
            badge2.className = "flex items-center gap-2 text-sm font-bold text-gray-400";
            badge2.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs";
            
            setTimeout(() => { 
                if (superadminMap) superadminMap.invalidateSize(); 
            }, 100);
        }
    }

    // 2. SELEKSI KARTU PLAN DINAMIS
    function selectPlan(planId) {
        document.getElementById('subscription_plan_id').value = planId;

        // Reset semua style kartu
        document.querySelectorAll('.plan-card').forEach(card => {
            card.className = "plan-card border border-gray-200 bg-white p-4 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
        });
        document.querySelectorAll('.check-indicator').forEach(chk => chk.classList.add('hidden'));

        // Aktifkan kartu terpilih
        const targetCard = document.getElementById(`card-plan-${planId}`);
        if (targetCard) {
            targetCard.className = "plan-card border-2 border-blue-500 bg-blue-50/40 p-4 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
        }
        const targetCheck = document.getElementById(`check-${planId}`);
        if (targetCheck) {
            targetCheck.classList.remove('hidden');
        }
    }

    // 3. ADOPSI UTUH MODUL IDENTIK DARI REGISTER-MITRA (PETA + NOMINATIM AUTOCOMPLETE)
    function initSuperadminMap() {
        const latInput = document.getElementById('laundry_lat');
        const lngInput = document.getElementById('laundry_lng');
        const addressInput = document.getElementById('laundry_address');
        const resultsContainer = document.getElementById('autocomplete-results');

        let defaultLat = parseFloat(latInput.value) || -6.2088;
        let defaultLng = parseFloat(lngInput.value) || 106.8456;

        superadminMap = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(superadminMap);

        superadminMarker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(superadminMap);

        function updateCoordinates(lat, lng) {
            latInput.value = lat.toFixed(8);
            lngInput.value = lng.toFixed(8);
        }

        superadminMarker.on('dragend', function (e) {
            const position = superadminMarker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });

        superadminMap.on('click', function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            superadminMarker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                superadminMap.setView([userLat, userLng], 15);
                superadminMarker.setLatLng([userLat, userLng]);
                updateCoordinates(userLat, userLng);
            });
        }

        // INTEGRASI SISTEM AUTOCOMPLETE ALAMAT (NOMINATIM)
        let typingTimer;
        addressInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            const query = this.value;

            if (query.length < 4) {
                resultsContainer.classList.add('hidden');
                return;
            }

            typingTimer = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length === 0) {
                            resultsContainer.classList.add('hidden');
                            return;
                        }

                        resultsContainer.classList.remove('hidden');
                        data.forEach(item => {
                            const row = document.createElement('div');
                            row.className = 'px-4 py-2.5 hover:bg-blue-50 cursor-pointer text-xs text-gray-700 border-b border-gray-100 last:border-none transition-colors';
                            row.innerText = item.display_name;

                            row.addEventListener('click', () => {
                                addressInput.value = item.display_name;
                                resultsContainer.classList.add('hidden');

                                const newLat = parseFloat(item.lat);
                                const newLng = parseFloat(item.lon);

                                superadminMap.setView([newLat, newLng], 16);
                                superadminMarker.setLatLng([newLat, newLng]);
                                updateCoordinates(newLat, newLng);
                            });

                            resultsContainer.appendChild(row);
                        });
                    });
            }, 500);
        });

        document.addEventListener('click', function(e) {
            if (!addressInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        // Force pemuatan dimensi kontainer peta agar ubin ubin Leaflet langsung segar
        setTimeout(() => {
            if (superadminMap) superadminMap.invalidateSize();
        }, 200);
    }
</script>
@endpush