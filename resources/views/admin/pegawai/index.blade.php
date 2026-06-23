@extends('layouts.app')
@section('title', 'Manajemen Pegawai')
@section('page-title', 'Manajemen Pegawai')

@section('content')
<div class="space-y-5">

    {{-- Header Menu CRUD: Tombol Tambah Pegawai --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <h3 class="font-bold text-gray-800 text-base">Daftar Pegawai Toko</h3>
            <p class="text-xs text-gray-400">Kelola kurir, kasir, dan staff outlet laundry Anda</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}" 
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            <span>Tambah Pegawai Baru</span>
        </a>
    </div>

    {{-- Role filter tabs --}}
    <div class="flex gap-2 flex-wrap">
        @foreach(['all'=>'Semua','admin'=>'Admin','kasir'=>'Kasir','kurir'=>'Kurir'] as $key=>$label)
        <a href="{{ route('admin.pegawai.index', ['role'=>$key]) }}"
           class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-colors
                  {{ ($role ?? 'all') === $key ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">User / Pegawai</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kontak</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Bergabung</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase w-44">Aksi CRUD</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse(($pegawai ?? $users) as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-700 font-bold text-sm">{{ strtoupper(substr($user->name,0,1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                    @if($user->laundry)
                                    <span class="inline-block text-[10px] bg-amber-50 text-amber-700 font-medium px-1.5 py-0.5 rounded mt-0.5 border border-amber-200">
                                        🏪 {{ $user->laundry->name }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-gray-600 font-mono text-xs">{{ $user->phone ?? '—' }}</p>
                            @if($user->address)
                            <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ $user->address }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $roleColors = ['admin'=>'bg-purple-100 text-purple-700','kasir'=>'bg-blue-100 text-blue-700','kurir'=>'bg-gray-100 text-gray-600','courier'=>'bg-gray-100 text-gray-600'];
                            @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium capitalize {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $user->role === 'courier' ? 'kurir' : $user->role }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @if($user->is_active)
                            <span class="flex items-center gap-1.5 text-xs text-green-600 font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> Aktif
                            </span>
                            @else
                            <span class="flex items-center gap-1.5 text-xs text-red-500 font-medium">
                                <span class="w-2 h-2 rounded-full bg-red-400"></span> Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-gray-400 text-xs">
                            {{ $user->created_at ? $user->created_at->isoFormat('D MMM Y') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                @if($user->id !== auth()->id())
                                    {{-- Tombol Toggle Status ON/OFF --}}
                                    <form method="POST" action="{{ route('admin.pegawai.toggle', $user) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                                                class="text-xs px-2 py-1.5 rounded-lg font-medium transition-colors
                                                       {{ $user->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                            <span class="material-symbols-outlined text-[16px] block">{{ $user->is_active ? 'block' : 'check_circle' }}</span>
                                        </button>
                                    </form>

                                    {{-- 🔄 PERUBAHAN: Tombol Edit Menggunakan Popup Modal Dinamis --}}
                                    <button type="button" 
                                       title="Edit Data Pegawai"
                                       onclick="openEditModal({{ json_encode([
                                           'id' => $user->id,
                                           'name' => $user->name,
                                           'email' => $user->email,
                                           'phone' => $user->phone,
                                           'address' => $user->address ?? '',
                                           'role' => $user->role,
                                           'is_active' => $user->is_active ? 1 : 0
                                       ]) }})"
                                       class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1.5 rounded-lg font-medium transition-colors">
                                        <span class="material-symbols-outlined text-[16px] block">edit</span>
                                    </button>

                                    {{-- Tombol Hapus CRUD --}}
                                    <form method="POST" action="{{ route('admin.pegawai.destroy', $user) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                title="Hapus Permanen"
                                                class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1.5 rounded-lg font-medium transition-colors">
                                            <span class="material-symbols-outlined text-[16px] block">delete</span>
                                        </button>
                                    </form>
                                @else
                                <span class="text-xs text-gray-300 italic">Akun Kamu</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <span class="material-symbols-outlined text-[40px] block opacity-30 mb-2">group</span>
                            Tidak ada pegawai ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $users->links() }}</div>
        @elseif(isset($pegawai) && method_exists($pegawai, 'hasPages') && $pegawai->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $pegawai->links() }}</div>
        @endif
    </div>
</div>

{{-- ── 🎯 COMPONENTS TAMBAHAN: POPUP MODAL EDIT PEGAWAI ── --}}
<div id="editPegawaiModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-2xl transform transition-all scale-95 duration-300 overflow-hidden">
        
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center gap-2 text-gray-800">
                <span class="material-symbols-outlined text-blue-600">edit_square</span>
                <h3 class="font-bold text-sm sm:text-base">Edit Data Kredensial Pegawai</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        {{-- Form Edit --}}
        <form id="editPegawaiForm" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="p-5 space-y-4 max-h-[70vh] overflow-y-auto text-xs sm:text-sm">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-600 block">Nama Lengkap</label>
                        <input type="text" name="name" id="modal_name" required
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>

                    {{-- Nomor HP --}}
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-600 block">Nomor HP / WhatsApp</label>
                        <input type="text" name="phone" id="modal_phone" required
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1 sm:col-span-2">
                        <label class="font-semibold text-gray-600 block">Alamat Email</label>
                        <input type="email" name="email" id="modal_email" required
                               class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                        <p class="text-[10px] text-gray-400 mt-0.5">Catatan: Alamat email tidak dapat diubah demi validitas log audit data.</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="space-y-1 sm:col-span-2">
                        <label class="font-semibold text-gray-600 block">Alamat Tempat Tinggal</label>
                        <textarea name="address" id="modal_address" rows="2"
                                  class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"></textarea>
                    </div>

                    {{-- Jabatan --}}
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-600 block">Jabatan / Role</label>
                        <select name="role" id="modal_role" required
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500">
                            <option value="kasir">Kasir</option>
                            <option value="kurir">Kurir</option>
                        </select>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-600 block">Status Akun</label>
                        <select name="is_active" id="modal_is_active" required
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    {{-- Password Baru --}}
                    <div class="space-y-1 sm:col-span-2 bg-blue-50/50 p-3 rounded-xl border border-blue-100/50 mt-1">
                        <label class="font-semibold text-gray-700 block text-xs">Ganti Password Baru (Opsional)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1.5">
                            <input type="password" name="password" placeholder="Isi jika ingin ganti password"
                                   class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-blue-500">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                                   class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-blue-500">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Kosongkan kedua kolom di atas jika pegawai tidak ingin memperbarui kata sandi lama mereka.</p>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-200 bg-white text-gray-700 font-semibold rounded-xl text-xs hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl text-xs hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── 📜 SCRIPT JAVASCRIPT LOGIC POPUP ── --}}
<script>
    function openEditModal(user) {
        const modal = document.getElementById('editPegawaiModal');
        const form = document.getElementById('editPegawaiForm');
        
        // 1. Set URL Form Action Eloquent Update secara dinamis
        form.action = `/admin/pegawai/${user.id}`;
        
        // 2. Inject value data pegawai ke dalam form field modal
        document.getElementById('modal_name').value = user.name;
        document.getElementById('modal_phone').value = user.phone;
        document.getElementById('modal_email').value = user.email;
        document.getElementById('modal_address').value = user.address;
        document.getElementById('modal_role').value = user.role;
        document.getElementById('modal_is_active').value = user.is_active;
        
        // 3. Tampilkan modal dengan mengubah kelas display dari hidden ke flex
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editPegawaiModal');
        
        // Sembunyikan kembali komponen modal
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        
        // Reset password fields saat modal ditutup agar aman
        document.getElementById('editPegawaiForm').reset();
    }
</script>
@endsection