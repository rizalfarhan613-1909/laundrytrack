@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('page-title', 'Tambah Pegawai')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header Form --}}
    <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pegawai.index') }}" 
               class="w-9 h-9 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-xl flex items-center justify-center transition-colors shadow-sm"
               title="Kembali ke Daftar Pegawai">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div>
                <h3 class="font-bold text-gray-800 text-base">Tambah Pegawai Baru</h3>
                <p class="text-xs text-gray-400">Pendaftaran akun internal staff untuk outlet laundry Anda</p>
            </div>
        </div>
    </div>

    {{-- Form Utama --}}
    <form method="POST" action="{{ route('admin.pegawai.store') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @csrf

        <div class="p-6 space-y-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 border-b border-gray-50 pb-2">📋 Informasi Pribadi & Kontak</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-semibold text-gray-600">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" 
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('name') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                           placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Handphone --}}
                <div class="space-y-1.5">
                    <label for="phone" class="text-xs font-semibold text-gray-600">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" 
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('phone') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                           placeholder="Contoh: 08123456789" value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label for="email" class="text-xs font-semibold text-gray-600">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" 
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('email') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                           placeholder="Contoh: staff@laundrytrack.com" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Tinggal --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label for="address" class="text-xs font-semibold text-gray-600">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3"
                              class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('address') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                              placeholder="Masukkan alamat domisili pegawai...">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 border-b border-gray-50 pt-2 pb-2">🔑 Hak Akses & Kredensial</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Role Jabatan --}}
                <div class="space-y-1.5">
                    <label for="role" class="text-xs font-semibold text-gray-600">Role / Jabatan Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="role" id="role" 
                            class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('role') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Jabatan --</option>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="kurir" {{ old('role') == 'kurir' ? 'selected' : '' }}>Kurir / Delivery</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Akun --}}
                <div class="space-y-1.5">
                    <label for="is_active" class="text-xs font-semibold text-gray-600">Status Aktivasi Pegawai <span class="text-red-500">*</span></label>
                    <select name="is_active" id="is_active" 
                            class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Bisa Langsung Login)</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif (Ditangguhkan)</option>
                    </select>
                </div>

                {{-- Password Akses --}}
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-semibold text-gray-600">Password Akun <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" 
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow @error('password') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                           placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-semibold text-gray-600">Konfirmasi Ulang Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-100 transition-shadow"
                           placeholder="Ketik ulang password" required>
                </div>
            </div>
        </div>

        {{-- Footer Form / Aksi Tombol --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.pegawai.index') }}" 
               class="px-4 py-2.5 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-semibold text-xs transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-xs transition-colors shadow-sm inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Simpan Pegawai</span>
            </button>
        </div>
    </form>
</div>
@endsection