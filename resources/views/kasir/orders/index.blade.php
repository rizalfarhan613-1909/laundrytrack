@extends('layouts.app')
@section('title', 'Kelola Order')
@section('page-title', 'Kelola Order')

@section('content')
<div class="space-y-5">

    {{-- ── Stats Bar ───────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
        $statCards = [
            ['label'=>'Pending',   'value'=>$stats['pending'],    'color'=>'amber',  'icon'=>'clock'],
            ['label'=>'Diproses',  'value'=>$stats['in_process'], 'color'=>'purple', 'icon'=>'loader'],
            ['label'=>'Siap',      'value'=>$stats['ready'],      'color'=>'green',  'icon'=>'check-circle'],
            ['label'=>'Revenue Hari Ini','value'=>'Rp '.number_format($stats['today_revenue'],0,',','.'), 'color'=>'blue','icon'=>'banknote'],
        ];
        $statColor = ['amber'=>'bg-amber-50 text-amber-700','purple'=>'bg-purple-50 text-purple-700','green'=>'bg-green-50 text-green-700','blue'=>'bg-blue-50 text-blue-700'];
        @endphp
        @foreach($statCards as $s)
        <div class="bg-white rounded-xl border border-gray-100 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg {{ $statColor[$s['color']] }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="{{ $s['icon'] }}" class="w-4 h-4"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">{{ $s['label'] }}</p>
                <p class="font-bold text-gray-800 text-sm">{{ $s['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filter & Search ─────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
            <div class="flex gap-2 flex-wrap">
                @foreach(['all'=>'Semua','pending'=>'Pending','in_process'=>'Diproses','ready'=>'Siap','finished'=>'Selesai'] as $key=>$label)
                <a href="{{ route('kasir.dashboard', ['status'=>$key, 'search'=>$search]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                          {{ $status === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('kasir.dashboard') }}" class="flex gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari kode / nama customer..."
                           class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 w-56">
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700">Cari</button>
            </form>
        </div>

        {{-- ── Table ───────────────────────────────────────────── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Order</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Customer</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Layanan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Berat / Total</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Bayar</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    @php $badge = $order->getStatusBadge(); @endphp
                    <tr class="hover:bg-gray-50 transition-colors group" x-data="{ weightEdit: false }">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-bold text-gray-800 font-mono text-xs">{{ $order->order_code }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                @if($order->pickup_type === 'jemput')
                                <span class="text-xs text-blue-500 flex items-center gap-1">
                                    <i data-lucide="truck" class="w-3 h-3"></i> Jemput
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <p class="font-medium text-gray-700">{{ $order->customer->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->customer->phone }}</p>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-gray-700">{{ $order->service->name }}</p>
                            <p class="text-xs text-gray-400">Rp {{ number_format($order->price_per_kg,0,',','.') }}/kg</p>
                            
                            {{-- Indikator Badge Layanan Halal & Status Najis --}}
                            @if(isset($order->is_halal_service) && $order->is_halal_service)
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="inline-flex items-center gap-0.5 text-[10px] bg-green-50 text-green-700 px-1.5 py-0.5 rounded font-semibold border border-green-200">
                                    ✨ Syariah Halal
                                </span>
                                @if($order->has_najis)
                                <span class="inline-flex items-center gap-0.5 text-[10px] bg-red-50 text-red-700 px-1.5 py-0.5 rounded font-semibold border border-red-200">
                                    ⚠️ Ada Najis
                                </span>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if($order->weight_kg)
                                <p class="font-semibold text-gray-800">{{ $order->weight_kg }} kg</p>
                                <p class="text-xs text-blue-600 font-bold">Rp {{ number_format($order->total_price,0,',','.') }}</p>
                            @else
                                {{-- Edit Weight Form --}}
                                <div x-show="!weightEdit">
                                    <span class="text-xs text-amber-500 italic">Belum ditimbang</span>
                                    <button @click="weightEdit=true" class="block text-xs text-blue-500 hover:underline mt-0.5">
                                        + Input berat
                                    </button>
                                </div>
                                <div x-show="weightEdit" x-transition class="flex items-center gap-1">
                                    <input type="number" step="0.1" min="0.1" id="w-{{ $order->id }}"
                                           placeholder="0.0"
                                           class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="text-xs text-gray-400">kg</span>
                                    <button onclick="saveWeight({{ $order->id }}, '{{ route('kasir.orders.weight', $order) }}')"
                                             class="text-xs bg-blue-600 text-white px-2 py-1 rounded-lg hover:bg-blue-700">✓</button>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <span class="status-{{ $order->status }} text-xs px-2.5 py-1 rounded-full font-medium block w-max">
                                {{ $badge['label'] }}
                            </span>

                            {{-- Keterangan Alur Pembersihan (Thaharah) --}}
                            @if(isset($order->is_halal_service) && $order->is_halal_service)
                            <div class="mt-1.5">
                                @if($order->halal_status === 'pending_thaharah')
                                    <span class="text-[11px] bg-amber-50 text-amber-700 border border-amber-200 px-1.5 py-0.5 rounded font-medium flex items-center gap-1 w-max">
                                        ⏳ Menunggu Thaharah
                                    </span>
                                @elif($order->halal_status === 'thaharah_completed')
                                    <span class="text-[11px] bg-blue-50 text-blue-700 border border-blue-200 px-1.5 py-0.5 rounded font-medium flex items-center gap-1 w-max">
                                        🧼 Selesai Thaharah
                                    </span>
                                @elif($order->halal_status === 'main_wash')
                                    <span class="text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-1.5 py-0.5 rounded font-medium flex items-center gap-1 w-max">
                                        🧺 Di Mesin Cuci Halal
                                    </span>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if($order->payment)
                                @php $pay = $order->payment; @endphp
                                <div>
                                    <span class="text-xs font-medium {{ $pay->isVerified() ? 'text-green-600' : ($pay->status === 'rejected' ? 'text-red-600' : 'text-amber-600') }}">
                                        {{ $pay->isVerified() ? '✓ Lunas' : ($pay->status === 'rejected' ? '✗ Ditolak' : '⏳ Menunggu') }}
                                    </span>
                                    <p class="text-xs text-gray-400">{{ strtoupper($pay->method) }}</p>
                                    @if($pay->isPending() && $pay->method !== 'cash')
                                    <form method="POST" action="{{ route('kasir.payments.verify', $pay) }}" class="mt-1">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="verify">
                                        <button class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded hover:bg-green-200">Verifikasi</button>
                                    </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Belum bayar</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-1.5 items-start">
                                {{-- Tombol Alur Khusus Workflow Laundry Halal --}}
                                @if(isset($order->is_halal_service) && $order->is_halal_service)
                                    @if($order->halal_status === 'pending_thaharah')
                                        <form method="POST" action="{{ route('kasir.orders.complete-thaharah', $order) }}">
                                            @csrf
                                            <button type="submit" class="text-xs bg-amber-600 text-white hover:bg-amber-700 px-2.5 py-1.5 rounded-lg font-medium transition-colors whitespace-nowrap flex items-center gap-1">
                                                <i data-lucide="droplet" class="w-3 h-3"></i> Selesai Bilas Najis
                                            </button>
                                        </form>
                                    @elif($order->halal_status === 'thaharah_completed')
                                        <form method="POST" action="{{ route('kasir.orders.start-main-wash', $order) }}">
                                            @csrf
                                            <button type="submit" class="text-xs bg-emerald-600 text-white hover:bg-emerald-700 px-2.5 py-1.5 rounded-lg font-medium transition-colors whitespace-nowrap flex items-center gap-1">
                                                <i data-lucide="play" class="w-3 h-3"></i> Masuk Mesin Halal
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Tombol Utama Maju Status --}}
                                @if($order->getNextStatus())
                                    {{-- Jika layanan halal & belum masuk mesin cuci utama, kunci tombol status utama agar wajib ikuti SOP halal terlebih dahulu --}}
                                    @if(isset($order->is_halal_service) && $order->is_halal_service && $order->halal_status !== 'main_wash' && $order->status === 'pending')
                                        <span class="text-[11px] text-gray-400 italic block">Selesaikan SOP Halal</span>
                                    @else
                                        <form method="POST" action="{{ route('kasir.orders.advance', $order) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="text-xs bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-1.5 rounded-lg font-medium transition-colors whitespace-nowrap">
                                                → Maju Status
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if(!isset($order->is_halal_service) || !$order->is_halal_service || $order->halal_status === 'main_wash')
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                            <p class="font-medium">Tidak ada order</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>


<script>
async function saveWeight(orderId, url) {
    const input = document.getElementById('w-' + orderId);
    const weight = parseFloat(input.value);
    if (!weight || weight <= 0) { alert('Masukkan berat yang valid!'); return; }

    try {
        const res = await fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ weight_kg: weight })
        });
        const data = await res.json();
        if (data.success) {
            window.location.reload();
        } else {
            alert('Gagal menyimpan berat.');
        }
    } catch(e) {
        alert('Error: ' + e.message);
    }
}
</script>

@endsection