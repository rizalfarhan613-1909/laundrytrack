@extends('layouts.app')
@section('title', 'Buat Order Baru')
@section('page-title', 'Order Baru')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Back --}}
    <a href="{{ route('customer.orders.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Riwayat Order
    </a>

    {{-- PERBAIKAN DI SINI: x-data menggunakan tanda kutip tunggal (') agar @json tidak merusak HTML --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
         x-data='{
            selectedService: null,
            services: @json($services),
            pickupType: "antar_sendiri",
            convenienceFee: 5000,
            kurirEnabled: @json($kurirEnabled),

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

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-50 bg-gradient-to-r from-blue-600 to-blue-500">
            <h2 class="text-xl font-extrabold text-white">🧺 Buat Order Laundry</h2>
            <p class="text-blue-100 text-sm mt-1">Isi form berikut untuk memulai order kamu</p>
        </div>

        <form method="POST" action="{{ route('customer.orders.store') }}" class="p-8 space-y-6">
            @csrf

            {{-- ── Pilih Layanan ────────────────────────────────────── --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">
                    <span class="flex items-center gap-2">
                        <i data-lucide="shirt" class="w-4 h-4 text-blue-500"></i>
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
                                    <i data-lucide="{{ $service->icon ?? 'shirt' }}" class="w-4 h-4 text-blue-600"></i>
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
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-blue-500
                                            flex items-center justify-center flex-shrink-0 mt-1
                                            peer-[.peer:checked~&]:border-blue-500">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 hidden peer-checked:block"></div>
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
                        <i data-lucide="truck" class="w-4 h-4 text-blue-500"></i>
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
                            <i data-lucide="user" class="w-6 h-6 mx-auto text-gray-400 peer-checked:text-blue-500 mb-2"></i>
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
                            <i data-lucide="truck" class="w-6 h-6 mx-auto text-gray-400 peer-checked:text-blue-500 mb-2"></i>
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
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
                        Alamat Jemput <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea name="pickup_address" rows="2"
                          placeholder="Jl. Merdeka No. 10, RT 01/RW 02, Kel. Sukamaju..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                          >{{ old('pickup_address') }}</textarea>

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
                    <i data-lucide="calculator" class="w-4 h-4"></i>
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
                <i data-lucide="send" class="w-4 h-4"></i>
                Kirim Order Sekarang
            </button>

        </form>
    </div>
</div>
@endsection