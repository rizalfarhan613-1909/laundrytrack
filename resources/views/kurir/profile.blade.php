@extends('layouts.app')
@section('title', 'Profil Kurir')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-lg mx-auto space-y-5">

    {{-- Avatar + nama --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
        <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center mx-auto mb-3 text-blue-700 font-extrabold text-3xl">
            {{ strtoupper(substr($kurir->name, 0, 1)) }}
        </div>
        <p class="font-extrabold text-gray-800 text-xl">{{ $kurir->name }}</p>
        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold mt-1 inline-block">
            Kurir
        </span>
        <p class="text-sm text-gray-400 mt-2">{{ $kurir->email }}</p>
    </div>

    {{-- Form edit profil --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2">
                <i data-lucide="edit" class="w-4 h-4 text-blue-500"></i>
                Edit Data Profil
            </h3>
        </div>
        <form method="POST" action="{{ route('kurir.profile.update') }}" class="p-6 space-y-4">
            @csrf @method('PATCH')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $kurir->name) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                              {{ $errors->has('name') ? 'border-red-400 bg-red-50' : '' }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nomor HP / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="tel" name="phone" value="{{ old('phone', $kurir->phone) }}" required
                       placeholder="081234567890"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                              {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : '' }}">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">
                    Dipakai untuk menerima notifikasi WhatsApp saat ada tugas baru.
                </p>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Info akun --}}
    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5 text-sm text-gray-500 space-y-1">
        <p>📧 Email: {{ $kurir->email }}</p>
        <p>🗓️ Bergabung: {{ $kurir->created_at->isoFormat('D MMMM Y') }}</p>
        <p class="text-xs text-gray-400 mt-2">Untuk mengubah email atau password, hubungi admin.</p>
    </div>
</div>
@endsection