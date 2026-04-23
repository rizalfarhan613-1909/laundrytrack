@php $nav = [
    ['route' => 'kurir.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
    ['route' => 'kurir.history',   'icon' => 'list',             'label' => 'Riwayat Tugas'],
    ['route' => 'kurir.profile',   'icon' => 'user',             'label' => 'Profil Saya'],
]; @endphp
@foreach($nav as $item)
<a href="{{ route($item['route']) }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm {{ request()->routeIs($item['route']) ? 'active' : '' }}">
    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 flex-shrink-0"></i>
    <span x-show="sidebarOpen">{{ $item['label'] }}</span>
</a>
@endforeach
