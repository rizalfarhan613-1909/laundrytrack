<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mitra — LaundryTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        #map {
            height: 240px;
            border-radius: 12px;
            z-index: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center p-4">

    <div class="w-full max-w-md my-8">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Logo" class="h-12 w-auto object-contain">
                </div>
                <span class="font-extrabold text-blue-400 text-2xl">LaundryTrack</span>
            </a>
            <p class="text-gray-400 text-sm mt-2">Pendaftaran Akun Kemitraan</p>
        </div>

        <div class="flex items-center justify-center gap-3 mb-6 bg-white border border-gray-100 px-4 py-3 rounded-2xl shadow-sm">
            <div id="badge-step-1" class="flex items-center gap-2 text-sm font-bold text-blue-500">
                <span class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs">1</span>
                Profil & Toko
            </div>
            <div class="w-8 h-[2px] bg-gray-200" id="line-step"></div>
            <div id="badge-step-2" class="flex items-center gap-2 text-sm font-bold text-gray-400">
                <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs">2</span>
                Paket Sistem
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8">

                @if ($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register.mitra') }}" class="space-y-4" id="regForm">
                    @csrf
                    
                    <input type="hidden" name="role" value="toko">

                    <input type="hidden" name="latitude" id="laundry_lat" value="{{ old('latitude', '-6.2088') }}">
                    <input type="hidden" name="longitude" id="laundry_lng" value="{{ old('longitude', '106.8456') }}">
                    
                    <input type="hidden" name="subscription_type" id="subscription_type" value="{{ old('subscription_type', 'commission') }}">

                    <div id="html-step-1" class="space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Pemilik (User)</h3>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required id="input_name"
                                    placeholder="Budi Santoso"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                            <div class="relative">
                                <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required id="input_email"
                                    placeholder="nama@email.com"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. HP / WhatsApp</label>
                            <div class="relative">
                                <i data-lucide="phone" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required id="input_phone"
                                    placeholder="081234567890"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="password" name="password" required id="input_pass"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="password" name="password_confirmation" required id="input_pass_confirm"
                                    placeholder="Ulangi password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <hr class="border-gray-100 my-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Detail Outlet & Lokasi (Laundry)</h3>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Laundry / UMKM</label>
                            <div class="relative">
                                <i data-lucide="store" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input type="text" name="laundry_name" required value="{{ old('laundry_name') }}" id="input_laundry_name"
                                    placeholder="Fresh Clean Laundry"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap Laundry</label>
                            <div class="relative">
                                <i data-lucide="map-pin" class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400"></i>
                                <textarea id="laundry_address" name="laundry_address" rows="2" required placeholder="Ketik nama jalan atau daerah toko Anda..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('laundry_address') }}</textarea>
                            </div>
                            <div id="autocomplete-results" class="absolute left-0 right-0 bg-white border border-gray-200 rounded-xl mt-1 shadow-lg max-h-52 overflow-y-auto hidden z-50"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Lokasi di Peta</label>
                            <div id="map" class="border border-gray-200 shadow-inner"></div>
                        </div>

                        <button type="button" onclick="goToStep(2)"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 mt-6 shadow-md shadow-blue-100">
                            Lanjut Pilih Paket
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>


                    <div id="html-step-2" class="space-y-4 hidden">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pilih Model Bisnis Layanan</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">Pilih skema operasional yang paling menguntungkan bagi bisnis laundry Anda saat ini.</p>

                        <div id="card-commission" onclick="selectPlan('commission')"
                            class="border-2 border-blue-500 bg-blue-50/40 p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative">
                            <div class="absolute top-4 right-4 text-blue-500" id="check-commission">
                                <i data-lucide="check-circle-2" class="w-5 h-5 fill-blue-500 text-white"></i>
                            </div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-blue-500 rounded-xl text-white">
                                    <i data-lucide="percent" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Bagi Hasil / Transaksi</h4>
                                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-md">Mulai Gratis</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed">Sistem digunakan 100% gratis tanpa biaya bulanan. Pendapatan dipotong sebesar <strong class="text-gray-800">8% per transaksi sukses</strong>.</p>
                        </div>

                        <div id="card-monthly" onclick="selectPlan('monthly')"
                            class="border border-gray-200 bg-white p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative">
                            <div class="absolute top-4 right-4 text-gray-300 hidden" id="check-monthly">
                                <i data-lucide="check-circle-2" class="w-5 h-5 fill-blue-500 text-white"></i>
                            </div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-purple-500 rounded-xl text-white">
                                    <i data-lucide="calendar" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Sistem Premium Bulanan</h4>
                                    <span class="text-xs font-bold text-purple-600 bg-purple-100 px-2 py-0.5 rounded-md">Rp 150.000 / bln</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed">Akses penuh seluruh fitur tanpa potongan komisi sepeser pun. <strong class="text-gray-800">Flat 0% komisi</strong>, murni hanya membayar iuran per bulan.</p>
                        </div>

                        <div class="bg-amber-50 border border-amber-100 p-3 rounded-xl text-[11px] text-amber-700 leading-relaxed mt-4">
                            ⚠️ <strong>Catatan:</strong> Skema paket ini bersifat fleksibel dan dapat Anda ubah/sesuaikan kembali kapan saja di masa mendatang melalui koordinasi tim super admin LaundryTrack.
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="button" onclick="goToStep(1)"
                                class="w-1/3 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-1.5 text-sm">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Kembali
                            </button>
                            
                            <button type="submit"
                                class="w-2/3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-md shadow-blue-100 text-sm">
                                <i data-lucide="user-plus" class="w-4 h-4"></i>
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <div class="border-t border-gray-50 px-8 py-4 bg-gray-50 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline ml-1">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        let map, marker;

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            initRegistrationMap();
        });

        // 1. LOGIKA NAVIGASI PINDAH STEP (WIZARD FORM)
        function goToStep(step) {
            const step1Html = document.getElementById('html-step-1');
            const step2Html = document.getElementById('html-step-2');
            const badge1 = document.getElementById('badge-step-1');
            const badge2 = document.getElementById('badge-step-2');
            const lineStep = document.getElementById('line-step');

            if (step === 2) {
                // Validasi sederhana: Pastikan field utama step 1 terisi sebelum lolos ke step 2
                if (!document.getElementById('input_name').value || 
                    !document.getElementById('input_email').value || 
                    !document.getElementById('input_laundry_name').value ||
                    !document.getElementById('laundry_address').value) {
                    alert('Mohon lengkapi seluruh kolom bertanda wajib pada informasi Toko terlebih dahulu.');
                    return;
                }

                // Sembunyikan Step 1, Tampilkan Step 2
                step1Html.classList.add('hidden');
                step2Html.classList.remove('hidden');

                // Update Tampilan Indikator Progress Bar Atas
                badge1.className = "flex items-center gap-2 text-sm font-bold text-gray-400";
                badge1.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs";
                lineStep.className = "w-8 h-[2px] bg-blue-500";
                badge2.className = "flex items-center gap-2 text-sm font-bold text-blue-500";
                badge2.querySelector('span').className = "w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs";
            } else {
                // Kembali ke Step 1
                step2Html.classList.add('hidden');
                step1Html.classList.remove('hidden');

                // Reset Tampilan Indikator Progress Bar Atas
                badge1.className = "flex items-center gap-2 text-sm font-bold text-blue-500";
                badge1.querySelector('span').className = "w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs";
                lineStep.className = "w-8 h-[2px] bg-gray-200";
                badge2.className = "flex items-center gap-2 text-sm font-bold text-gray-400";
                badge2.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs";
                
                // Trigger ulang ukuran peta Leaflet biar gak nge-bug/blank abu-abu setelah disembunyikan div hidden
                setTimeout(() => { map.invalidateSize() }, 100);
            }
        }

        // 2. LOGIKA INTERAKTIF PEMILIHAN KARTU LAYANAN
        function selectPlan(plan) {
            const inputPlan = document.getElementById('subscription_type');
            const cardComm = document.getElementById('card-commission');
            const cardMonth = document.getElementById('card-monthly');
            const checkComm = document.getElementById('check-commission');
            const checkMonth = document.getElementById('check-monthly');

            // Simpan pilihan value ke input hidden
            inputPlan.value = plan;

            if (plan === 'commission') {
                // Highlight Kartu Komisi
                cardComm.className = "border-2 border-blue-500 bg-blue-50/40 p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
                checkComm.classList.remove('hidden');

                // Matikan Highlight Kartu Bulanan
                cardMonth.className = "border border-gray-200 bg-white p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
                checkMonth.classList.add('hidden');
            } else {
                // Highlight Kartu Bulanan
                cardMonth.className = "border-2 border-purple-500 bg-purple-50/30 p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
                checkMonth.classList.remove('hidden');

                // Matikan Highlight Kartu Komisi
                cardComm.className = "border border-gray-200 bg-white p-5 rounded-2xl cursor-pointer transition-all hover:border-blue-400 relative";
                checkComm.classList.add('hidden');
            }
        }

        // 3. SEPERTI KEMARIN: FITUR DETEKSI PETA LEAFLET & AUTOCOMPLETE ALAMAT
        function initRegistrationMap() {
            const latInput = document.getElementById('laundry_lat');
            const lngInput = document.getElementById('laundry_lng');
            const addressInput = document.getElementById('laundry_address');
            const resultsContainer = document.getElementById('autocomplete-results');

            let defaultLat = parseFloat(latInput.value) || -6.2088;
            let defaultLng = parseFloat(lngInput.value) || 106.8456;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            function updateCoordinates(lat, lng) {
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
            }

            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });

            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                marker.setLatLng([lat, lng]);
                updateCoordinates(lat, lng);
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    map.setView([userLat, userLng], 15);
                    marker.setLatLng([userLat, userLng]);
                    updateCoordinates(userLat, userLng);
                });
            }

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

                                    map.setView([newLat, newLng], 16);
                                    marker.setLatLng([newLat, newLng]);
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
        }
    </script>
</body>

</html>