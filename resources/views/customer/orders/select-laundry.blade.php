@extends('layouts.app')
@section('title', 'Pilih Toko Laundry')
@section('page-title', 'Pilih Toko Laundry')

@section('content')
<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-900">Mau laundry di mana hari ini?</h3>
        <p class="text-sm text-gray-500">Pilih mitra outlet laundry terdekat untuk mulai membuat pesanan.</p>
    </div>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Grid Daftar Toko --}}
    <div id="shop-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($shops as $shop)
            <div class="shop-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between transition hover:shadow-md"
                 data-lat="{{ $shop->latitude ?? 0 }}" 
                 data-lng="{{ $shop->longitude ?? 0 }}">
                
                <div>
                    {{-- Foto Toko Laundry --}}
                    <div class="w-full h-40 bg-gray-100 relative overflow-hidden border-b border-gray-100">
                        @if($shop->image)
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex flex-col items-center justify-center text-white gap-1">
                                <span class="text-4xl">🏪</span>
                                <span class="text-xs font-semibold opacity-75">LaundryTrack Partner</span>
                            </div>
                        @endif
                    </div>

                    {{-- Konten Informasi Toko --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $shop->name }}</h4>
                            
                            {{-- Badge Jarak: Otomatis muncul via JavaScript --}}
                            <span class="distance-badge hidden inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 whitespace-nowrap">
                                🚗 <span class="distance-text ml-1">-- km</span>
                            </span>
                        </div>

                        <p class="text-gray-500 text-xs mb-4 flex items-start gap-1">
                            <span class="shrink-0">📍</span> 
                            <span class="line-clamp-2">{{ $shop->address ?? 'Alamat belum diatur' }}</span>
                        </p>
                        
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Buka
                        </span>
                    </div>
                </div>
                
                {{-- Button Pilih --}}
                <div class="p-5 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('customer.orders.create', ['shop_id' => $shop->id]) }}" 
                       class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                        Pilih & Lihat Layanan
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-lg border border-dashed">
                <p class="text-gray-500">Belum ada toko laundry yang terdaftar di sistem.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Ready. Mengecek Geolocation...');
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            console.log('Lokasi didapatkan:', position.coords.latitude, position.coords.longitude);
            
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            const shopCards = Array.from(document.querySelectorAll('.shop-card'));
            console.log('Jumlah toko ditemukan:', shopCards.length);
            
            if (shopCards.length === 0) {
                console.error('Error: Tidak ada elemen dengan class .shop-card ditemukan!');
                return;
            }

            const gridContainer = document.getElementById('shop-grid');
            
            shopCards.forEach(card => {
                const shopLat = parseFloat(card.dataset.lat);
                const shopLng = parseFloat(card.dataset.lng);
                
                console.log('Toko:', card.querySelector('h4').textContent, 'Lat:', shopLat, 'Lng:', shopLng);
                
                if (!isNaN(shopLat) && !isNaN(shopLng) && shopLat !== 0) {
                    const distance = haversineDistance(userLat, userLng, shopLat, shopLng);
                    
                    const badge = card.querySelector('.distance-badge');
                    const text = card.querySelector('.distance-text');
                    
                    if (badge && text) {
                        text.textContent = distance.toFixed(1) + ' km';
                        badge.classList.remove('hidden');
                        console.log('Jarak berhasil dihitung:', distance.toFixed(1));
                    }
                    card.dataset.calculatedDistance = distance;
                } else {
                    console.warn('Koordinat toko tidak valid atau kosong untuk:', card.querySelector('h4').textContent);
                }
            });
            
            // Urutkan
            shopCards.sort((a, b) => {
                const distA = parseFloat(a.dataset.calculatedDistance) || 999999;
                const distB = parseFloat(b.dataset.calculatedDistance) || 999999;
                return distA - distB;
            });
            
            shopCards.forEach(card => gridContainer.appendChild(card));
            
        }, function (error) {
            console.error('Geolocation Error Code:', error.code, 'Message:', error.message);
        });
    } else {
        console.error('Browser tidak mendukung Geolocation.');
    }
    
    function haversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; 
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }
});
</script>
@endsection