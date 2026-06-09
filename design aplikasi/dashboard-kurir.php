<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Courier Dashboard | LaundryTrack</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "background": "#fbf8ff",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f3f2ff",
                        "surface": "#fbf8ff",
                        "on-error": "#ffffff",
                        "status-error": "#EF4444",
                        "tertiary-fixed": "#ffdbd2",
                        "on-background": "#191b25",
                        "surface-bright": "#fbf8ff",
                        "surface-container-highest": "#e1e1ef",
                        "on-tertiary-fixed-variant": "#891e00",
                        "surface-container": "#ededfb",
                        "on-error-container": "#93000a",
                        "on-primary-fixed-variant": "#0038b6",
                        "outline": "#737688",
                        "inverse-surface": "#2e303a",
                        "primary-container": "#0052ff",
                        "primary-fixed-dim": "#b7c4ff",
                        "border-subtle": "#E2E8F0",
                        "on-surface-variant": "#434656",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-primary-fixed": "#001452",
                        "primary": "#003ec7",
                        "status-progress": "#F59E0B",
                        "surface-tint": "#004ced",
                        "on-secondary-container": "#5c647a",
                        "surface-dim": "#d9d9e7",
                        "outline-variant": "#c3c5d9",
                        "secondary": "#565e74",
                        "error": "#ba1a1a",
                        "surface-variant": "#e1e1ef",
                        "tertiary-container": "#bf3003",
                        "surface-container-high": "#e7e7f5",
                        "primary-fixed": "#dde1ff",
                        "on-tertiary-fixed": "#3c0800",
                        "on-tertiary-container": "#ffddd5",
                        "tertiary-fixed-dim": "#ffb4a1",
                        "status-success": "#10B981",
                        "on-surface": "#191b25",
                        "error-container": "#ffdad6",
                        "on-secondary": "#ffffff",
                        "on-primary-container": "#dfe3ff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-secondary-fixed": "#131b2e",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#952200",
                        "secondary-container": "#dae2fd",
                        "surface-container-lowest": "#ffffff",
                        "inverse-on-surface": "#f0effe",
                        "surface-wash": "#F8FAFC",
                        "secondary-fixed": "#dae2fd",
                        "inverse-primary": "#b7c4ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "base": "8px",
                        "container-max": "1280px",
                        "gutter": "24px",
                        "margin-mobile": "16px",
                        "section-padding": "48px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "label-caps": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "display": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "body-lg": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "label-caps": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "600"
                        }],
                        "data-mono": ["13px", {
                            "lineHeight": "16px",
                            "fontWeight": "500"
                        }],
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "600"
                        }],
                        "display": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-lg overflow-x-hidden">
    <!-- SideNavBar (Desktop Shell) -->
    <aside class="hidden md:flex flex-col fixed left-0 top-0 h-full py-base px-base space-y-4 bg-surface border-r border-border-subtle w-64 z-40">
        <div class="px-4 py-6">
            <h1 class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Laundry Ops Console</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-semibold rounded-xl scale-[0.98] transition-transform" href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
                <span class="font-label-caps text-label-caps">Inbox</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="location_on">location_on</span>
                <span class="font-label-caps text-label-caps">Live Tracking</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="settings_applications">settings_applications</span>
                <span class="font-label-caps text-label-caps">Operations</span>
            </a>
        </nav>
        <div class="pt-4 border-t border-border-subtle space-y-1">
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
                <span class="font-label-caps text-label-caps">Help Center</span>
            </a>
        </div>
    </aside>
    <!-- TopNavBar -->
    <header class="fixed top-0 right-0 left-0 md:left-64 bg-surface-container-lowest border-b border-border-subtle h-16 z-30">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter h-full max-w-container-max mx-auto">
            <div class="flex items-center gap-4 flex-1">
                <div class="md:hidden">
                    <span class="material-symbols-outlined text-primary" data-icon="menu">menu</span>
                </div>
                <div class="relative w-full max-w-md hidden sm:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 text-body-sm focus:ring-2 focus:ring-primary" placeholder="Search tasks or addresses..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 hover:bg-surface-container-low transition-colors duration-200 rounded-full relative">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <button class="p-2 hover:bg-surface-container-low transition-colors duration-200 rounded-full">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="chat_bubble">chat_bubble</span>
                </button>
                <div class="flex items-center gap-3 pl-4 border-l border-border-subtle">
                    <div class="hidden sm:block text-right">
                        <p class="font-label-caps text-label-caps text-on-surface">Alex Courier</p>
                        <p class="font-body-sm text-[10px] text-on-surface-variant uppercase tracking-wider">Active Now</p>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant text-4xl" data-icon="account_circle">account_circle</span>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="pt-20 pb-24 md:pb-8 md:pl-64 min-h-screen">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter">
            <!-- Hero Stats Row -->
            <section class="mb-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                    <div>
                        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Daily Dispatch</h2>
                        <p class="text-on-surface-variant font-body-lg">8 assigned tasks remaining for today.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-label-caps text-label-caps text-status-success bg-status-success/10 px-3 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span> 12 Completed
                        </span>
                        <span class="font-label-caps text-label-caps text-status-progress bg-status-progress/10 px-3 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="schedule">schedule</span> 8 Pending
                        </span>
                    </div>
                </div>
                <!-- Quick Actions Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined" data-icon="route">route</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-label-caps text-on-surface-variant uppercase">Est. Distance</p>
                            <p class="font-headline-md text-headline-md">24.5 km</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container/10 flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined" data-icon="speed">speed</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-label-caps text-on-surface-variant uppercase">Efficiency</p>
                            <p class="font-headline-md text-headline-md">94%</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl flex items-center gap-4 col-span-2 md:col-span-1">
                        <button class="w-full flex items-center justify-center gap-2 bg-primary text-on-primary font-label-caps text-label-caps py-3 rounded-lg hover:opacity-90 transition-opacity">
                            <span class="material-symbols-outlined" data-icon="map">map</span> Optimize Route
                        </button>
                    </div>
                </div>
            </section>
            <!-- Task List: Bento Grid Pattern -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Main Task Column -->
                <div class="lg:col-span-8 space-y-4">
                    <h3 class="font-label-caps text-label-caps text-on-surface-variant mb-2">Priority Tasks</h3>
                    <!-- Task Card 1: Active Pickup -->
                    <div class="group bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden relative flex flex-col md:flex-row transition-all hover:border-primary/30">
                        <div class="w-1 h-full absolute left-0 bg-status-progress"></div>
                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="font-label-caps text-label-caps text-status-progress bg-status-progress/10 px-2 py-0.5 rounded uppercase">Pickup Requested</span>
                                    <h4 class="font-headline-md text-headline-md mt-2">Order #LT-9021</h4>
                                </div>
                                <div class="text-right">
                                    <p class="font-data-mono text-data-mono text-on-surface-variant">Due: 14:30</p>
                                    <p class="text-[10px] font-label-caps text-status-error uppercase">Urgent</p>
                                </div>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-primary" data-icon="person_pin_circle">person_pin_circle</span>
                                    <div>
                                        <p class="font-label-caps text-label-caps">Customer</p>
                                        <p class="font-body-lg text-body-lg font-semibold">Julianna Vane</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="location_on">location_on</span>
                                    <div>
                                        <p class="font-label-caps text-label-caps">Address</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">452 Luxury Heights, Penthouse B, Silicon Valley, CA 94025</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 pt-4 border-t border-border-subtle">
                                <button class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-border-subtle rounded-lg font-label-caps text-label-caps hover:bg-surface-container-low transition-colors">
                                    <span class="material-symbols-outlined text-sm" data-icon="chat">chat</span> Chat Customer
                                </button>
                                <button class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-border-subtle rounded-lg font-label-caps text-label-caps hover:bg-surface-container-low transition-colors">
                                    <span class="material-symbols-outlined text-sm" data-icon="support_agent">support_agent</span> Contact Admin
                                </button>
                                <div class="flex-1 md:ml-auto flex items-center justify-between gap-4 bg-surface-container-low px-4 py-2 rounded-lg">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant">Arrived?</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input class="sr-only peer" type="checkbox" />
                                        <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-status-success"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-64 h-48 md:h-auto bg-surface-container-high relative overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover" data-alt="A clean, minimalist digital map interface showing a suburban neighborhood layout with a highlighted blue delivery route. The map features subtle tonal layering with soft whites and light grays, reflecting a premium logistics application style. A single prominent location pin indicates the destination at a modern luxury apartment complex, surrounded by clean lines and high-end aesthetic whitespace." data-location="Palo Alto, California" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3o0ktQsFU2qKDodUHAgBADL59LAPodq8u4ws2Ph2xCtMK-qd4hVe_AQcfOHYaA4U3pfBYGGCTKjXovG1McmBLqhygw9WT90ri_u2tWlrOSy30jjEba-oJdW8SSNIOIjxAB1DtYw8kaQeqgJb8iHFqIJcSD7Ps_uHJ6f4R2PHlhI41zILujE_PwrW10__GuvpNdZgiYet9qm2ASqOw5qwDISnauon_WCTqiSSE-1dpwBJlm9CeRLlQ8sS2TdSpVdwPFxRATQ0P2HM" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            <button class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg">
                                <span class="material-symbols-outlined text-primary" data-icon="open_in_new">open_in_new</span>
                            </button>
                        </div>
                    </div>
                    <!-- Task Card 2: Upcoming Delivery -->
                    <div class="group bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden relative flex flex-col md:flex-row transition-all hover:border-primary/30">
                        <div class="w-1 h-full absolute left-0 bg-status-success"></div>
                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="font-label-caps text-label-caps text-status-success bg-status-success/10 px-2 py-0.5 rounded uppercase">Ready for Delivery</span>
                                    <h4 class="font-headline-md text-headline-md mt-2">Order #LT-8842</h4>
                                </div>
                                <div class="text-right">
                                    <p class="font-data-mono text-data-mono text-on-surface-variant">Window: 15:00 - 17:00</p>
                                </div>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-primary" data-icon="person_pin_circle">person_pin_circle</span>
                                    <div>
                                        <p class="font-label-caps text-label-caps">Customer</p>
                                        <p class="font-body-lg text-body-lg font-semibold">Robert Sterling</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="location_on">location_on</span>
                                    <div>
                                        <p class="font-label-caps text-label-caps">Address</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">128 Innovation Way, Suite 400, Tech Park, CA 94022</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 pt-4 border-t border-border-subtle">
                                <button class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-border-subtle rounded-lg font-label-caps text-label-caps hover:bg-surface-container-low transition-colors">
                                    <span class="material-symbols-outlined text-sm" data-icon="chat">chat</span> Chat Customer
                                </button>
                                <div class="flex-1 md:ml-auto flex items-center justify-between gap-4 bg-surface-container-low px-4 py-2 rounded-lg">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant">Update Status</span>
                                    <select class="bg-transparent border-none font-label-caps text-label-caps text-primary focus:ring-0 cursor-pointer p-0">
                                        <option>EN ROUTE</option>
                                        <option>DELIVERED</option>
                                        <option>ATTEMPTED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-64 h-48 md:h-auto bg-surface-container-high relative overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover grayscale-[0.5]" data-alt="A minimalist overhead view of a clean city grid map with a green delivery indicator. The visualization uses a refined palette of soft mint green, slate grays, and crisp whites. The aesthetic is modern and clinical, emphasizing efficiency and clarity through generous whitespace and professional cartographic styling typical of high-end logistics dashboards." data-location="Mountain View, California" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQZe0qAu-BWdrgn2Y2xqpIW6_A3yVyAY0K4lIWPgHrPM3nbV-GvM7CMxUNTYNxdqbqCwl8wsLFQr6E_dv6kXBRAOMVWJdOPRyQyVKhTz7z8MC36bLTZdk9ff1DfAq-gWF4wRFJ7FUvHaoNtg7EAy0hPcuhF_-D_ZpXA8uNCj5--s5GZgqkw4U6n41kl0greDGOs_WzeDs9ow9z0Jum4V-26CBQCIKe7Ps4u9kEq7EHBVGMfMSnQw0Cm_bDJkJu6crL2kIoZLw0r6k" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            <button class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg">
                                <span class="material-symbols-outlined text-primary" data-icon="open_in_new">open_in_new</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Contextual Info -->
                <aside class="lg:col-span-4 space-y-6">
                    <!-- Live Support Widget -->
                    <div class="bg-surface-container-highest/30 border border-border-subtle rounded-xl p-6">
                        <h3 class="font-label-caps text-label-caps text-on-surface-variant mb-4">Operations Center</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 bg-surface-container-lowest p-3 rounded-lg border border-border-subtle">
                                <div class="w-10 h-10 rounded-full bg-status-success/20 flex items-center justify-center text-status-success">
                                    <span class="material-symbols-outlined" data-icon="support_agent">support_agent</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-label-caps text-label-caps">Dispatch Manager</p>
                                    <p class="font-body-sm text-body-sm font-semibold">Sarah Jenkins</p>
                                </div>
                                <button class="w-8 h-8 flex items-center justify-center bg-primary text-on-primary rounded-full">
                                    <span class="material-symbols-outlined text-sm" data-icon="chat">chat</span>
                                </button>
                            </div>
                            <div class="p-4 bg-primary-container/10 border border-primary-container/20 rounded-lg">
                                <p class="font-label-caps text-label-caps text-primary mb-2">Notice</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Heavy traffic reported on Hwy 101. Estimated 15-minute delays for South-bound deliveries.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Performance Card -->
                    <div class="bg-inverse-surface text-inverse-on-surface rounded-xl p-6 shadow-xl">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="font-label-caps text-label-caps opacity-70">Daily Earned</p>
                                <p class="font-display text-4xl font-bold mt-1">$342.50</p>
                            </div>
                            <span class="material-symbols-outlined text-status-success text-3xl" data-icon="trending_up">trending_up</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm opacity-80">
                                <span>Base Pay</span>
                                <span>$240.00</span>
                            </div>
                            <div class="flex justify-between text-sm opacity-80">
                                <span>Tips</span>
                                <span class="text-status-success">+$102.50</span>
                            </div>
                            <div class="h-px bg-white/10 my-4"></div>
                            <button class="w-full py-3 bg-white/10 hover:bg-white/20 transition-colors rounded-lg font-label-caps text-label-caps text-center">View Full Earnings</button>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </main>
    <!-- BottomNavBar (Mobile Shell) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 md:hidden bg-surface-container-lowest border-t border-border-subtle shadow-lg">
        <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1 scale-90 transition-all duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="home">home</span>
            <span class="font-label-caps text-[10px] uppercase">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
            <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
            <span class="font-label-caps text-[10px] uppercase">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
            <span class="material-symbols-outlined" data-icon="chat">chat</span>
            <span class="font-label-caps text-[10px] uppercase">Chat</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
            <span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
            <span class="font-label-caps text-[10px] uppercase">Track</span>
        </a>
    </nav>
    <!-- Floating Quick Status Toggle (Mobile Specific) -->
    <button class="md:hidden fixed bottom-20 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center z-40 transition-transform active:scale-90">
        <span class="material-symbols-outlined text-3xl" data-icon="add">add</span>
    </button>
</body>

</html>