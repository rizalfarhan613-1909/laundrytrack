@extends('layouts.app')
@section('title', 'Pengaturan Poin Loyalitas')
@section('page-title', 'Pengaturan Poin Loyalitas')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Card Form Pengaturan --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3 bg-gray-50">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <i data-lucide="gift" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Sistem Poin Loyalitas</h2>
                <p class="text-xs text-gray-400">Atur parameter perolehan poin otomatis untuk pelanggan toko laundry Anda.</p>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('kasir.loyalty.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 1. TOMBOL SWITCH / TOGGLE STATUS AKTIF --}}
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="space-y-0.5">
                        <label class="text-sm font-semibold text-gray-700" for="is_active">Aktifkan Fitur Poin</label>
                        <p class="text-xs text-gray-400">Jika dinonaktifkan, transaksi selesai tidak akan menghasilkan poin bagi pelanggan.</p>
                    </div>
                    
                    {{-- Tailwind Toggle Switch --}}
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="sr-only peer" {{ $setting->is_active ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- 2. INPUT MINIMAL TRANSAKSI (THRESHOLD AMOUNT) --}}
                    <div class="space-y-2">
                        <label for="threshold_amount" class="text-sm font-semibold text-gray-700 block">Minimal Transaksi (Kelipatan)</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">Rp</span>
                            </div>
                            <input type="number" 
                                   id="threshold_amount" 
                                   name="threshold_amount" 
                                   value="{{ old('threshold_amount', $setting->threshold_amount) }}" 
                                   class="block w-full pl-9 pr-3 py-2.5 bg-white border @error('threshold_amount') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-blue-500 focus:ring-blue-500 @enderror rounded-xl text-sm focus:outline-none focus:ring-1"
                                   placeholder="Contoh: 50000" 
                                   min="1000" 
                                   required>
                        </div>
                        @error('threshold_amount')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400">Batas kelipatan harga order untuk mendapatkan poin.</p>
                    </div>

                    {{-- 3. INPUT JUMLAH POIN YANG DIDAPAT (POINTS EARNED) --}}
                    <div class="space-y-2">
                        <label for="points_earned" class="text-sm font-semibold text-gray-700 block">Jumlah Poin Diperoleh</label>
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" 
                                   id="points_earned" 
                                   name="points_earned" 
                                   value="{{ old('points_earned', $setting->points_earned) }}" 
                                   class="block w-full pr-12 pl-3 py-2.5 bg-white border @error('points_earned') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-blue-500 focus:ring-blue-500 @enderror rounded-xl text-sm focus:outline-none focus:ring-1"
                                   placeholder="Contoh: 1" 
                                   min="1" 
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">Poin</span>
                            </div>
                        </div>
                        @error('points_earned')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400">Poin yang didapat setiap menyentuh angka minimal transaksi.</p>
                    </div>
                </div>

                {{-- Simulasi Keterangan Aturan --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5"></i>
                    <div class="text-xs text-blue-700 space-y-1">
                        <span class="font-bold">Simulasi Aturan Aktif Saat Ini:</span>
                        <p>Setiap pelanggan yang bertransaksi kelipatan <span class="font-bold">Rp {{ number_format($setting->threshold_amount, 0, ',', '.') }}</span> akan otomatis mendapatkan <span class="bg-blue-600 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">{{ $setting->points_earned }} Poin</span> setelah status order diubah ke selesai.</p>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Konfigurasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection