@extends('layouts.app')
@section('title', 'Manajemen Pegawai')
@section('page-title', 'Manajemen Pegawai')

@section('content')
<div class="space-y-5">

    {{-- Role filter tabs --}}
    <div class="flex gap-2 flex-wrap">
        @foreach(['all'=>'Semua','admin'=>'Admin','kasir'=>'Kasir','kurir'=>'Kurir',] as $key=>$label)
        <a href="{{ route('admin.users.index', ['role'=>$key]) }}"
           class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-colors
                  {{ $role === $key ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kontak</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Bergabung</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-700 font-bold text-sm">{{ strtoupper(substr($user->name,0,1)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-gray-600">{{ $user->phone ?? '—' }}</p>
                        @if($user->address)
                        <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ $user->address }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @php
                        $roleColors = ['admin'=>'bg-purple-100 text-purple-700','kasir'=>'bg-blue-100 text-blue-700','kurir'=>'bg-gray-100 text-gray-600'];
                        @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium capitalize {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
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
                        {{ $user->created_at->isoFormat('D MMM Y') }}
                    </td>
                    <td class="px-4 py-4">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors
                                           {{ $user->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-gray-300">Akun Kamu</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                        <i data-lucide="users" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                        Tidak ada user ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection