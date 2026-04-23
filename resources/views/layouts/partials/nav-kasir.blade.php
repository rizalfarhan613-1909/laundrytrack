{{-- nav-kasir.blade.php --}}
@php
$nav = [
    ['route' => 'kasir.dashboard',      'icon' => 'clipboard-list', 'label' => 'Semua Order'],
    ['route' => 'kasir.payments.index', 'icon' => 'credit-card',    'label' => 'Pembayaran'],
];
@endphp
@foreach($nav as $item)
    <a href="{{ route($item['route']) }}"
       class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm {{ request()->routeIs($item['route']) ? 'active' : '' }}">
        <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 flex-shrink-0"></i>
        <span class="whitespace-nowrap overflow-hidden" x-show="sidebarOpen">{{ $item['label'] }}</span>
    </a>
@endforeach