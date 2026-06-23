@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8" x-data="{ openCreateModal: false, openEditModal: false, editPlan: {} }">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                💳 Paket Langganan SaaS
            </h1>
            <p class="text-sm text-gray-500 mt-1">Atur skema harga bulanan dan persentase potongan bagi hasil (komisi) mitra laundry.</p>
        </div>
        <button @click="openCreateModal = true" 
                class="flex items-center gap-2 px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold text-sm shadow-md transition-all active:scale-95">
            <span class="material-symbols-outlined text-[20px]">add_card</span>
            Tambah Paket Baru
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4">Nama Paket</th>
                        <th class="px-6 py-4">Biaya Bulanan (SaaS)</th>
                        <th class="px-6 py-4">Potongan Komisi / Transaksi</th>
                        <th class="px-6 py-4 text-center">Jumlah Pengguna Tenant</th>
                        <th class="px-6 py-4 text-center">Aksi Pemeliharaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                    @forelse($plans as $plan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 text-base">{{ $plan->name }}</div>
                                <span class="text-xs text-gray-400">ID Paket: #{{ $plan->id }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700">
                                @if($plan->monthly_price == 0)
                                    <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-full text-xs font-bold">Rp 0 (Gratis)</span>
                                @else
                                    Rp {{ number_format($plan->monthly_price, 0, ',', '.') }} <span class="text-xs text-gray-400">/bln</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-blue-600">
                                {{ number_format($plan->fee_percentage, 2, ',', '.') }}%
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-gray-100 rounded-full font-bold text-gray-700 text-xs">
                                    {{ $plan->laundries_count }} Outlet
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <button @click="editPlan = { id: '{{ $plan->id }}', name: '{{ $plan->name }}', monthly_price: '{{ $plan->monthly_price }}', fee_percentage: '{{ $plan->fee_percentage }}' }; openEditModal = true" 
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors flex items-center justify-center" title="Ubah Data Paket">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>

                                    <form action="{{ route('ceo.plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus paket ini? Pilihan tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center" title="Hapus Paket">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-sm text-gray-400">
                                <span class="material-symbols-outlined text-[48px] text-gray-300 block mb-2">subtitles_off</span>
                                Belum ada skema paket langganan yang didaftarkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-xs" 
         x-show="openCreateModal" x-transition x-cloak>
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="openCreateModal = false">
            <div class="px-6 py-4 bg-blue-500 text-white flex justify-between items-center">
                <h3 class="font-bold text-lg flex items-center gap-2"><span class="material-symbols-outlined">add_card</span> Tambah Paket Baru</h3>
                <button @click="openCreateModal = false" class="text-white hover:opacity-70"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="{{ route('ceo.plans.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Paket</label>
                    <input type="text" name="name" required placeholder="Contoh: Skema Gratis (Komisi 8%)" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Biaya Bulanan Tetap (Rp)</label>
                    <input type="number" name="monthly_price" required min="0" placeholder="0 untuk paket berbasis komisi" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Persentase Potongan Komisi (%)</label>
                    <input type="number" step="0.01" name="fee_percentage" required min="0" max="100" placeholder="Contoh: 8.00" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2 border border-gray-200 text-gray-500 font-semibold rounded-xl text-sm hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl text-sm shadow-md">Simpan Paket</button>
                </div>
            </form>
        </div>
    </div>

    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-xs" 
         x-show="openEditModal" x-transition x-cloak>
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden" @click.away="openEditModal = false">
            <div class="px-6 py-4 bg-amber-500 text-white flex justify-between items-center">
                <h3 class="font-bold text-lg flex items-center gap-2"><span class="material-symbols-outlined">edit_note</span> Ubah Skema Paket</h3>
                <button @click="openEditModal = false" class="text-white hover:opacity-70"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="'/ceo/plans/' + editPlan.id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Paket</label>
                    <input type="text" name="name" x-model="editPlan.name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Biaya Bulanan Tetap (Rp)</label>
                    <input type="number" name="monthly_price" x-model="editPlan.monthly_price" required min="0" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Persentase Potongan Komisi (%)</label>
                    <input type="number" step="0.01" name="fee_percentage" x-model="editPlan.fee_percentage" required min="0" max="100" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 text-sm">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 border border-gray-200 text-gray-500 font-semibold rounded-xl text-sm hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl text-sm shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection