@extends('layouts.app')
@section('title', 'Pengaturan WhatsApp')
@section('page-title', 'Pengaturan WhatsApp')

@section('content')
@php
    $wa       = app(\App\Services\WhatsAppService::class);
    $apiUrl   = config('services.whatsapp.url');
    $apiToken = config('services.whatsapp.token');
    $adminPhone = config('services.whatsapp.admin_phone');
    $isConfigured = $wa->useApi;
@endphp

<div class="max-w-3xl mx-auto space-y-6">

    {{-- ── Status Card ─────────────────────────────────────────────── --}}
    <div class="rounded-2xl border overflow-hidden
                {{ $isConfigured ? 'border-green-200 bg-green-50' : 'border-amber-200 bg-amber-50' }}">
        <div class="px-6 py-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center
                        {{ $isConfigured ? 'bg-green-100' : 'bg-amber-100' }}">
                <i data-lucide="{{ $isConfigured ? 'check-circle' : 'alert-triangle' }}"
                   class="w-6 h-6 {{ $isConfigured ? 'text-green-600' : 'text-amber-600' }}"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg {{ $isConfigured ? 'text-green-800' : 'text-amber-800' }}">
                    {{ $isConfigured ? 'WhatsApp API Aktif ✓' : 'Mode Deep-link (Tanpa API)' }}
                </h2>
                <p class="text-sm mt-1 {{ $isConfigured ? 'text-green-700' : 'text-amber-700' }}">
                    @if($isConfigured)
                        Notifikasi WA akan dikirim otomatis ke customer & kurir via <strong>Fonnte API</strong>.
                    @else
                        Notifikasi WA <strong>tidak dikirim otomatis</strong>.
                        Sistem menggunakan <strong>deep-link wa.me</strong> sebagai fallback —
                        customer/kasir harus klik link untuk chat manual.
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- ── Konfigurasi .env ────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-2">
            <i data-lucide="settings" class="w-5 h-5 text-blue-500"></i>
            <h2 class="font-bold text-gray-800">Konfigurasi .env</h2>
        </div>
        <div class="p-6 space-y-4">

            {{-- WA_API_URL --}}
            <div class="flex items-start gap-4">
                <div class="w-3 h-3 rounded-full mt-1 flex-shrink-0
                            {{ !empty($apiUrl) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700 font-mono">WA_API_URL</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ !empty($apiUrl) ? $apiUrl : '— belum diisi —' }}
                    </p>
                    <p class="text-xs text-blue-500 mt-1">Contoh: https://api.fonnte.com/send</p>
                </div>
            </div>

            {{-- WA_API_TOKEN --}}
            <div class="flex items-start gap-4">
                <div class="w-3 h-3 rounded-full mt-1 flex-shrink-0
                            {{ !empty($apiToken) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700 font-mono">WA_API_TOKEN</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ !empty($apiToken) ? str_repeat('•', 20) . substr($apiToken, -4) : '— belum diisi —' }}
                    </p>
                    <p class="text-xs text-blue-500 mt-1">Token dari dashboard Fonnte</p>
                </div>
            </div>

            {{-- WA_ADMIN_PHONE --}}
            <div class="flex items-start gap-4">
                <div class="w-3 h-3 rounded-full mt-1 flex-shrink-0
                            {{ !empty($adminPhone) ? 'bg-green-500' : 'bg-amber-400' }}"></div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700 font-mono">WA_ADMIN_PHONE</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ !empty($adminPhone) ? $adminPhone : '— belum diisi (dipakai untuk link konfirmasi bayar) —' }}
                    </p>
                </div>
            </div>

            {{-- Cara edit --}}
            <div class="mt-4 bg-gray-50 rounded-xl p-4 text-xs font-mono text-gray-600 space-y-1">
                <p class="text-gray-400 font-sans font-medium mb-2">Edit file .env di root project:</p>
                <p class="{{ !empty($apiUrl) ? 'text-green-700' : 'text-gray-500' }}">WA_API_URL=https://api.fonnte.com/send</p>
                <p class="{{ !empty($apiToken) ? 'text-green-700' : 'text-gray-500' }}">WA_API_TOKEN=token_fonnte_kamu_disini</p>
                <p class="{{ !empty($adminPhone) ? 'text-green-700' : 'text-gray-500' }}">WA_ADMIN_PHONE=081234567890</p>
                <div class="mt-3 pt-3 border-t border-gray-200 font-sans text-gray-400">
                    Setelah edit .env, jalankan: <code class="bg-gray-200 px-1.5 py-0.5 rounded text-gray-700">php artisan config:clear</code>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Test Kirim Notifikasi ───────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
         x-data="{ phone: '', sending: false, result: null }">
        <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-2">
            <i data-lucide="send" class="w-5 h-5 text-blue-500"></i>
            <h2 class="font-bold text-gray-800">Test Kirim WA</h2>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-500 mb-4">
                Masukkan nomor HP untuk test pengiriman notifikasi WhatsApp.
            </p>
            <div class="flex gap-3">
                <input type="tel" x-model="phone"
                       placeholder="081234567890"
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button @click="testSend()"
                        :disabled="sending || phone.length < 8"
                        class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 transition-colors">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span x-text="sending ? 'Mengirim...' : 'Test Kirim'"></span>
                </button>
            </div>

            {{-- Result --}}
            <div x-show="result" x-transition class="mt-4 p-4 rounded-xl text-sm"
                 :class="result?.success ? 'bg-green-50 border border-green-100 text-green-800' : 'bg-amber-50 border border-amber-100 text-amber-800'">
                <p class="font-semibold" x-text="result?.title"></p>
                <p class="mt-1 text-xs" x-text="result?.message"></p>
                <a x-show="result?.deepLink" :href="result?.deepLink" target="_blank"
                   class="inline-flex items-center gap-1.5 mt-2 text-xs bg-green-600 text-white px-3 py-1.5 rounded-lg">
                    <i data-lucide="external-link" class="w-3 h-3"></i>
                    Buka di WhatsApp (Deep-link)
                </a>
            </div>
        </div>
    </div>

    {{-- ── Kapan Notifikasi Dikirim ────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h2 class="font-bold text-gray-800">Kapan Notifikasi WA Dikirim?</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @php
            $events = [
                ['event'=>'Order Baru Dibuat',      'trigger'=>'Customer submit order',              'to'=>'Customer',        'icon'=>'shopping-bag','color'=>'blue'],
                ['event'=>'Status → Pickup',        'trigger'=>'Kasir advance / Kurir accept',       'to'=>'Customer + Kurir','icon'=>'truck',      'color'=>'amber'],
                ['event'=>'Status → In Process',    'trigger'=>'Kurir konfirmasi / Kasir advance',   'to'=>'Customer',        'icon'=>'zap',        'color'=>'purple'],
                ['event'=>'Status → Ready',         'trigger'=>'Kasir advance status',               'to'=>'Customer',        'icon'=>'check-circle','color'=>'green'],
                ['event'=>'Status → Finished',      'trigger'=>'Kasir advance status terakhir',      'to'=>'Customer',        'icon'=>'star',       'color'=>'gray'],
                ['event'=>'Pembayaran Diverifikasi','trigger'=>'Kasir klik Verifikasi Lunas',         'to'=>'Customer',        'icon'=>'check',      'color'=>'green'],
                ['event'=>'Pembayaran Ditolak',     'trigger'=>'Kasir klik Tolak',                   'to'=>'Customer',        'icon'=>'x',          'color'=>'red'],
            ];
            $ic=['blue'=>'bg-blue-50 text-blue-600','amber'=>'bg-amber-50 text-amber-600','purple'=>'bg-purple-50 text-purple-600','green'=>'bg-green-50 text-green-600','red'=>'bg-red-50 text-red-600','gray'=>'bg-gray-100 text-gray-500'];
            @endphp
            @foreach($events as $e)
            <div class="flex items-center gap-4 px-6 py-3">
                <div class="w-9 h-9 rounded-xl {{ $ic[$e['color']] }} flex items-center justify-center flex-shrink-0">
                    <i data-lucide="{{ $e['icon'] }}" class="w-4 h-4"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">{{ $e['event'] }}</p>
                    <p class="text-xs text-gray-400">Dipicu: {{ $e['trigger'] }}</p>
                </div>
                <span class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full font-medium flex-shrink-0">
                    → {{ $e['to'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Panduan Daftar Fonnte ───────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h2 class="font-bold text-gray-800">Cara Daftar & Setup Fonnte</h2>
        </div>
        <div class="p-6">
            @php
            $steps = [
                ['n'=>1,'title'=>'Buka fonnte.com dan klik Daftar','desc'=>'Daftar menggunakan email aktif. Konfirmasi email dari inbox kamu.'],
                ['n'=>2,'title'=>'Tambah Device WhatsApp','desc'=>'Di dashboard Fonnte, klik "Add Device" → scan QR Code menggunakan WhatsApp HP bisnis kamu (bukan HP pribadi jika bisa).'],
                ['n'=>3,'title'=>'Salin API Token','desc'=>'Setelah device terconnect, klik nama device → salin "Token" yang ada di halaman device.'],
                ['n'=>4,'title'=>'Isi .env Laravel','desc'=>'Paste token ke WA_API_TOKEN di file .env. Isi WA_API_URL=https://api.fonnte.com/send dan WA_ADMIN_PHONE=nomor HP admin.'],
                ['n'=>5,'title'=>'Clear cache & test','desc'=>'Jalankan: php artisan config:clear — lalu coba test kirim WA dari halaman ini.'],
            ];
            @endphp
            <div class="space-y-4">
                @foreach($steps as $s)
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold flex items-center justify-center flex-shrink-0">
                        {{ $s['n'] }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $s['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="https://fonnte.com" target="_blank"
               class="mt-5 inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Buka Fonnte.com
            </a>
        </div>
    </div>

</div>

@push('scripts')
<script>
async function testSend() {
    const comp = document.querySelector('[x-data]').__x.$data;
    if (!comp.phone || comp.phone.length < 8) return;

    comp.sending = true;
    comp.result  = null;

    try {
        const res = await fetch('/admin/wa/test', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ phone: comp.phone }),
        });
        const data = await res.json();
        comp.result = data;
    } catch(e) {
        comp.result = { success: false, title: 'Error koneksi', message: e.message };
    } finally {
        comp.sending = false;
    }
}
</script>
@endpush
@endsection