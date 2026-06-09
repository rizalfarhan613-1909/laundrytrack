{{--
    resources/views/admin/services/edit.blade.php
    ──────────────────────────────────────────────
    Halaman ubah layanan yang sudah ada.
    Menggunakan partial _form.blade.php yang sama dengan create.
--}}

@extends('layouts.app')
@section('title', 'Edit Layanan: ' . $service->name)
@section('page-title', 'Edit Layanan')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.services.index') }}" class="hover:text-blue-600 transition-colors">
            Daftar Layanan
        </a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-gray-600 font-medium">Edit: {{ $service->name }}</span>
    </div>

    {{-- Info: berapa order memakai layanan ini --}}
    @if($service->orders_count > 0)
    <div class="bg-amber-50 border border-amber-100 rounded-2xl px-5 py-4 mb-5 flex items-start gap-3">
        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5"></i>
        <div class="text-sm">
            <p class="font-semibold text-amber-800">
                Layanan ini sudah dipakai di
                <strong>{{ number_format($service->orders_count) }} order</strong>.
            </p>
            <p class="text-amber-600 mt-0.5">
                Perubahan harga <strong>hanya berlaku untuk order baru</strong>.
                Order yang sudah masuk tidak berubah (menggunakan snapshot harga saat order dibuat).
            </p>
        </div>
    </div>
    @endif

    {{--
        @include form yang sama dengan create.
        Bedanya: method 'PUT' dan action ke route update.
        $service sudah terisi data dari database (dikirim controller).
    --}}
    @include('admin.services._form', [
        'action' => route('admin.services.update', $service),
        'method' => 'PUT',
    ])

    {{-- ── Zona Bahaya (Hapus) ──────────────────────────────────────── --}}
    <div class="mt-8 bg-red-50 border border-red-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100">
            <h3 class="font-bold text-red-700 text-sm flex items-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Zona Bahaya
            </h3>
        </div>
        <div class="p-5 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-red-700">Hapus Layanan Ini</p>
                <p class="text-xs text-red-400 mt-0.5">
                    @if($service->orders_count > 0)
                        Ada {{ $service->orders_count }} order historis — layanan akan dinonaktifkan, bukan dihapus permanen.
                    @else
                        Belum ada order. Layanan bisa dihapus permanen.
                    @endif
                </p>
            </div>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                  onsubmit="return confirm('{{ $service->orders_count > 0 ? 'Layanan akan dinonaktifkan (ada order historis). Lanjutkan?' : 'Hapus layanan ini secara permanen?' }}')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    {{ $service->orders_count > 0 ? 'Nonaktifkan' : 'Hapus Permanen' }}
                </button>
            </form>
        </div>
    </div>

</div>
@endsection