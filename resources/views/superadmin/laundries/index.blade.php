@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Tenant Toko</h1>
            <p class="text-sm text-gray-500">Pantau, verifikasi, aktifkan, atau batasi akses operasional mitra laundry SaaS.</p>
        </div>
        <div>
            <a href="{{ route('ceo.laundries.create') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Tenant Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form action="{{ route('ceo.laundries.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama laundry atau nomor telepon..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
                Filter Data
            </button>
            @if($search)
                <a href="{{ route('ceo  .laundries.index') }}" class="border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Detail Outlet</th>
                        <!-- <th class="px-6 py-4">Informasi Owner</th> -->
                        <th class="px-6 py-4">Paket Sistem</th>
                        <th class="px-6 py-4">Status Akses</th>
                        <th class="px-6 py-4 text-center">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                    @forelse($laundries as $laundry)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 overflow-hidden border border-gray-100">
                                    @if($laundry->image)
                                        <img src="{{ asset('storage/' . $laundry->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="store" class="w-5 h-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $laundry->name }}</div>
                                    <div class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i> {{ Str::limit($laundry->address, 30) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <!-- <td class="px-6 py-4">
                            @php $owner = $laundry->users->first(); @endphp
                            @if($owner)
                                <div class="font-medium text-gray-800">{{ $owner->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $laundry->phone }}</div>
                            @else
                                <span class="text-xs text-red-400 italic">Belum ada owner</span>
                            @endif
                        </td> -->
                        <td class="px-6 py-4">
                            <span class="inline-flex flex-col">
                                <span class="font-semibold text-gray-800 text-xs bg-purple-50 text-purple-600 px-2.5 py-1 rounded-md border border-purple-100 w-fit">
                                    {{ $laundry->subscriptionPlan->name ?? ucfirst($laundry->subscription_type) }}
                                </span>
                                <span class="text-[11px] text-gray-400 mt-1">Sisa Fee: Rp {{ number_format($laundry->unpaid_commission, 0, ',', '.') }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($laundry->is_active)
                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium border border-red-100">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Diblokir
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('ceo.laundries.updatePlan', $laundry->id) }}" method="POST" class="inline-flex items-center gap-1 bg-white border border-gray-200 hover:bg-gray-50 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                    @csrf @method('PUT')
                                    <select name="subscription_plan_id" onchange="this.form.submit()" class="bg-transparent outline-none cursor-pointer text-gray-600 font-medium">
                                        <option value="">-- Ganti Paket --</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ $laundry->subscription_plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </form>

                                <form action="{{ route('ceo.laundries.toggleStatus', $laundry->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    @if($laundry->is_active)
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Blokir Toko">
                                            <i data-lucide="ban" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-600 p-2 rounded-lg transition-colors" title="Aktifkan Toko">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            <i data-lucide="folder-open" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                            Tidak ada tenant toko laundry yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laundries->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $laundries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection