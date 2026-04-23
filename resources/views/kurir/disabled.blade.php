@extends('layouts.app')
@section('title', 'Layanan Kurir')
@section('page-title', 'Layanan Kurir')

@section('content')
<div class="max-w-md mx-auto text-center py-20">
    <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
        <i data-lucide="truck-off" class="w-10 h-10 text-gray-300"></i>
    </div>
    <h2 class="text-xl font-bold text-gray-700 mb-2">Layanan Kurir Sedang Nonaktif</h2>
    <p class="text-gray-400 text-sm">Admin telah menonaktifkan layanan jemput antar sementara. Silakan cek kembali nanti.</p>
    <p class="text-gray-300 text-xs mt-4">Jika ada pertanyaan, hubungi admin.</p>
</div>
@endsection