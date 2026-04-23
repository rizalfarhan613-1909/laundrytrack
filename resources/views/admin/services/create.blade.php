{{--
    resources/views/admin/services/create.blade.php
    ────────────────────────────────────────────────
    Halaman tambah layanan baru.
    Menggunakan partial _form.blade.php agar tidak duplikasi kode.
--}}

@extends('layouts.app')
@section('title', 'Tambah Layanan Baru')
@section('page-title', 'Tambah Layanan Baru')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.services.index') }}" class="hover:text-blue-600 transition-colors">
            Daftar Layanan
        </a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-gray-600 font-medium">Tambah Baru</span>
    </div>

    {{--
        @include untuk menyisipkan _form.blade.php
        Kirimkan variabel yang dibutuhkan partial:
          $action  → URL tujuan POST (route store)
          $method  → 'POST' untuk create
          $service → object kosong (sudah dikirim dari controller)
          $icons   → array icon (sudah dikirim dari controller)
    --}}
    @include('admin.services._form', [
        'action' => route('admin.services.store'),
        'method' => 'POST',
    ])

</div>
@endsection