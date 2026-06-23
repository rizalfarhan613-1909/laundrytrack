{{--
    resources/views/admin/services/index.blade.php
    ─────────────────────────────────────────────
    Halaman daftar semua layanan laundry.
    Fitur: tabel harga, toggle aktif/nonaktif, hapus, link ke create/edit.
--}}

@extends('layouts.app')
@section('title', 'Daftar Harga Layanan')
@section('page-title', 'Daftar Harga Layanan')

@section('header-actions')
{{-- Tombol tambah layanan baru --}}
<a href="{{ route('admin.services.create') }}"
    class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
    <i data-lucide="plus" class="w-4 h-4"></i>
    Tambah Layanan
</a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ── Info Banner ─────────────────────────────────────────────── --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl px-5 py-4 flex items-start gap-3">
        <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5"></i>
        <div class="text-sm text-blue-700">
            <p class="font-semibold">Perubahan harga berlaku untuk order baru saja.</p>
            <p class="text-blue-500 mt-0.5">Order yang sudah masuk tetap menggunakan harga snapshot saat order dibuat, tidak terpengaruh perubahan ini.</p>
        </div>
    </div>

    {{-- ── Tabel Layanan ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- Header tabel --}}
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-800">Semua Layanan</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ $services->count() }} layanan terdaftar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Layanan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga / kg</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Estimasi</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Order</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Revenue</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">

                    @forelse($services as $service)
                    <tr class="hover:bg-gray-50 transition-colors group" id="row-{{ $service->id }}">

                        {{-- Nama & Deskripsi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Icon layanan --}}
                                @php
                                // ── MAP KONVERSI ICON MATERIAL DESIGN (DATABASE) KE LUCIDE ICON ──
                                $iconMap = [
                                'schedule' => 'clock',
                                'water_drop' => 'droplet',
                                'dry_cleaning' => 'shirt', // Menggunakan 'shirt' sebagai fallback aman
                                'local_laundry_service' => 'washing-machine',
                                'iron' => 'iron',
                                'flash_on' => 'zap',
                                ];

                                // Ambil nama ikon dari database
                                $dbIcon = $service->icon ?? 'shirt';

                                // Konversi ke format Lucide
                                $serviceIcon = $iconMap[$dbIcon] ?? str_replace('_', '-', $dbIcon);
                                @endphp

                                <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center
                    {{ $service->is_active ? 'bg-blue-50' : 'bg-gray-100' }}">
                                    {{-- Menggunakan variabel $serviceIcon yang sudah dikonversi --}}
                                    <i data-lucide="{{ $serviceIcon }}"
                                        class="w-5 h-5 {{ $service->is_active ? 'text-blue-500' : 'text-gray-400' }}"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 {{ !$service->is_active ? 'line-through text-gray-400' : '' }}">
                                        {{ $service->name }}
                                    </p>
                                    @if($service->description)
                                    <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $service->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Harga —— ini yang sebelumnya hardcoded --}}
                        <td class="px-4 py-4">
                            <p class="font-extrabold text-blue-600 text-base">
                                Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-400">per kilogram</p>
                        </td>

                        {{-- Estimasi hari --}}
                        <td class="px-4 py-4">
                            <span class="text-gray-700 font-medium">
                                {{ $service->estimated_days == 0 ? '⚡ 6 Jam' : $service->estimated_days . ' Hari' }}
                            </span>
                        </td>

                        {{-- Jumlah order --}}
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-700">{{ number_format($service->orders_count) }}</p>
                            <p class="text-xs text-gray-400">order</p>
                        </td>

                        {{-- Revenue historis --}}
                        <td class="px-4 py-4">
                            @php $revenue = $revenuePerService[$service->id] ?? 0; @endphp
                            <p class="font-semibold text-gray-700">
                                Rp {{ number_format($revenue, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-400">total selesai</p>
                        </td>

                        {{-- Toggle Aktif / Nonaktif (AJAX) --}}
                        <td class="px-4 py-4">
                            <button onclick="toggleService({{ $service->id }})"
                                id="toggle-{{ $service->id }}"
                                class="flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-full font-semibold transition-all
                                           {{ $service->is_active
                                              ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                              : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                <span class="w-2 h-2 rounded-full {{ $service->is_active ? 'bg-green-500' : 'bg-gray-400' }}"
                                    id="dot-{{ $service->id }}"></span>
                                <span id="label-{{ $service->id }}">
                                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </button>
                        </td>

                        {{-- Aksi: Edit & Hapus --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">

                                {{-- Edit --}}
                                <a href="{{ route('admin.services.edit', $service) }}"
                                    class="flex items-center gap-1.5 text-xs bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1.5 rounded-lg font-medium transition-colors">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                    onsubmit="return confirmDelete('{{ $service->name }}', {{ $service->orders_count }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-1.5 text-xs bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg font-medium transition-colors">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="package-open" class="w-8 h-8 text-gray-300"></i>
                            </div>
                            <p class="font-semibold text-gray-500">Belum ada layanan</p>
                            <p class="text-sm text-gray-400 mt-1">Tambahkan layanan pertama kamu.</p>
                            <a href="{{ route('admin.services.create') }}"
                                class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700">
                                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer: catatan harga jemput --}}
        @if($services->count() > 0)
        <div class="border-t border-gray-50 px-6 py-3 bg-gray-50">
            <p class="text-xs text-gray-400">
                💡 Semua harga di atas belum termasuk <strong>biaya jemput Rp 1.000</strong>
                yang otomatis ditambahkan jika customer memilih layanan jemput.
            </p>
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    /**
     * Toggle aktif/nonaktif layanan via AJAX
     * Tidak perlu reload halaman — tombol langsung berubah warnanya
     */
    async function toggleService(id) {
        const btn = document.getElementById('toggle-' + id);
        const dot = document.getElementById('dot-' + id);
        const label = document.getElementById('label-' + id);

        btn.disabled = true;
        btn.style.opacity = '0.6';

        try {
            const res = await fetch(`/admin/services/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();

            if (data.success) {
                const active = data.is_active;

                // Update tampilan tombol
                btn.className = `flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-full font-semibold transition-all
                ${active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'}`;
                dot.className = `w-2 h-2 rounded-full ${active ? 'bg-green-500' : 'bg-gray-400'}`;
                label.textContent = active ? 'Aktif' : 'Nonaktif';

                // Update tampilan icon di row (icon meredup jika nonaktif)
                const iconDiv = btn.closest('tr').querySelector('.rounded-xl');
                iconDiv.className = iconDiv.className.replace(/bg-(blue|gray)-\d+/, active ? 'bg-blue-50' : 'bg-gray-100');

                showToast(data.message, active ? 'success' : 'warning');
            }
        } catch (e) {
            showToast('Gagal memperbarui status. Coba lagi.', 'error');
        } finally {
            btn.disabled = false;
            btn.style.opacity = '1';
        }
    }

    /**
     * Konfirmasi sebelum hapus layanan
     */
    function confirmDelete(name, orderCount) {
        if (orderCount > 0) {
            return confirm(
                `Layanan "${name}" memiliki ${orderCount} order.\n\n` +
                `Layanan ini tidak akan dihapus permanen, tapi akan dinonaktifkan.\n\n` +
                `Lanjutkan?`
            );
        }
        return confirm(`Hapus layanan "${name}"? Tindakan ini tidak bisa dibatalkan.`);
    }

    /**
     * Toast notification mini
     */
    function showToast(msg, type = 'success') {
        const colors = {
            success: 'bg-green-600',
            warning: 'bg-amber-500',
            error: 'bg-red-600',
        };
        const t = document.createElement('div');
        t.className = `fixed bottom-6 right-6 z-50 ${colors[type]} text-white text-sm font-medium px-5 py-3 rounded-2xl shadow-xl`;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transition = 'opacity .3s';
            setTimeout(() => t.remove(), 300);
        }, 3500);
    }
</script>
@endpush
@endsection