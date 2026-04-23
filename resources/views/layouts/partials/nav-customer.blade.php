@php $navCustomer = [
    ['route' => 'customer.dashboard',    'icon' => 'home',           'label' => 'Beranda'],
    ['route' => 'customer.orders.create','icon' => 'plus-circle',    'label' => 'Order Baru'],
    ['route' => 'customer.orders.index', 'icon' => 'list',           'label' => 'Riwayat Order'],
]; @endphp
@foreach($navCustomer as $item)
<a href="{{ route($item['route']) }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm {{ request()->routeIs($item['route']) ? 'active' : '' }}">
    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 flex-shrink-0"></i>
    <span x-show="sidebarOpen">{{ $item['label'] }}</span>
</a>
@endforeach