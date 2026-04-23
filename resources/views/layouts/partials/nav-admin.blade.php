@php
$nav = [
    ['route' => 'admin.dashboard',       'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
    ['route' => 'kasir.dashboard',       'icon' => 'clipboard-list',   'label' => 'Kelola Order'],
    ['route' => 'kasir.payments.index', 'icon' => 'credit-card',    'label' => 'Pembayaran'],
    ['route' => 'admin.services.index',  'icon' => 'tag',              'label' => 'Daftar Harga'],
    ['route' => 'admin.kurir.index',     'icon' => 'truck',            'label' => 'Manajemen Kurir'],
    ['route' => 'admin.inventory.index', 'icon' => 'package',          'label' => 'Inventaris'],
    ['route' => 'admin.reports',         'icon' => 'bar-chart-2',      'label' => 'Laporan'],
    ['route' => 'admin.users.index',     'icon' => 'users',            'label' => 'Manajemen User'],
];
@endphp

@foreach($nav as $item)
    <a href="{{ route($item['route']) }}"
       class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm
              {{ request()->routeIs($item['route']) ? 'active' : '' }}">
        <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 flex-shrink-0"></i>
        <span class="whitespace-nowrap overflow-hidden" x-show="sidebarOpen">{{ $item['label'] }}</span>
    </a>
@endforeach