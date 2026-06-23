@extends('layouts.app')
@section('title', 'Pengaturan Profil Toko')
@section('page-title', 'Pengaturan Profil Toko')

{{-- Tambahkan CDN Leaflet CSS di bagian atas --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-md shadow-sm">
            ✨ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Informasi Dasar Mitra</h3>
                <p class="text-xs text-gray-500">Sesuaikan identitas outlet laundry Anda yang akan dilihat langsung oleh pelanggan.</p>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Toko --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko Laundry <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $laundry->name) }}" 
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp Toko <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $laundry->phone) }}" placeholder="Contoh: 08123456789"
                               class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>

                {{-- Alamat Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap Outlet <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" 
                              class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address', $laundry->address) }}</textarea>
                </div>

                {{-- Upload Foto Toko --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto / Logo Toko Laundry</label>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0 flex items-center justify-center">
                            @if($laundry->image)
                                <img src="{{ asset('storage/' . $laundry->image) }}" alt="Preview" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">🏪</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <input type="file" name="image" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP. Maksimal ukuran file 2MB.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Lokasi & Koordinat Peta</h3>
                    <p class="text-xs text-gray-500">Klik pada peta atau geser pin biru tepat di lokasi outlet laundry Anda berada.</p>
                </div>
                <button type="button" id="btn-geolocation" 
                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-md text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition shadow-sm">
                    📍 Deteksi GPS Perangkat
                </button>
            </div>

            <div class="p-6 space-y-4">
                {{-- Wadah Peta Leaflet --}}
                <div id="map" class="w-full h-72 rounded-lg border border-gray-200 z-10"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Latitude --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Garis Lintang (Latitude)</label>
                        <input type="text" name="latitude" id="input-lat" value="{{ old('latitude', $laundry->latitude) }}" placeholder="Contoh: 3.5952" readonly
                               class="block w-full rounded-md border-gray-300 text-sm bg-gray-50 text-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Longitude --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Garis Bujur (Longitude)</label>
                        <input type="text" name="longitude" id="input-lng" value="{{ old('longitude', $laundry->longitude) }}" placeholder="Contoh: 98.6722" readonly
                               class="block w-full rounded-md border-gray-300 text-sm bg-gray-50 text-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-md text-sm font-bold shadow-sm hover:bg-indigo-700 transition">
                Simpan Perubahan Profil
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT LEAFLET JS & LOGIC --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil koordinat awal dari database, jika kosong gunakan default (contoh koordinat pusat Medan/Sumut)
    let defaultLat = {{ $laundry->latitude ?? 3.595196 }};
    let defaultLng = {{ $laundry->longitude ?? 98.672225 }};
    
    // 1. Inisialisasi Map Leaflet
    const map = L.map('map').setView([defaultLat, defaultLng], 15);

    // 2. Pasang Layer Peta OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // 3. Pasang Marker Pin Biru yang bisa Di-drag
    const marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    // Fungsi pembantu mengisi kolom input text otomatis
    function updateInputs(lat, lng) {
        document.getElementById('input-lat').value = lat.toFixed(6);
        document.getElementById('input-lng').value = lng.toFixed(6);
    }

    // Event ketika Pin selesai digeser (dragend)
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateInputs(position.lat, position.lng);
    });

    // Event ketika area Peta diklik langsung oleh user
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        marker.setLatLng([lat, lng]);
        updateInputs(lat, lng);
    });

    // 4. Tombol Otomatis Pencarian GPS Perangkat
    document.getElementById('btn-geolocation').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;

        if (navigator.geolocation) {
            btn.disabled = true;
            btn.innerHTML = '🔄 Melacak Lokasi...';

            navigator.geolocation.getCurrentPosition(function(position) {
                const currentLat = position.coords.latitude;
                const currentLng = position.coords.longitude;
                
                // Pindahkan fokus map dan marker ke lokasi baru
                map.setView([currentLat, currentLng], 17);
                marker.setLatLng([currentLat, currentLng]);
                updateInputs(currentLat, currentLng);
                
                btn.disabled = false;
                btn.innerHTML = '✅ Lokasi Didapat';
                setTimeout(() => { btn.innerHTML = originalText; }, 2500);
            }, function(error) {
                btn.disabled = false;
                btn.innerHTML = originalText;
                alert('Akses lokasi diblokir atau gagal didapatkan.');
            });
        } else {
            alert('Browser Anda tidak mendukung Geolocation.');
        }
    });
});
</script>
@endsection