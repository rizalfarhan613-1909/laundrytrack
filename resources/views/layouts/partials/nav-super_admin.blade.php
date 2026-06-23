@php
$nav = [
    ['route' => 'ceo.dashboard',         'icon' => 'monitoring',         'label' => 'Monitoring Dashboard'],
    ['route' => 'ceo.plans.index',       'icon' => 'card_membership',    'label' => 'Paket Langganan SaaS'],
    ['route' => 'ceo.laundries.index',   'icon' => 'store',              'label' => 'Manajemen Mitra Toko'],
    ['route' => 'ceo.templates.index',   'icon' => 'category',           'label' => 'Template Layanan Global'],
];
@endphp

@foreach($nav as $item)
    <a href="{{ route($item['route']) }}"
       class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm
              {{ request()->routeIs($item['route']) ? 'active bg-blue-500 text-white shadow-sm' : '' }}">
        <span class="material-symbols-outlined text-[20px] flex-shrink-0">{{ $item['icon'] }}</span>
        <span class="whitespace-nowrap overflow-hidden" x-show="sidebarOpen">{{ $item['label'] }}</span>
    </a>
@endforeach