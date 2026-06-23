@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Template Layanan Global') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola standar master layanan yang dapat disalin oleh mitra toko.</p>
            </div>
            
            <div x-data="{ openAdd: false }">
                <button @click="openAdd = true" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    Tambah Template
                </button>

                <div x-show="openAdd" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div @click="openAdd = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        
                        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" action="{{ route('ceo.templates.store') }}" class="p-6">
                                @csrf
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Tambah Template Layanan Baru</h2>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Layanan</label>
                                        <input type="text" name="name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cth: Cuci + Setrika" required />
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Satuan (Kg/Pcs/Mtr)</label>
                                            <input type="text" name="unit" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cth: Kg" required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Harga Dasar (Rp)</label>
                                            <input type="number" name="base_price" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cth: 6000" required />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                        <textarea name="description" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm sm:text-sm" placeholder="Detail layanan..."></textarea>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="openAdd = false" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                                    <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700">Simpan Template</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold rounded-tl-xl">Nama Layanan</th>
                                <th class="px-6 py-4 font-semibold">Satuan</th>
                                <th class="px-6 py-4 font-semibold">Harga Dasar</th>
                                <th class="px-6 py-4 font-semibold">Deskripsi</th>
                                <th class="px-6 py-4 font-semibold text-right rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($templates as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-md text-xs font-medium">{{ $item->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4">Rp {{ number_format($item->base_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 max-w-xs truncate" title="{{ $item->description }}">{{ $item->description ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                                        
                                        <div x-data="{ openEdit: false }">
                                            <button @click="openEdit = true" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            
                                            <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto text-left" style="display: none;">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div @click="openEdit = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                    
                                                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                        <form method="POST" action="{{ route('ceo.templates.update', $item->id) }}" class="p-6">
                                                            @csrf
                                                            @method('PUT')
                                                            <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Template Layanan</h2>

                                                            <div class="space-y-4">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700">Nama Layanan</label>
                                                                    <input type="text" name="name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $item->name }}" required />
                                                                </div>
                                                                <div class="grid grid-cols-2 gap-4">
                                                                    <div>
                                                                        <label class="block text-sm font-medium text-gray-700">Satuan (Kg/Pcs/Mtr)</label>
                                                                        <input type="text" name="unit" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $item->unit }}" required />
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-sm font-medium text-gray-700">Harga Dasar (Rp)</label>
                                                                        <input type="number" name="base_price" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $item->base_price }}" required />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                                                    <textarea name="description" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm sm:text-sm">{{ $item->description }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="mt-6 flex justify-end gap-3">
                                                                <button type="button" @click="openEdit = false" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                                                                <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <form action="{{ route('ceo.templates.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus template layanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-symbols-outlined text-[40px] text-gray-300 mb-2">inventory_2</span>
                                            <p>Belum ada template layanan global.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection