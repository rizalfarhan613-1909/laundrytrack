<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LaundryTrack Admin Dashboard</title>
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
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen">
    <!-- SideNavBar (Shared Component) -->
    <nav class="hidden md:flex flex-col fixed left-0 top-0 h-full py-base px-base space-y-4 bg-surface border-r border-border-subtle w-64 z-50">
        <div class="px-4 py-6">
            <h1 class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant opacity-70">Laundry Ops Console</p>
        </div>
        <div class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-semibold rounded-xl scale-[0.98] transition-transform" href="#">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">chat_bubble</span>
                <span class="font-label-caps text-label-caps">Inbox</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">location_on</span>
                <span class="font-label-caps text-label-caps">Live Tracking</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">settings_applications</span>
                <span class="font-label-caps text-label-caps">Operations</span>
            </a>
        </div>
        <div class="pt-4 border-t border-border-subtle space-y-1">
            <button class="w-full mb-4 py-3 px-4 bg-primary text-on-primary font-bold rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined">add</span>
                New Order
            </button>
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">help_outline</span>
                <span class="font-label-caps text-label-caps">Help Center</span>
            </a>
        </div>
        <div class="flex items-center gap-3 px-4 py-4 mt-auto">
            <img alt="Admin" class="w-10 h-10 rounded-full border border-border-subtle" data-alt="A professional headshot of a laundry service manager, a middle-aged man with a friendly and reliable expression, set against a blurred high-end laundry facility background. The lighting is soft and natural, emphasizing a clinical yet premium atmosphere consistent with a luxury hospitality brand." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC8u2RrSbw5U7YqUWLrRyM_ROgArp-1W8qm4KZjmIYppdagAlXNNxkqXWxRVkdqToxirGXfx3g7DlfIfaQyUKY-rCxIjUqN4o4sJk9it4Hl1z1tqQeO4aE2tZtq3Vm50Aim4MSXv3fscoPIm_NBbI-YxxCnZQM84XvLkzNEB9k4tbNz1H-Gounquw6VJDIKJJlaAe7TjQYlCl02QvuY42mfqbJVwds6W-29dJXLp0WvsA3gVZZMIFmC2pHO5FG5LQpduFuMd1QRDv0" />
            <div>
                <p class="font-label-caps text-label-caps text-on-surface">Admin</p>
                <p class="text-[10px] text-on-surface-variant">Shift Manager</p>
            </div>
        </div>
    </nav>
    <!-- Main Content Area -->
    <main class="md:ml-64 min-h-screen pb-24 md:pb-8">
        <!-- Top Header -->
        <header class="h-16 flex justify-between items-center px-margin-mobile md:px-gutter bg-surface-container-lowest border-b border-border-subtle sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <span class="md:hidden material-symbols-outlined text-primary">menu</span>
                <h2 class="font-headline-md text-headline-md font-bold text-primary">Dashboard</h2>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-outline text-sm mr-2">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-body-sm w-64" placeholder="Search orders or clients..." type="text" />
                </div>
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">notifications</span>
                    <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">chat_bubble</span>
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-primary font-bold text-xs">LT</div>
                </div>
            </div>
        </header>
        <!-- Bento Grid Content -->
        <div class="max-w-container-max mx-auto p-margin-mobile md:p-gutter space-y-8">
            <!-- Quick Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-border-subtle flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">ACTIVE ORDERS</span>
                        <span class="material-symbols-outlined text-primary">local_laundry_service</span>
                    </div>
                    <div class="mt-4">
                        <p class="font-display text-display text-primary">124</p>
                        <p class="text-status-success font-body-sm flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-xs">trending_up</span> +12% from yesterday
                        </p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-border-subtle flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">DAILY REVENUE</span>
                        <span class="material-symbols-outlined text-primary">payments</span>
                    </div>
                    <div class="mt-4">
                        <p class="font-display text-display text-on-surface">$2,840</p>
                        <p class="text-on-surface-variant font-body-sm mt-1">Goal: $3,000</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-border-subtle flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">AVG TURNAROUND</span>
                        <span class="material-symbols-outlined text-primary">timer</span>
                    </div>
                    <div class="mt-4">
                        <p class="font-display text-display text-on-surface">4.2h</p>
                        <div class="w-full bg-surface-container h-1 rounded-full mt-3">
                            <div class="bg-status-success w-4/5 h-full rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-border-subtle flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">CSAT SCORE</span>
                        <span class="material-symbols-outlined text-primary">star</span>
                    </div>
                    <div class="mt-4">
                        <p class="font-display text-display text-on-surface">4.9</p>
                        <p class="text-on-surface-variant font-body-sm mt-1">240 Reviews this month</p>
                    </div>
                </div>
            </div>
            <!-- Main Operational Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Status Breakdown (Left/Center) -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Live Operations Monitor -->
                    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
                        <div class="p-6 border-b border-border-subtle flex justify-between items-center">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Operational Status</h3>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">REAL-TIME</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-border-subtle">
                            <div class="p-6 space-y-4">
                                <div class="flex items-center gap-2 text-status-progress">
                                    <span class="material-symbols-outlined text-sm">water_drop</span>
                                    <span class="font-label-caps text-label-caps">Washing</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="font-display text-[40px] leading-none">42</span>
                                    <span class="text-on-surface-variant font-body-sm">82% Cap.</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-[11px] font-label-caps text-on-surface-variant">
                                        <span>Station A-1</span>
                                        <span>12m left</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-status-progress w-[65%] h-full"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-sm">air</span>
                                    <span class="font-label-caps text-label-caps">Drying</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="font-display text-[40px] leading-none">28</span>
                                    <span class="text-on-surface-variant font-body-sm">56% Cap.</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-[11px] font-label-caps text-on-surface-variant">
                                        <span>Heat Unit B-4</span>
                                        <span>Ready</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary w-[30%] h-full"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center gap-2 text-status-success">
                                    <span class="material-symbols-outlined text-sm">iron</span>
                                    <span class="font-label-caps text-label-caps">Ironing</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="font-display text-[40px] leading-none">54</span>
                                    <span class="text-on-surface-variant font-body-sm">94% Cap.</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-[11px] font-label-caps text-on-surface-variant">
                                        <span>Manual Press 2</span>
                                        <span>Queued</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-status-success w-[90%] h-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Recent Orders List -->
                    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
                        <div class="p-6 border-b border-border-subtle flex justify-between items-center">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Urgent Orders</h3>
                            <button class="text-primary font-label-caps text-label-caps hover:underline">VIEW ALL</button>
                        </div>
                        <div class="divide-y divide-border-subtle">
                            <!-- Order Item -->
                            <div class="p-4 hover:bg-surface-wash transition-colors flex items-center gap-4">
                                <div class="w-1 bg-status-error h-12 rounded-full"></div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <span class="font-data-mono text-data-mono text-primary">#LT-89021</span>
                                        <span class="font-label-caps text-[10px] px-2 py-0.5 rounded bg-error-container text-on-error-container">PRIORITY</span>
                                    </div>
                                    <p class="font-body-lg text-body-lg text-on-surface mt-1">James Henderson • <span class="text-on-surface-variant">Silk Care</span></p>
                                </div>
                                <div class="hidden md:block text-right">
                                    <p class="font-label-caps text-label-caps text-on-surface-variant">DUE IN</p>
                                    <p class="font-body-sm text-body-sm font-semibold text-status-error">45 mins</p>
                                </div>
                                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </div>
                            <!-- Order Item -->
                            <div class="p-4 hover:bg-surface-wash transition-colors flex items-center gap-4">
                                <div class="w-1 bg-status-progress h-12 rounded-full"></div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <span class="font-data-mono text-data-mono text-primary">#LT-89025</span>
                                        <span class="font-label-caps text-[10px] px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container">STANDARD</span>
                                    </div>
                                    <p class="font-body-lg text-body-lg text-on-surface mt-1">The Ritz-Carlton • <span class="text-on-surface-variant">12kg Linen</span></p>
                                </div>
                                <div class="hidden md:block text-right">
                                    <p class="font-label-caps text-label-caps text-on-surface-variant">DUE IN</p>
                                    <p class="font-body-sm text-body-sm font-semibold text-on-surface">2.5 hours</p>
                                </div>
                                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </div>
                            <!-- Order Item -->
                            <div class="p-4 hover:bg-surface-wash transition-colors flex items-center gap-4">
                                <div class="w-1 bg-status-success h-12 rounded-full"></div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <span class="font-data-mono text-data-mono text-primary">#LT-88998</span>
                                        <span class="font-label-caps text-[10px] px-2 py-0.5 rounded bg-surface-container-highest text-on-surface-variant">EXPRESS</span>
                                    </div>
                                    <p class="font-body-lg text-body-lg text-on-surface mt-1">Elena Rodriguez • <span class="text-on-surface-variant">Winter Coats (3)</span></p>
                                </div>
                                <div class="hidden md:block text-right">
                                    <p class="font-label-caps text-label-caps text-on-surface-variant">STATUS</p>
                                    <p class="font-body-sm text-body-sm font-semibold text-status-success">Ready for Delivery</p>
                                </div>
                                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Inbox & Tracking (Right Column) -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Central Inbox -->
                    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
                        <div class="p-6 border-b border-border-subtle flex justify-between items-center bg-primary-container/5">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">inbox</span>
                                <h3 class="font-headline-md text-headline-md text-on-surface">Central Inbox</h3>
                            </div>
                            <span class="bg-primary text-on-primary text-[10px] font-bold px-2 py-0.5 rounded-full">3 NEW</span>
                        </div>
                        <div class="divide-y divide-border-subtle">
                            <div class="p-4 bg-primary-container/10 border-l-4 border-primary">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-body-sm font-bold text-on-surface">Sarah Miller</span>
                                    <span class="text-[10px] text-on-surface-variant">2m ago</span>
                                </div>
                                <p class="text-body-sm text-on-surface line-clamp-1">Can I add a suit to my existing order #89021?</p>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-body-sm font-semibold text-on-surface">Robert Fox</span>
                                    <span class="text-[10px] text-on-surface-variant">15m ago</span>
                                </div>
                                <p class="text-body-sm text-on-surface-variant line-clamp-1">The driver hasn't arrived yet for the pickup.</p>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-body-sm font-semibold text-on-surface">Hotel Ambassador</span>
                                    <span class="text-[10px] text-on-surface-variant">1h ago</span>
                                </div>
                                <p class="text-body-sm text-on-surface-variant line-clamp-1">Invoices for last week received, thank you.</p>
                            </div>
                        </div>
                        <div class="p-4 bg-surface-wash">
                            <button class="w-full py-2 bg-surface border border-border-subtle text-on-surface-variant font-label-caps text-label-caps rounded-lg hover:bg-surface-container-low transition-colors">GO TO INBOX</button>
                        </div>
                    </section>
                    <!-- Revenue Graph Card -->
                    <section class="bg-inverse-surface text-on-primary-container rounded-xl p-6 relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="font-label-caps text-label-caps opacity-70">REVENUE TREND</h3>
                            <p class="font-headline-lg text-headline-lg mt-2">$18,450.00</p>
                            <p class="text-[10px] font-medium text-primary-fixed-dim mt-1">+15.4% THIS MONTH</p>
                            <div class="mt-8 flex items-end gap-1.5 h-16">
                                <div class="bg-primary-container/30 w-full h-8 rounded-t-sm"></div>
                                <div class="bg-primary-container/30 w-full h-10 rounded-t-sm"></div>
                                <div class="bg-primary-container/30 w-full h-14 rounded-t-sm"></div>
                                <div class="bg-primary-container/30 w-full h-9 rounded-t-sm"></div>
                                <div class="bg-primary-container/30 w-full h-12 rounded-t-sm"></div>
                                <div class="bg-primary-container w-full h-16 rounded-t-sm"></div>
                                <div class="bg-primary-fixed-dim w-full h-10 rounded-t-sm"></div>
                            </div>
                        </div>
                        <!-- Decorative background element -->
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <span class="material-symbols-outlined text-[120px]">analytics</span>
                        </div>
                    </section>
                    <!-- Live Driver Tracking -->
                    <section class="bg-surface-container-lowest rounded-xl border border-border-subtle overflow-hidden">
                        <div class="p-4 border-b border-border-subtle flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">local_shipping</span>
                            <span class="font-label-caps text-label-caps">Fleet Tracking</span>
                        </div>
                        <div class="h-40 bg-surface-container-highest relative flex items-center justify-center">
                            <img alt="Map View" class="w-full h-full object-cover opacity-50 grayscale" data-alt="A clean, minimalist satellite map view of a suburban neighborhood area with smooth, muted tones and clinical precision. The map shows simplified streets and green areas, intended as a background for a professional logistics fleet tracking dashboard. The lighting is bright and modern." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJf_De_3j5rH27tm6sKCMeeYUIsIwt9WMlcwr7Q2ZYZit1uCrHqZrUFyAv2EZ5QVsjk7HasmL_89DOfvO_-zAg8NGbIYW-SM-W3T8obtt5AfOmjXDVjh4ymKXcVG0I5VzgSNonkk-hYRRKGC95VArdqTSax7XIvwQ6zE4qNN_JEGvo3vgtmcKA87YSa4OaBHN_iI-uSMqh0aftCXjOLAGBd8tK_hAE2bzUUlIYaElt0fJGAj5A-kxn473dFCqRjIyPeNRF2O1ASGA" />
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-primary text-on-primary p-2 rounded-full shadow-lg">
                                    <span class="material-symbols-outlined text-sm">navigation</span>
                                </div>
                            </div>
                            <div class="absolute bottom-2 left-2 bg-surface-container-lowest px-2 py-1 rounded text-[10px] font-bold border border-border-subtle">
                                4 DRIVERS ACTIVE
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <!-- BottomNavBar (Shared Component - Mobile Only) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 md:hidden bg-surface-container-lowest border-t border-border-subtle shadow-lg rounded-t-full">
        <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1 scale-90 transition-all duration-200" href="#">
            <span class="material-symbols-outlined">home</span>
            <span class="font-label-caps text-[10px]">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-caps text-[10px]">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">chat</span>
            <span class="font-label-caps text-[10px]">Chat</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">query_stats</span>
            <span class="font-label-caps text-[10px]">Track</span>
        </a>
    </nav>
</body>

</html>