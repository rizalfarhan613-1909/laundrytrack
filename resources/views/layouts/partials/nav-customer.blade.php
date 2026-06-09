@php 
$navCustomer = [
    ['route' => 'customer.dashboard',     'icon' => 'home',           'label' => 'Beranda'],
    ['route' => 'customer.orders.create', 'icon' => 'add_circle',     'label' => 'Order Baru'],
    ['route' => 'customer.orders.index',  'icon' => 'history',        'label' => 'Riwayat Order'],
    ['route' => 'chat.index',             'icon' => 'chat',           'label' => 'Pesan'], 
]; 
@endphp

@foreach($navCustomer as $item)
<a href="{{ route($item['route']) }}" 
   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm {{ request()->routeIs($item['route']) ? 'active bg-blue-50 text-blue-700 font-semibold' : '' }}">
    
    <span class="material-symbols-outlined flex-shrink-0 !text-[22px]">{{ $item['icon'] }}</span>
    
    <span x-show="sidebarOpen">{{ $item['label'] }}</span>
</a>
@endforeach