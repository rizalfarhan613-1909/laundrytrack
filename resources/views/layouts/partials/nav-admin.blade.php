@php
$nav = [
    ['route' => 'admin.dashboard',       'icon' => 'dashboard',          'label' => 'Dashboard'],
    ['route' => 'kasir.dashboard',       'icon' => 'assignment',         'label' => 'Kelola Order'],
    ['route' => 'kasir.payments.index',  'icon' => 'credit_card',        'label' => 'Pembayaran'],
    //['route' => 'kasir.loyalty.settings', 'icon' => 'redeem',             'label' => 'Poin Loyalitas'],
    ['route' => 'admin.services.index',  'icon' => 'sell',               'label' => 'Daftar Harga'],
    ['route' => 'admin.kurir.index',     'icon' => 'local_shipping',     'label' => 'Manajemen Kurir'],
    ['route' => 'admin.inventory.index', 'icon' => 'inventory_2',        'label' => 'Inventaris'],
    ['route' => 'admin.reports',         'icon' => 'bar_chart',          'label' => 'Laporan'],
    ['route' => 'admin.pegawai.index',   'icon' => 'group',              'label' => 'Manajemen Pegawai'], // ◄ PERUBAHAN: Menyesuaikan ke rute baru pegawai
];
@endphp

@foreach($nav as $item)
    <a href="{{ route($item['route']) }}"
       class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm
              {{ request()->routeIs($item['route']) || (str_contains($item['route'], 'pegawai') && request()->routeIs('admin.pegawai.*')) ? 'active' : '' }}">
        <span class="material-symbols-outlined text-[20px] flex-shrink-0">{{ $item['icon'] }}</span>
        <span class="whitespace-nowrap overflow-hidden" x-show="sidebarOpen">{{ $item['label'] }}</span>
    </a>
@endforeach