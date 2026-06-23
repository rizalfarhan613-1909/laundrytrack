<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaundryTrack') — @yield('subtitle', 'Management Suite')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    {{-- ── Design System: Tailwind + Custom Config ── --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-high": "#e7e7f5",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f3f2ff",
                        "surface-container": "#ededfb",
                        "surface-container-highest": "#e1e1ef",
                        "surface-dim": "#d9d9e7",
                        "surface-bright": "#fbf8ff",
                        "surface-wash": "#F8FAFC",
                        "surface-variant": "#e1e1ef",
                        "surface": "#fbf8ff",
                        "background": "#fbf8ff",

                        /* ── KONFIGURASI WARNA BARU (BERBASIS BLUE-400) ── */
                        "primary": "#60a5fa",
                        /* Default Tailwind blue-400 */
                        "primary-container": "#dbeafe",
                        /* Blue-100 untuk background komponen soft */
                        "primary-fixed": "#eff6ff",
                        /* Blue-50 */
                        "primary-fixed-dim": "#bfdbfe",
                        /* Blue-200 */
                        "on-primary": "#ffffff",
                        /* Teks putih di atas bg-primary */
                        "on-primary-container": "#1e40af",
                        /* Teks gelap (Blue-800) untuk di dalam container soft */
                        "on-primary-fixed": "#172554",
                        /* Blue-950 */
                        "on-primary-fixed-variant": "#1e3a8a",
                        /* Blue-900 */
                        "inverse-primary": "#3b82f6",
                        /* Blue-500 */
                        "surface-tint": "#60a5fa",
                        /* Mengikuti warna primary utama */

                        "secondary": "#565e74",
                        "secondary-container": "#dae2fd",
                        "secondary-fixed": "#dae2fd",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#5c647a",
                        "on-secondary-fixed": "#131b2e",
                        "on-secondary-fixed-variant": "#3f465c",
                        "tertiary": "#952200",
                        "tertiary-container": "#bf3003",
                        "tertiary-fixed": "#ffdbd2",
                        "tertiary-fixed-dim": "#ffb4a1",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#ffddd5",
                        "on-tertiary-fixed": "#3c0800",
                        "on-tertiary-fixed-variant": "#891e00",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-surface": "#191b25",
                        "on-surface-variant": "#434656",
                        "on-background": "#191b25",
                        "outline": "#737688",
                        "outline-variant": "#c3c5d9",
                        "inverse-surface": "#2e303a",
                        "inverse-on-surface": "#f0effe",
                        "border-subtle": "#E2E8F0",
                        "status-success": "#10B981",
                        "status-error": "#EF4444",
                        "status-progress": "#F59E0B",
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        full: "0.75rem",
                    },
                    spacing: {
                        "container-max": "1280px",
                        "gutter": "24px",
                        "section-padding": "48px",
                        "base": "8px",
                        "margin-mobile": "16px",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        mono: ["JetBrains Mono", "monospace"],
                        "label-caps": ["Inter"],
                        "headline-lg": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "display": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                    },
                    fontSize: {
                        "label-caps": ["12px", {
                            lineHeight: "16px",
                            letterSpacing: "0.05em",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "data-mono": ["13px", {
                            lineHeight: "16px",
                            fontWeight: "500"
                        }],
                        "display": ["48px", {
                            lineHeight: "56px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }],
                        "body-sm": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],
                        "body-lg": ["16px", {
                            lineHeight: "24px",
                            fontWeight: "400"
                        }],
                        "headline-lg-mobile": ["24px", {
                            lineHeight: "32px",
                            fontWeight: "600"
                        }],
                        "headline-md": ["20px", {
                            lineHeight: "28px",
                            fontWeight: "600"
                        }],
                    },
                }
            }
        }
    </script>

    {{-- ── Google Fonts ── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar-link {
            transition: all 0.15s ease;
        }

        .sidebar-link:hover {
            transform: translateX(2px);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f3f2ff;
        }

        ::-webkit-scrollbar-thumb {
            background: #c3c5d9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #737688;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        @keyframes pulse-badge {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .badge-pulse {
            animation: pulse-badge 2s ease-in-out infinite;
        }
    </style>

    @stack('head')
</head>

<body class="bg-background text-on-surface font-body-lg text-body-lg min-h-screen"
    x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">

    {{-- ── TOP NAVIGATION BAR ── --}}
    <header class="fixed top-0 left-0 right-0 z-50 h-16 bg-surface-container-lowest border-b border-border-subtle">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter h-full max-w-container-max mx-auto">

            <div class="flex items-center gap-4">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                    class="md:hidden p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <button @click="sidebarOpen = !sidebarOpen"
                    class="hidden md:flex p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Logo" class="h-12 w-auto object-contain">
                    </div>
                    <span class="font-extrabold text-primary text-lg">LaundryTrack</span>
                </a>
            </div>

            <div class="hidden lg:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input type="text"
                        placeholder="Cari order, customer, atau produk..."
                        class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4
                              text-body-sm focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all">
                </div>
            </div>

            <div class="flex items-center gap-1 md:gap-2">
                <button class="lg:hidden p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full">
                    <span class="material-symbols-outlined">search</span>
                </button>

                <a href="{{ route('chat.index') }}"
                    class="relative p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined">chat_bubble</span>

                    @php
                    // Menggunakan data global dari AppServiceProvider agar performa web ngebut
                    $unread = $globalUnreadChatsCount ?? 0;
                    @endphp

                    @if($unread > 0)
                    <span class="absolute top-1 right-1 w-5 h-5 bg-status-error text-white text-[9px] font-bold
                               rounded-full flex items-center justify-center badge-pulse"
                        id="nav-chat-badge">
                        {{ $unread > 9 ? '9+' : $unread }}
                    </span>
                    @else
                    <span class="absolute top-1 right-1 w-5 h-5 bg-status-error text-white text-[9px] font-bold
                               rounded-full hidden items-center justify-center badge-pulse"
                        id="nav-chat-badge"></span>
                    @endif
                </a>

                {{-- ── SEKSI LONCENG NOTIFIKASI (UPDATED WITH ALPINE POLLING) ── --}}
                <div class="relative" x-data="{ 
                    open: false,
                    notifications: [],
                    unreadCount: 0,
                    init() {
                        this.fetchNotifications();
                        setInterval(() => this.fetchNotifications(), 10000); // Poll setiap 10 detik
                    },
                    fetchNotifications() {
                        fetch('{{ route('notifications.fetch') }}')
                            .then(res => res.json())
                            .then(data => {
                                this.notifications = data.notifications;
                                this.unreadCount = data.unreadCount;
                                
                                // OPSI TAMBAHAN: Jika backend menyertakan jumlah chat, sinkronkan otomatis ke badge chat global
                                if (data.unreadChatsCount !== undefined) {
                                    document.dispatchEvent(new CustomEvent('update-unread-badge', { detail: { count: data.unreadChatsCount } }));
                                }
                            })
                            .catch(err => console.log('Gagal memuat notifikasi'));
                    },
                    markAllRead() {
                        fetch('{{ route('notifications.markAsRead') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(() => this.fetchNotifications());
                    }
                }">
                    <button @click="open = !open"
                        class="relative p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span x-show="unreadCount > 0"
                            class="absolute top-1 right-1 w-5 h-5 bg-status-error text-white text-[9px] font-bold rounded-full flex items-center justify-center badge-pulse"
                            x-text="unreadCount > 9 ? '9+' : unreadCount"
                            style="display: none;">
                        </span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl border border-border-subtle shadow-xl z-50"
                        style="display: none;">
                        <div class="p-4 border-b border-border-subtle flex items-center justify-between">
                            <h3 class="font-headline-md text-headline-md">Notifikasi</h3>
                            <span @click="markAllRead()" class="text-xs text-primary cursor-pointer hover:underline">Tandai semua dibaca</span>
                        </div>
                        <div class="max-h-64 overflow-y-auto divide-y divide-border-subtle">
                            <template x-for="notif in notifications" :key="notif.id">
                                <div class="p-4 hover:bg-surface-container-low transition-colors" :class="{'bg-primary-fixed/40': !notif.read_at}">
                                    <div class="flex justify-between items-start gap-2">
                                        <p class="text-xs font-semibold text-on-surface" x-text="notif.data.title"></p>
                                        <span class="text-[9px] text-on-surface-variant whitespace-nowrap" x-text="notif.time_ago"></span>
                                    </div>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5" x-text="notif.data.message"></p>
                                </div>
                            </template>

                            <div x-show="notifications.length === 0" class="p-6 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-3xl mb-2 block opacity-30">notifications_off</span>
                                <p class="text-body-sm">Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#"
                    class="hidden md:flex p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 pl-2 pr-3 py-1.5 hover:bg-surface-container-low rounded-full transition-colors">
                        <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-fixed font-bold text-sm overflow-hidden">
                            @if(auth()->user()?->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-label-caps font-label-caps text-on-surface leading-none">
                                {{ Str::limit(auth()->user()?->name ?? 'User', 12) }}
                            </p>
                            <p class="text-[10px] text-on-surface-variant capitalize">
                                {{ auth()->user()?->role ?? '' }}
                            </p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant text-[16px] hidden md:block">expand_more</span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl border border-border-subtle shadow-xl z-50"
                        style="display: none;">
                        <div class="p-4 border-b border-border-subtle">
                            <p class="font-semibold text-on-surface">{{ auth()->user()?->name }}</p>
                            <p class="text-body-sm text-on-surface-variant">{{ auth()->user()?->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-primary-container/20 text-primary text-[10px] font-bold rounded-full capitalize">
                                {{ auth()->user()?->role }}
                            </span>
                        </div>
                        <div class="p-2">
                            <a href="#"
                                class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-low rounded-xl transition-colors text-body-sm">
                                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                                Edit Profil
                            </a>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile.edit') : '#' }}"
                                class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-low rounded-xl transition-colors text-body-sm">
                                <span class="material-symbols-outlined text-[20px]">settings</span>
                                Pengaturan
                            </a>
                            <div class="border-t border-border-subtle my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2 text-status-error hover:bg-red-50 rounded-xl transition-colors text-body-sm">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ── MOBILE SIDEBAR OVERLAY ── --}}
    <div x-show="mobileSidebarOpen"
        @click="mobileSidebarOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm md:hidden"
        style="display:none"></div>

    {{-- ── SIDEBAR NAVIGATION ── --}}
    <aside id="sidebar"
        :class="[
       'fixed left-0 top-16 h-[calc(100vh-64px)] z-40 flex flex-col',
       'bg-surface-container-low border-r border-border-subtle',
       'transition-all duration-300 ease-in-out overflow-hidden',
       sidebarOpen ? 'w-64' : 'w-0 md:w-16',
       mobileSidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0'
    ]">

        <div class="flex-1 overflow-y-auto py-4 no-scrollbar">
            @auth
            @include('layouts.partials.nav-' . auth()->user()->role)
            @endauth
        </div>

        <div class="flex-shrink-0 p-3 border-t border-border-subtle space-y-1">
            @auth
            @if(in_array(auth()->user()->role, ['admin','kasir']))
            <a href="#"
                class="flex items-center gap-3 w-full px-3 py-2.5 bg-primary text-on-primary rounded-xl font-label-caps text-label-caps hover:opacity-90 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span :class="sidebarOpen ? 'block' : 'hidden'" class="whitespace-nowrap">Order Baru</span>
            </a>
            @endif
            @endauth

            {{-- UPDATE: Tombol Pengaturan Toko (Aktif jika role admin) --}}
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile.edit') : '#' }}"
                class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-colors sidebar-link {{ request()->routeIs('admin.profile.edit') ? 'bg-indigo-50 text-indigo-600 font-bold' : '' }}">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span :class="sidebarOpen ? 'block' : 'hidden'" class="font-label-caps text-label-caps whitespace-nowrap">Pengaturan</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-colors sidebar-link">
                <span class="material-symbols-outlined text-[20px]">help_outline</span>
                <span :class="sidebarOpen ? 'block' : 'hidden'" class="font-label-caps text-label-caps whitespace-nowrap">Bantuan</span>
            </a>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main :class="[
          'pt-16 min-h-screen transition-all duration-300',
          sidebarOpen ? 'md:pl-64' : 'md:pl-16',
          'pb-20 md:pb-8'
      ]">

        @hasSection('page-header')
        <div class="sticky top-16 z-30 bg-surface-container-lowest border-b border-border-subtle">
            <div class="px-margin-mobile md:px-gutter py-4 max-w-container-max mx-auto flex items-center justify-between">
                @yield('page-header')
            </div>
        </div>
        @endif

        {{-- Flash Messages --}}
        @if(session('success') || session('error') || session('info'))
        <div class="px-margin-mobile md:px-gutter pt-4 max-w-container-max mx-auto"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-status-success/10 border border-status-success/20 text-status-success px-4 py-3 rounded-xl">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <span class="text-body-sm font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto"><span class="material-symbols-outlined text-[16px]">close</span></button>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-status-error/10 border border-status-error/20 text-status-error px-4 py-3 rounded-xl">
                <span class="material-symbols-outlined text-[20px]">error</span>
                <span class="text-body-sm font-medium">{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto"><span class="material-symbols-outlined text-[16px]">close</span></button>
            </div>
            @endif
        </div>
        @endif

        <div class="px-margin-mobile md:px-gutter pt-6 max-w-container-max mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">@yield('page-title', )</h1>
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                </div>
            </div>
        </div>

        <div class="px-margin-mobile md:px-gutter py-6 max-w-container-max mx-auto">
            @yield('content')
        </div>
    </main>

    {{-- ── MOBILE BOTTOM NAVIGATION ── --}}
    <nav class="fixed bottom-0 left-0 w-full z-50 flex md:hidden justify-around items-center px-4 py-2 bg-surface-container-lowest border-t border-border-subtle shadow-lg">
        @auth
        @include('layouts.partials.nav-kasir')
        @endauth
    </nav>

    {{-- ── GLOBAL SCRIPTS ── --}}
    <script>
        document.addEventListener('update-unread-badge', (e) => {
            const count = e.detail?.count ?? 0;
            const badge = document.getElementById('nav-chat-badge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        });

        window.showToast = function(message, type = 'success') {
            const colors = {
                success: 'bg-status-success text-white',
                error: 'bg-status-error text-white',
                warning: 'bg-status-progress text-white',
                info: 'bg-primary text-white',
            };
            const t = document.createElement('div');
            t.className = `fixed bottom-24 md:bottom-6 left-1/2 -translate-x-1/2 z-[100]
                ${colors[type] || colors.info} px-5 py-3 rounded-2xl shadow-2xl text-sm font-medium flex items-center gap-2 max-w-sm`;
            t.style.cssText = 'opacity:0;transform:translate(-50%,12px);transition:opacity .2s,transform .2s';
            t.innerHTML = message;
            document.body.appendChild(t);
            requestAnimationFrame(() => {
                t.style.opacity = '1';
                t.style.transform = 'translate(-50%,0)';
            });
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transform = 'translate(-50%,12px)';
                setTimeout(() => t.remove(), 200);
            }, 4000);
        };
    </script>

    @livewireScripts

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>

</html>