@extends('layouts.app')
@section('title', 'Inventaris')
@section('page-title', 'Manajemen Inventaris')

@section('header-actions')
<button onclick="document.getElementById('modal-add').classList.remove('hidden')"
        class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Item
</button>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Item</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Stok</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Harga/Unit</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($inventories as $item)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                    @if($item->notes)
                    <p class="text-xs text-gray-400">{{ $item->notes }}</p>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <span class="capitalize text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $item->category }}</span>
                </td>
                <td class="px-4 py-4">
                    <p class="font-bold {{ $item->isLow() ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $item->stock }} {{ $item->unit }}
                    </p>
                    <p class="text-xs text-gray-400">Min: {{ $item->min_stock }} {{ $item->unit }}</p>
                </td>
                <td class="px-4 py-4 text-gray-600">
                    Rp {{ number_format($item->price_per_unit,0,',','.') }}
                </td>
                <td class="px-4 py-4">
                    @if($item->isLow())
                    <span class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium flex items-center gap-1 w-fit">
                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> Menipis
                    </span>
                    @else
                    <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Aman</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div x-data="{open:false}" class="relative">
                        <button @click="open=!open" class="text-xs bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg hover:bg-blue-100">
                            Adjust Stok
                        </button>
                        <div x-show="open" @click.outside="open=false" x-transition
                             class="absolute right-0 top-8 z-20 bg-white border border-gray-200 rounded-xl shadow-lg p-4 w-52">
                            <form method="POST" action="{{ route('admin.inventory.adjust', $item) }}">
                                @csrf @method('PATCH')
                                <select name="type" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs mb-2">
                                    <option value="in">+ Masuk (Restock)</option>
                                    <option value="out">- Keluar (Pakai)</option>
                                </select>
                                <input type="number" name="quantity" step="0.1" min="0.01" placeholder="Jumlah"
                                       class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs mb-2">
                                <input type="text" name="description" placeholder="Keterangan (opsional)"
                                       class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs mb-2">
                                <button class="w-full bg-blue-600 text-white text-xs py-1.5 rounded-lg hover:bg-blue-700">Simpan</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                    <i data-lucide="package" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                    Belum ada item inventaris.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($inventories->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">{{ $inventories->links() }}</div>
    @endif
</div>

{{-- Add Item Modal --}}
<div id="modal-add" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Tambah Item Inventaris</h3>
            <button onclick="document.getElementById('modal-add').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.inventory.store') }}" class="p-6 space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label class="text-xs font-semibold text-gray-600">Nama Item</label>
                    <input type="text" name="name" required placeholder="Detergen, Parfum..."
                           class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600">Kategori</label>
                    <select name="category" class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="bahan">Bahan</option>
                        <option value="peralatan">Peralatan</option>
                        <option value="kemasan">Kemasan</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600">Satuan</label>
                    <select name="unit" class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="liter">Liter</option>
                        <option value="kg">Kg</option>
                        <option value="pcs">Pcs</option>
                        <option value="botol">Botol</option>
                        <option value="pak">Pak</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600">Stok Awal</label>
                    <input type="number" name="stock" step="0.1" min="0" value="0" required
                           class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600">Stok Minimum</label>
                    <input type="number" name="min_stock" step="0.1" min="0" value="1" required
                           class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <label class="text-xs font-semibold text-gray-600">Harga per Unit (Rp)</label>
                    <input type="number" name="price_per_unit" min="0" value="0"
                           class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-semibold text-sm hover:bg-blue-700 transition-colors mt-2">
                Tambah Item
            </button>
        </form>
    </div>
</div>
@endsection