@extends('layouts.app')
@section('title', 'Pembayaran Order ' . $order->order_code)
@section('page-title', 'Pembayaran')

@section('content')
<div class="max-w-lg mx-auto">

    <a href="{{ route('customer.orders.show', $order) }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-blue-600 transition-colors mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Detail Order
    </a>

    {{-- Order Summary --}}
    <div class="bg-blue-600 rounded-2xl p-5 text-white mb-5">
        <p class="text-blue-200 text-sm">Pembayaran untuk</p>
        <p class="font-extrabold text-xl font-mono">{{ $order->order_code }}</p>
        <div class="flex items-end justify-between mt-3">
            <div>
                <p class="text-blue-200 text-xs">{{ $order->service->name }} · {{ $order->weight_kg }} kg</p>
                @if($order->service_fee > 0)
                <p class="text-blue-200 text-xs">+ Biaya jemput Rp {{ number_format($order->service_fee,0,',','.') }}</p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-blue-200 text-xs">Total Tagihan</p>
                <p class="font-extrabold text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Payment Form --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
         x-data="{ method: 'cash', previewUrl: null }">

        <div class="px-6 py-5 border-b border-gray-50">
            <h2 class="font-bold text-gray-800">Pilih Metode Pembayaran</h2>
        </div>

        <form method="POST" action="{{ route('customer.orders.pay.store', $order) }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- Method Selector --}}
            <div class="grid grid-cols-3 gap-3">
                @foreach(['cash' => ['icon'=>'wallet','label'=>'Cash'], 'transfer' => ['icon'=>'building-2','label'=>'Transfer'], 'qris' => ['icon'=>'qr-code','label'=>'QRIS']] as $key => $opt)
                <label class="relative cursor-pointer">
                    <input type="radio" name="method" value="{{ $key }}"
                           x-model="method" class="peer sr-only"
                           {{ $key === 'cash' ? 'checked' : '' }}>
                    <div class="border-2 rounded-xl p-3 text-center transition-all
                                peer-checked:border-blue-500 peer-checked:bg-blue-50
                                border-gray-200 hover:border-blue-300">
                        <i data-lucide="{{ $opt['icon'] }}" class="w-5 h-5 mx-auto text-gray-400 peer-checked:text-blue-500 mb-1"></i>
                        <p class="text-xs font-semibold text-gray-600">{{ $opt['label'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>

            {{-- Cash Instructions --}}
            <div x-show="method === 'cash'" x-transition>
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-sm text-amber-800">
                    <p class="font-semibold mb-1">💵 Pembayaran Tunai</p>
                    <p>Bayar langsung ke kasir saat mengambil cucian. Kasir akan mengkonfirmasi pembayaran.</p>
                </div>
            </div>

            {{-- Transfer Instructions --}}
            <div x-show="method === 'transfer'" x-transition class="space-y-3">
                @php
                    $bankName   = \App\Models\Setting::get('bank_name', 'BCA');
                    $bankAcc    = \App\Models\Setting::get('bank_account_number', '1234567890');
                    $bankHolder = \App\Models\Setting::get('bank_account_name', 'LaundryTrack');
                @endphp
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="font-semibold text-blue-800 text-sm mb-2">🏦 Info Rekening Transfer</p>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bank</span>
                            <span class="font-semibold text-gray-800">{{ $bankName }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Rekening</span>
                            <span class="font-semibold text-gray-800 font-mono">{{ $bankAcc }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">A.N.</span>
                            <span class="font-semibold text-gray-800">{{ $bankHolder }}</span>
                        </div>
                        <div class="flex justify-between border-t border-blue-200 pt-2 mt-2">
                            <span class="text-gray-500">Nominal</span>
                            <span class="font-bold text-blue-700">Rp {{ number_format($order->total_price,0,',','.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QRIS --}}
            <div x-show="method === 'qris'" x-transition>
                @php $qrisImg = \App\Models\Setting::get('qris_image'); @endphp
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 text-center">
                    <p class="font-semibold text-purple-800 text-sm mb-3">📱 Scan QRIS</p>
                    @if($qrisImg)
                        <img src="{{ Storage::url($qrisImg) }}" alt="QRIS" class="w-48 mx-auto rounded-xl border border-purple-200">
                    @else
                        <div class="w-48 h-48 mx-auto bg-purple-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="qr-code" class="w-12 h-12 text-purple-300"></i>
                        </div>
                        <p class="text-xs text-purple-500 mt-2">QR Code belum diupload admin</p>
                    @endif
                    <p class="text-sm font-bold text-purple-700 mt-2">Rp {{ number_format($order->total_price,0,',','.') }}</p>
                </div>
            </div>

            {{-- Upload Bukti (untuk transfer & qris) --}}
            <div x-show="method === 'transfer' || method === 'qris'" x-transition class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">
                    Upload Bukti Pembayaran <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center"
                     x-on:dragover.prevent x-on:drop.prevent="
                        const f = $event.dataTransfer.files[0];
                        if(f) { previewUrl = URL.createObjectURL(f); $refs.fileInput.files = $event.dataTransfer.files; }
                     ">
                    <template x-if="!previewUrl">
                        <div>
                            <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                            <p class="text-sm text-gray-500">Drag & drop atau klik untuk pilih</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, max 2MB</p>
                        </div>
                    </template>
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="Preview" class="max-h-36 mx-auto rounded-xl">
                    </template>
                    <input type="file" name="proof_image" accept="image/*"
                           x-ref="fileInput"
                           x-on:change="previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                           class="hidden" id="proof_file">
                    <label for="proof_file" class="mt-3 inline-block cursor-pointer text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1.5 rounded-lg transition-colors">
                        Pilih File
                    </label>
                </div>
                @error('proof_image')
                <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Catatan (opsional)</label>
                <input type="text" name="notes" placeholder="No. transaksi, keterangan, dll."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-4 h-4"></i>
                Kirim Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection