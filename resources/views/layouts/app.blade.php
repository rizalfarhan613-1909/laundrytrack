<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->role ?? 'guest' }}-layout">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaundryTrack') — Laundry Digital UMKM</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        },
                        surface: '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Sidebar active state */
        .nav-item.active { @apply bg-blue-50 text-blue-700 font-semibold; }

        /* Status badge colors */
        .status-pending    { @apply bg-amber-100  text-amber-700  border border-amber-200; }
        .status-pickup     { @apply bg-blue-100   text-blue-700   border border-blue-200; }
        .status-in_process { @apply bg-purple-100 text-purple-700 border border-purple-200; }
        .status-ready      { @apply bg-green-100  text-green-700  border border-green-200; }
        .status-finished   { @apply bg-gray-100   text-gray-600   border border-gray-200; }
        .status-cancelled  { @apply bg-red-100    text-red-700    border border-red-200; }

        /* Smooth sidebar transition */
        .sidebar { transition: transform 0.25s cubic-bezier(0.4,0,0.2,1); }

        /* Card hover */
        .card-hover { transition: box-shadow 0.2s, transform 0.2s; }
        .card-hover:hover { box-shadow: 0 8px 24px -4px rgba(0,0,0,0.12); transform: translateY(-1px); }

        /* Loading pulse */
        @keyframes pulse-ring {
            0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59,130,246,0.4); }
            70%  { transform: scale(1);    box-shadow: 0 0 0 8px rgba(59,130,246,0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59,130,246,0); }
        }
        .pulse-ring { animation: pulse-ring 2s cubic-bezier(0.66, 0, 0, 1) infinite; }
    </style>

    @stack('head')
</head>
<body class="bg-surface text-gray-800 antialiased">

@auth
    {{-- ─── LAYOUT WITH SIDEBAR ─────────────────────────────────── --}}
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

        {{-- Sidebar --}}
        <aside class="sidebar flex flex-col bg-white border-r border-gray-100 shadow-sm z-30"
               :class="sidebarOpen ? 'w-64' : 'w-16'"
               style="min-height:100vh;">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-4 h-16 border-b border-gray-100">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center">
                    <i data-lucide="shirt" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-extrabold text-blue-700 text-lg tracking-tight whitespace-nowrap overflow-hidden"
                      x-show="sidebarOpen" x-transition>LaundryTrack</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4 px-2 space-y-1 overflow-y-auto">
                @include('layouts.partials.nav-' . auth()->user()->role)
            </nav>

            {{-- User Info --}}
            <div class="border-t border-gray-100 p-3" x-show="sidebarOpen" x-transition>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-700 font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 text-xs text-red-500 hover:text-red-700 py-1 px-2 rounded-lg hover:bg-red-50 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Bar --}}
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-500">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                    <span class="text-xs text-gray-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 mb-0">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-0">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-sm"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

@else
    {{-- ─── GUEST LAYOUT (no sidebar) ──────────────────────────── --}}
    @yield('content')
@endauth

<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    document.addEventListener('alpine:init', () => {
        setTimeout(() => lucide.createIcons(), 100);
    });
</script>

@stack('scripts')
</body>
</html>