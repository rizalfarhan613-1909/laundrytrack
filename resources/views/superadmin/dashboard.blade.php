@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                Dashboard Monitoring 
            </h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Pemantauan Performa Real-Time Ekosistem LaundryTrack Global.</p>
        </div>
        <div class="mt-4 md:mt-0 bg-white shadow-sm rounded-lg px-4 py-2 border border-gray-100 flex items-center gap-2 text-sm text-gray-600">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            Server Utama Aktif: {{ now()->format('d M Y H:i') }} WIB
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl shadow-md p-6 text-white relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-15 transform translate-x-4 translate-y-4">
                <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.554-.589 1.448-.589 2.002 0l.207.22 1.603-.94a2.44 2.44 0 00-2.662-.124V5a1 1 0 10-2 0v1.517a2.44 2.44 0 00-2.398 2.517c0 1.256.812 2.333 1.996 2.6L9 11.833V13a1 1 0 102 0v-1.167l1.15-.244c1.183-.267 1.996-1.343 1.996-2.6a2.44 2.44 0 00-2.398-2.517V6.311l-.207.22a.5.5 0 01-.714 0l-.207-.22z"></path></svg>
            </div>
            <p class="text-sm font-medium text-blue-100 uppercase tracking-wider">Pendapatan CEO (Komisi SaaS)</p>
            <h3 class="text-2xl font-bold mt-2 tracking-tight">Rp {{ number_format($totalCeoEarnings, 0, ',', '.') }}</h3>
            <p class="text-xs text-blue-200 mt-2 flex items-center gap-1">
                <span>⚡ Real-time potongan dari skema komisi aktif</span>
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 relative overflow-hidden">
            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Omset Global Ekosistem</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-2 tracking-tight">Rp {{ number_format($globalOmset, 0, ',', '.') }}</h3>
            <p class="text-xs text-blue-600 mt-2 font-medium flex items-center gap-1">
                <span>🌐 Akumulasi bruto dari seluruh transaksi masuk</span>
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Transaksi (Order)</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-2 tracking-tight">{{ number_format($totalTransactions, 0, ',', '.') }} Transaksi</h3>
            <p class="text-xs text-gray-500 mt-2">Beban sirkulasi nota dalam database</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Volume Pakaian Global</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-2 tracking-tight">{{ number_format($totalGlobalWeight, 1, ',', '.') }} Kg</h3>
            <p class="text-xs text-blue-600 mt-2 font-medium">Total berat pakaian yang diproses ekosistem</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pembanding Omset Top 5 Toko Laundry</h3>
            <div class="relative w-full h-64">
                <canvas id="chartTopLaundries"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Layanan Terlaris (Global)</h3>
            <div class="space-y-4">
                @forelse($topServices as $index => $service)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-sm font-semibold text-gray-700">{{ $service->name }}</span>
                        </div>
                        <span class="text-xs bg-blue-400 text-white font-medium px-2.5 py-1 rounded-full">
                            {{ $service->total_used }}x Digunakan
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm text-gray-400">Belum ada data layanan terkumpul.</div>
                @endforelse
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-8 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Peringkat Pendapatan Toko Laundry Terdaftar</h3>
            <span class="text-xs font-medium text-indigo-600 bg-blue-50 px-3 py-1 rounded-full">Papan Atas Pemimpin Pasar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Toko / Outlet</th>
                        <th class="px-6 py-4 text-right">Kontribusi Omset Bruto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                    @forelse($topLaundries as $index => $laundry)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $laundry->name }}</td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">Rp {{ number_format($laundry->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-sm text-gray-400">Belum ada data transaksi toko yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('chartTopLaundries').getContext('2d');
        
        // Parsing data dari koleksi Laravel Blade ke Array JavaScript secara aman
        const laundryNames = {!! json_encode($topLaundries->pluck('name')) !!};
        const laundryRevenues = {!! json_encode($topLaundries->pluck('total_revenue')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: laundryNames,
                datasets: [{
                    label: 'Omset Toko (Rp)',
                    data: laundryRevenues,
                    backgroundColor: 'rgba(31, 165, 254, 0.85)', // Warna Indigo modern
                    borderColor: 'rgb(70, 144, 229)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan label legend atas karena sudah jelas
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: '600' } }
                    }
                }
            }
        });
    });
</script>
@endsection