@extends('layouts.app')
@section('title', 'Manajemen Pembayaran')
@section('page-title', 'Manajemen Pembayaran')

@section('content')
<div class="space-y-5" x-data="paymentManager()">

    {{-- ── Status Tabs + Count ─────────────────────────────────────── --}}
    <div class="flex items-center gap-3 flex-wrap">
        @foreach([
            'pending'  => ['label' => 'Menunggu Verifikasi', 'color' => 'amber',  'count' => $counts['pending']],
            'verified' => ['label' => 'Sudah Lunas',         'color' => 'green',  'count' => $counts['verified']],
            'rejected' => ['label' => 'Ditolak',             'color' => 'red',    'count' => $counts['rejected']],
            'all'      => ['label' => 'Semua',               'color' => 'gray',   'count' => array_sum($counts)],
        ] as $key => $tab)
        <a href="{{ route('kasir.payments.index', ['status' => $key, 'search' => $search]) }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all
                  {{ $status === $key
                     ? 'bg-blue-600 text-white shadow-sm'
                     : 'bg-white border border-gray-200 text-gray-600 hover:border-blue-300' }}">
            {{ $tab['label'] }}
            <span class="text-xs px-1.5 py-0.5 rounded-full
                         {{ $status === $key ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">
                {{ $tab['count'] }}
            </span>
        </a>
        @endforeach

        {{-- Search --}}
        <form method="GET" action="{{ route('kasir.payments.index') }}" class="ml-auto flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari kode / nama..."
                   class="border border-gray-200 rounded-xl px-4 py-2 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                Cari
            </button>
        </form>
    </div>

    {{-- ── Payment Cards ───────────────────────────────────────────── --}}
    @forelse($payments as $payment)
    @php
        $order = $payment->order;
        $isPending  = $payment->status === 'pending';
        $isVerified = $payment->status === 'verified';
        $isRejected = $payment->status === 'rejected';
        $needsAction = $isPending && in_array($payment->method, ['transfer','qris']);
    @endphp

    <div class="bg-white rounded-2xl border {{ $needsAction ? 'border-amber-200 shadow-amber-50 shadow-md' : 'border-gray-100' }} overflow-hidden"
         id="pay-{{ $payment->id }}">

        {{-- Card Header --}}
        <div class="flex items-start gap-4 p-5">

            {{-- Method Icon --}}
            <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center
                        {{ $payment->method === 'cash' ? 'bg-green-50' : ($payment->method === 'qris' ? 'bg-purple-50' : 'bg-blue-50') }}">
                @if($payment->method === 'cash')
                    <i data-lucide="banknote" class="w-6 h-6 text-green-600"></i>
                @elseif($payment->method === 'qris')
                    <i data-lucide="qr-code" class="w-6 h-6 text-purple-600"></i>
                @else
                    <i data-lucide="building-2" class="w-6 h-6 text-blue-600"></i>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-bold text-gray-800 font-mono text-sm">{{ $payment->payment_code }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Order: <span class="font-semibold text-blue-600 font-mono">{{ $order->order_code }}</span>
                            · {{ $order->customer->name }}
                        </p>
                    </div>
                    {{-- Status Badge --}}
                    <span class="flex-shrink-0 text-xs px-3 py-1.5 rounded-full font-semibold
                                 {{ $isPending ? 'bg-amber-100 text-amber-700' : ($isVerified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                        @if($isPending)   ⏳ Menunggu
                        @elseif($isVerified) ✅ Lunas
                        @else ❌ Ditolak
                        @endif
                    </span>
                </div>

                {{-- Detail row --}}
                <div class="flex flex-wrap items-center gap-4 mt-2 text-sm">
                    <span class="font-extrabold text-blue-700 text-lg">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-lg uppercase font-medium">
                        {{ $payment->method }}
                    </span>
                    <span class="text-xs text-gray-400">
                        {{ $payment->created_at->isoFormat('D MMM Y, HH:mm') }}
                    </span>
                    @if($payment->verified_at)
                    <span class="text-xs text-green-600">
                        Diverifikasi {{ $payment->verified_at->diffForHumans() }}
                        @if($payment->verifier) oleh {{ $payment->verifier->name }} @endif
                    </span>
                    @endif
                </div>

                @if($payment->notes)
                <p class="text-xs text-gray-400 mt-1.5 italic">📝 {{ $payment->notes }}</p>
                @endif
            </div>
        </div>

        {{-- Bukti Transfer Preview (jika ada) --}}
        @if($payment->proof_image)
        <div class="px-5 pb-4" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center gap-2 text-xs text-blue-600 hover:text-blue-700 font-medium">
                <i data-lucide="image" class="w-3.5 h-3.5"></i>
                <span x-text="open ? 'Sembunyikan Bukti' : 'Lihat Bukti Transfer/QRIS'"></span>
            </button>
            <div x-show="open" x-transition class="mt-3">
                <img src="{{ Storage::url($payment->proof_image) }}"
                     alt="Bukti bayar {{ $payment->payment_code }}"
                     class="max-h-72 rounded-xl border border-gray-200 object-contain cursor-zoom-in"
                     @click="$dispatch('open-lightbox', '{{ Storage::url($payment->proof_image) }}')">
                <p class="text-xs text-gray-400 mt-1">
                    Klik gambar untuk memperbesar
                </p>
            </div>
        </div>
        @endif

        {{-- ── Action Bar (hanya untuk pending) ───────────────────── --}}
        @if($isPending)
        <div class="border-t border-gray-50 bg-gray-50 px-5 py-4">
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">

                {{-- Notes input --}}
                <div class="flex-1 max-w-sm">
                    <input type="text"
                           id="notes-{{ $payment->id }}"
                           placeholder="Catatan (opsional, misal: sudah diterima)"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2 flex-shrink-0">

                    {{-- WA Customer --}}
                    @if($order->customer->phone)
                        @php
                            // Membersihkan nomor telepon (menghilangkan karakter selain angka)
                            $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer->phone);
                            // Jika nomor dimulai dengan 0, ubah ke 62
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            
                            $message = "Halo " . $order->customer->name . ", ada pertanyaan mengenai pembayaran order " . $order->order_code . ".";
                            $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($message);
                        @endphp

                        <a href="{{ $waUrl }}"
                        target="_blank"
                        class="flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-2 rounded-xl text-xs font-semibold hover:bg-green-100 transition-colors">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            WA Customer
                        </a>
                    @endif

                    {{-- TOLAK --}}
                    <button onclick="verifyPayment({{ $payment->id }}, 'reject')"
                            class="flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded-xl text-xs font-semibold hover:bg-red-100 transition-colors">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        Tolak
                    </button>

                    {{-- VERIFIKASI --}}
                    <button onclick="verifyPayment({{ $payment->id }}, 'verify')"
                            class="flex items-center gap-1.5 bg-green-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-green-700 transition-colors shadow-sm">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        Verifikasi Lunas
                    </button>
                </div>
            </div>
        </div>
        @elseif($isVerified)
        <div class="border-t border-green-50 bg-green-50 px-5 py-3 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i>
            <span class="text-xs text-green-700 font-medium">
                Pembayaran terverifikasi
                @if($payment->verifier) oleh {{ $payment->verifier->name }} @endif
                · {{ $payment->verified_at?->isoFormat('D MMM Y, HH:mm') }}
            </span>
        </div>
        @elseif($isRejected)
        <div class="border-t border-red-50 bg-red-50 px-5 py-3 flex items-center gap-2">
            <i data-lucide="x-circle" class="w-4 h-4 text-red-400"></i>
            <span class="text-xs text-red-700 font-medium">Pembayaran ditolak</span>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
        <i data-lucide="credit-card" class="w-10 h-10 mx-auto mb-3 text-gray-200"></i>
        <p class="font-semibold text-gray-500">Tidak ada pembayaran</p>
        <p class="text-sm text-gray-400 mt-1">
            {{ $status === 'pending' ? 'Semua pembayaran sudah diverifikasi 🎉' : 'Belum ada data untuk filter ini.' }}
        </p>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($payments->hasPages())
    <div>{{ $payments->appends(request()->query())->links() }}</div>
    @endif

</div>

{{-- Lightbox untuk lihat gambar fullscreen --}}
<div x-data="{ show: false, src: '' }"
     @open-lightbox.window="show = true; src = $event.detail"
     x-show="show"
     @click="show = false"
     @keydown.escape.window="show = false"
     class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4 cursor-zoom-out"
     style="display:none">
    <img :src="src" alt="Bukti bayar" class="max-w-full max-h-full rounded-xl object-contain">
    <button @click.stop="show = false"
            class="absolute top-4 right-4 w-10 h-10 bg-white/20 text-white rounded-full flex items-center justify-center hover:bg-white/30">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
</div>

@push('scripts')
<script>
async function verifyPayment(id, action) {
    const notes = document.getElementById('notes-' + id)?.value || '';
    const label = action === 'verify' ? 'Verifikasi sebagai LUNAS?' : 'Tolak pembayaran ini?';

    if (!confirm(label)) return;

    const btn  = event.currentTarget;
    const orig = btn.innerHTML;
    btn.disabled  = true;
    btn.innerHTML = action === 'verify'
        ? '<span class="opacity-70">Memproses...</span>'
        : '<span class="opacity-70">Menolak...</span>';

    try {
        const res = await fetch(`/kasir/payments/${id}/quick-verify`, {
            method:  'POST',
            headers: {
                'Content-Type':  'application/json',
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content,
                'Accept':        'application/json',
            },
            body: JSON.stringify({ action, notes }),
        });

        const data = await res.json();

        if (data.success) {
            // Animasi transisi card
            const card = document.getElementById('pay-' + id);
            card.style.transition = 'opacity 0.4s, transform 0.4s';
            card.style.opacity    = '0';
            card.style.transform  = 'translateY(-8px)';

            setTimeout(() => {
                card.remove();
                showToast(
                    action === 'verify'
                        ? '✅ Pembayaran berhasil diverifikasi! Notifikasi WA dikirim ke customer.'
                        : '❌ Pembayaran ditolak. Notifikasi WA dikirim ke customer.',
                    action === 'verify' ? 'success' : 'error'
                );
                // Update counter badge
                updateCounter();
            }, 400);
        } else {
            btn.disabled  = false;
            btn.innerHTML = orig;
            alert(data.message || 'Gagal memproses.');
        }
    } catch(e) {
        btn.disabled  = false;
        btn.innerHTML = orig;
        alert('Error koneksi. Coba lagi.');
    }
}

function showToast(msg, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl text-sm font-medium shadow-xl transition-all
        ${type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
    toast.innerHTML = msg;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function updateCounter() {
    // Reload halaman setelah 2 detik untuk refresh semua counter
    setTimeout(() => window.location.reload(), 1500);
}

// Re-init lucide setelah Alpine mount
document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endpush
@endsection