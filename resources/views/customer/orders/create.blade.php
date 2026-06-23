@extends('layouts.app')
@section('title', 'Buat Order Baru')
@section('page-title', 'Order Baru')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Back --}}
    <a href="{{ route('customer.orders.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 mb-6 transition-colors">
        <span class="material-symbols-outlined !text-[18px]">arrow_back</span> Kembali ke Riwayat Order
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
        x-data='{
            selectedService: null,
            services: @json($services),
            pickupType: "antar_sendiri",
            convenienceFee: 5000,
            kurirEnabled: @json($kurirEnabled),
            isSyariah: false,
            hasNajis: "tidak",

            get selectedServiceData() {
                return this.services.find(s => s.id == this.selectedService) || null;
            },
            get estimateMin() {
                if (!this.selectedServiceData) return "—";
                const price = parseFloat(this.selectedServiceData.price_per_kg);
                const fee = this.pickupType === "jemput" ? this.convenienceFee : 0;
                return "Mulai dari Rp " + (price + fee).toLocaleString("id-ID");
            },
            get totalDisplay() {
                if (!this.selectedServiceData) return "—";
                const fee = this.pickupType === "jemput" ? this.convenienceFee : 0;
                return "(Rp " + parseFloat(this.selectedServiceData.price_per_kg).toLocaleString("id-ID") + "/kg) + Rp " + fee.toLocaleString("id-ID") + " layanan";
            }
         }'>

        {{-- Header (Sekarang Dinamis Berdasarkan Toko) --}}
        <div class="px-8 py-6 border-b border-gray-50 bg-gradient-to-r from-blue-600 to-blue-500">
            <h2 class="text-xl font-extrabold text-white">🧺 Buat Order - {{ $shop->name }}</h2>
            <p class="text-blue-100 text-sm mt-1">Isi form berikut untuk memulai order kamu di {{ $shop->name }}</p>
        </div>

        <form method="POST" action="{{ route('customer.orders.store') }}" class="p-8 space-y-6">
            @csrf
            
            {{-- ◄ BARU & PENTING: Mengirimkan ID Toko agar lolos validasi Controller ── --}}
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">

            {{-- ◄ BARU: Kotak Alert Penampil Error Validasi ── --}}
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-100" role="alert">
                    <div class="flex items-center gap-2 font-bold mb-1 text-red-900">
                        <span class="material-symbols-outlined !text-[18px]">error</span>
                        Gagal mengirimkan order! Silakan periksa kembali:
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-red-700 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── Pilih Layanan ────────────────────────────────────── --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500 !text-[18px]">dry_cleaning</span>
                        Pilih Layanan
                    </span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($services as $service)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="service_id" value="{{ $service->id }}"
                            x-model="selectedService" class="peer sr-only"
                            {{ old('service_id') == $service->id ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-4 transition-all
                peer-checked:border-blue-500 peer-checked:bg-blue-50
                border-gray-200 hover:border-blue-300 hover:bg-blue-50/50">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    @php
                                    // MAPPING ICON DIPERBAIKI DI SINI
                                    if (!$service->icon || $service->icon == 'shirt') {
                                        $mappedIcon = 'dry_cleaning';
                                    } elseif ($service->icon == 'sparkles') {
                                        $mappedIcon = 'auto_awesome'; // Terjemahan 'sparkles' untuk Google Material Symbols
                                    } else {
                                        $mappedIcon = $service->icon;
                                    }
                                    @endphp
                                    <span class="material-symbols-outlined text-blue-600 !text-[20px]">{{ $mappedIcon }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $service->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $service->description }}</p>
                                    <p class="text-sm font-bold text-blue-600 mt-1">
                                        Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        ~{{ $service->estimated_days == 0 ? '6 jam' : $service->estimated_days . ' hari' }}
                                    </p>
                                </div>

                                {{-- Bagian indikator lingkaran --}}
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 mt-1 transition-colors"
                                    :class="selectedService == {{ $service->id }} ? 'border-blue-500' : 'border-gray-300'">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500"
                                        x-show="selectedService == {{ $service->id }}"
                                        x-transition></div>
                                </div>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('service_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Jenis Pengiriman ─────────────────────────────────── --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500 !text-[18px]">local_shipping</span>
                        Jenis Pengambilan
                    </span>
                </label>
                <div class="grid grid-cols-2 gap-3">

                    {{-- Antar Sendiri --}}
                    <label class="relative cursor-pointer">
                        <input type="radio" name="pickup_type" value="antar_sendiri"
                            x-model="pickupType" class="peer sr-only" checked>
                        <div class="border-2 rounded-xl p-4 text-center transition-all
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                    border-gray-200 hover:border-blue-300">
                            <span class="material-symbols-outlined mx-auto text-gray-400 peer-checked:!text-blue-500 mb-2 !text-[28px]">person</span>
                            <p class="font-semibold text-sm text-gray-700">Antar Sendiri</p>
                            <p class="text-xs text-gray-400 mt-1">Gratis</p>
                        </div>
                    </label>

                    {{-- Jemput --}}
                    <label class="relative cursor-pointer" :class="!kurirEnabled ? 'opacity-50 cursor-not-allowed' : ''">
                        <input type="radio" name="pickup_type" value="jemput"
                            x-model="pickupType" class="peer sr-only"
                            :disabled="!kurirEnabled">
                        <div class="border-2 rounded-xl p-4 text-center transition-all
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                    border-gray-200 hover:border-blue-300">
                            <span class="material-symbols-outlined mx-auto text-gray-400 peer-checked:!text-blue-500 mb-2 !text-[28px]">local_shipping</span>
                            <p class="font-semibold text-sm text-gray-700">Jemput ke Rumah</p>
                            <p class="text-xs text-blue-600 font-medium mt-1">+Rp {{ $fee ?? 5000 }}</p>
                            <template x-if="!kurirEnabled">
                                <p class="text-xs text-red-400 mt-0.5">Tidak tersedia</p>
                            </template>
                        </div>
                    </label>
                </div>
                @error('pickup_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Alamat Jemput (conditional) ─────────────────────── --}}
            <div x-show="pickupType === 'jemput'" x-transition>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500 !text-[18px]">location_on</span>
                        Alamat Jemput <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea name="pickup_address" rows="2"
                    placeholder="Jl. Merdeka No. 10, RT 01/RW 02, Kel. Sukamaju..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('pickup_address') }}</textarea>

                <label class="block text-sm font-medium text-gray-600 mt-3 mb-1">
                    Catatan untuk kurir (opsional)
                </label>
                <input type="text" name="pickup_note" value="{{ old('pickup_note') }}"
                    placeholder="Rumah cat putih, depan warung Bu Sari"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('pickup_address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── 🌿 OPSI LAYANAN SYARIAH (HALAL) ─────────────────────── --}}
            <div class="border border-emerald-100 rounded-2xl bg-emerald-50/30 p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-emerald-600 !text-[22px]">verified_user</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800">Aktivasi Layanan Syariah</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Pencucian suci syar'i, pemisahan mesin, dan penanganan kotoran/najis khusus.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_syariah" value="1" x-model="isSyariah" class="sr-only peer" {{ old('is_syariah') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                {{-- Kuesioner Deteksi Najis --}}
                <div x-show="isSyariah" x-transition class="pt-3 border-t border-emerald-100/70 space-y-3">
                    <label class="block text-xs font-bold text-emerald-800 uppercase tracking-wider">
                        ⚠️ Deteksi Najis Pakaian
                    </label>
                    <p class="text-xs text-gray-600">Apakah ada bagian pakaian Anda yang terkena najis nyata (seperti ompol bayi, noda darah, kotoran hewan)?</p>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="has_najis" value="tidak" x-model="hasNajis" class="peer sr-only" {{ old('has_najis', 'tidak') === 'tidak' ? 'checked' : '' }}>
                            <div class="border rounded-xl p-3 text-center text-xs font-semibold transition-all border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 hover:bg-gray-50">
                                Bebas Najis
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="has_najis" value="ada" x-model="hasNajis" class="peer sr-only" {{ old('has_najis') === 'ada' ? 'checked' : '' }}>
                            <div class="border rounded-xl p-3 text-center text-xs font-semibold transition-all border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:bg-gray-50">
                                Ada Pakaian Bernajis
                            </div>
                        </label>
                    </div>

                    {{-- Nama Tim Diubah Menjadi Dinamis Berdasarkan Toko --}}
                    <div x-show="hasNajis === 'ada'" x-transition class="mt-2 bg-amber-50/60 border border-amber-100 rounded-xl p-3 text-xs text-amber-800">
                        <p class="font-bold flex items-center gap-1.5">
                            <span class="material-symbols-outlined !text-[18px]">info</span> Prosedur Penting Thaharah:
                        </p>
                        <p class="mt-1 text-gray-600 leading-relaxed">
                            Tim <strong>{{ $shop->name }}</strong> akan memproses pensucian serta pembilasan najis secara syar'i terlebih dahulu (*Thaharah*) sebelum digabungkan ke mesin cuci utama standar sertifikasi halal.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── Notes ───────────────────────────────────────────── --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Catatan khusus (opsional)
                </label>
                <textarea name="notes" rows="2"
                    placeholder="Ada baju berwarna mencolok, pisahkan dari yang putih, dll."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('notes') }}</textarea>
            </div>

            {{-- ── Price Preview ────────────────────────────────────── --}}
            <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                <h3 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined !text-[18px]">calculate</span>
                    Estimasi Harga
                </h3>
                <template x-if="!selectedServiceData">
                    <p class="text-sm text-blue-400 italic">Pilih layanan untuk melihat estimasi harga.</p>
                </template>
                <template x-if="selectedServiceData">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Harga layanan</span>
                            <span class="font-medium">Rp <span x-text="parseFloat(selectedServiceData.price_per_kg).toLocaleString('id-ID')"></span>/kg</span>
                        </div>
                        <div class="flex justify-between text-gray-600" x-show="pickupType === 'jemput'">
                            <span>Biaya jemput</span>
                            <span class="font-medium text-blue-600">+ Rp 5.000</span>
                        </div>
                        <div class="border-t border-blue-200 pt-2 flex justify-between font-bold text-blue-800 text-base">
                            <span>Total (setelah ditimbang)</span>
                            <span x-text="estimateMin"></span>
                        </div>
                        <p class="text-xs text-blue-500">
                            * Berat akan ditimbang oleh kasir. Total final = berat × harga/kg + biaya layanan.
                        </p>
                    </div>
                </template>
            </div>

            {{-- ── Submit ───────────────────────────────────────────── --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl
                            transition-all flex items-center justify-center gap-2 text-sm
                            disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="!selectedService">
                <span class="material-symbols-outlined !text-[18px]">send</span>
                Kirim Order Sekarang
            </button>

        </form>
    </div>
</div>
@endsection