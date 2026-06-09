<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LaundryTrack | Order Support #LT-7892</title>
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
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-surface-wash text-on-surface font-body-lg antialiased overflow-hidden">
    <!-- Desktop Side Navigation -->
    <aside class="hidden md:flex flex-col fixed left-0 top-0 h-full py-base px-base space-y-4 bg-surface dark:bg-surface-dim h-screen w-64 border-r border-border-subtle z-50">
        <div class="px-4 py-6">
            <h1 class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">LaundryTrack</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Laundry Ops Console</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-semibold rounded-xl transition-transform active:scale-[0.98]" href="#">
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
        </nav>
        <div class="pt-4 border-t border-border-subtle">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest transition-colors duration-150" href="#">
                <span class="material-symbols-outlined">help_outline</span>
                <span class="font-label-caps text-label-caps">Help Center</span>
            </a>
        </div>
    </aside>
    <!-- Main Content Area -->
    <main class="md:ml-64 h-screen flex flex-col relative">
        <!-- Top App Bar -->
        <header class="bg-surface-container-lowest dark:bg-surface-container-lowest border-b border-border-subtle dark:border-outline-variant h-16 z-40 sticky top-0">
            <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter max-w-container-max mx-auto h-full">
                <div class="flex items-center gap-4">
                    <button class="md:hidden p-2 text-on-surface-variant">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="flex items-center gap-2">
                        <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest">Support / Order</span>
                        <span class="font-data-mono text-data-mono text-primary">#LT-7892</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface-container-lowest"></span>
                    </button>
                    <button class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full">
                        <span class="material-symbols-outlined">account_circle</span>
                    </button>
                </div>
            </div>
        </header>
        <!-- Layout Wrapper for Chat + Sidebar -->
        <div class="flex-1 flex overflow-hidden">
            <!-- Contextual Sidebar (Order Details) -->
            <aside class="hidden lg:flex flex-col w-80 border-r border-border-subtle bg-white overflow-y-auto no-scrollbar">
                <div class="p-gutter space-y-8">
                    <!-- Section: Order Info -->
                    <section>
                        <h3 class="font-label-caps text-label-caps text-outline uppercase mb-4">Customer Identity</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <img alt="Customer Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-surface-container" data-alt="A professional headshot of a middle-aged male customer with a friendly expression. He is set against a clean, neutral architectural background with soft natural lighting, reflecting a premium hospitality aesthetic. The colors are muted and sophisticated, matching a modern minimal design system." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzVP1Gujs-9tPuVna5MwD7ehSqtCueXX57R2LxdKCWauEhhce6KOD0q2hjrskbYo4Z8e_zNoxF1TGz9fIIU0Jme0-Eofd7GvyTYHubgkx-BLNaIoRo91evRIdrBPn6kxiZEvZzo1l25advQkTVNH1aCbxavrOZryiwc-9V6wnoZ7feDLt7nwFoM590wVOn-dhQ7t9VKm4veXAwuoXbj3hgIN05pm07uKN_-dSqjfKqPKgmcheIHXW4xecCbNPKxB3xBHRHBMSQqxw" />
                            <div>
                                <p class="font-headline-md text-headline-md text-on-surface">Julian Vance</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">julian.v@example.com</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 bg-primary-fixed text-on-primary-fixed rounded-full font-label-caps text-[10px] uppercase">Gold Member</span>
                            <span class="inline-flex items-center px-3 py-1 bg-surface-container text-on-surface-variant rounded-full font-label-caps text-[10px] uppercase">12 Orders Total</span>
                        </div>
                    </section>
                    <hr class="border-border-subtle" />
                    <!-- Section: Order Specs -->
                    <section>
                        <h3 class="font-label-caps text-label-caps text-outline uppercase mb-4">Service Details</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="font-label-caps text-label-caps text-outline">SERVICE TYPE</p>
                                <p class="font-body-lg text-body-lg text-on-surface">Premium Eco-Dry Cleaning</p>
                            </div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-label-caps text-label-caps text-outline">STATUS</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="w-1 h-4 bg-status-progress rounded-full"></span>
                                        <span class="font-body-sm text-body-sm text-status-progress font-semibold uppercase">In Processing</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-label-caps text-label-caps text-outline">EST. DELIVERY</p>
                                    <p class="font-body-sm text-body-sm text-on-surface">Tomorrow, 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <hr class="border-border-subtle" />
                    <!-- Section: Quick Actions -->
                    <section>
                        <h3 class="font-label-caps text-label-caps text-outline uppercase mb-4">Admin Shortcuts</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <button class="flex items-center justify-between p-3 border border-border-subtle rounded-xl hover:bg-surface-wash transition-colors">
                                <span class="font-body-sm text-body-sm">View Full Order</span>
                                <span class="material-symbols-outlined text-outline">open_in_new</span>
                            </button>
                            <button class="flex items-center justify-between p-3 border border-border-subtle rounded-xl hover:bg-surface-wash transition-colors">
                                <span class="font-body-sm text-body-sm">Request Photo Update</span>
                                <span class="material-symbols-outlined text-outline">add_a_photo</span>
                            </button>
                            <button class="flex items-center justify-between p-3 border border-border-subtle rounded-xl hover:bg-surface-wash transition-colors">
                                <span class="font-body-sm text-body-sm text-error">Escalate Issue</span>
                                <span class="material-symbols-outlined text-error opacity-70">priority_high</span>
                            </button>
                        </div>
                    </section>
                </div>
            </aside>
            <!-- Chat Window -->
            <section class="flex-1 flex flex-col bg-white">
                <!-- Chat Messages Scroll Area -->
                <div class="flex-1 overflow-y-auto p-gutter space-y-6 flex flex-col-reverse no-scrollbar">
                    <!-- Typing Indicator -->
                    <div class="flex items-end gap-3">
                        <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-surface-variant text-[16px]">account_circle</span>
                        </div>
                        <div class="bg-surface-container-low px-4 py-2 rounded-2xl rounded-bl-none flex gap-1 items-center">
                            <div class="w-1.5 h-1.5 bg-outline-variant rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-outline-variant rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-outline-variant rounded-full"></div>
                            <span class="font-body-sm text-body-sm text-outline ml-2">Julian is typing...</span>
                        </div>
                    </div>
                    <!-- Message From Customer -->
                    <div class="flex flex-col items-start max-w-[80%]">
                        <div class="bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl rounded-bl-none">
                            <p class="font-body-lg text-body-lg">Actually, could you double-check the silk lining on the blazer? There was a small snag I noticed before pickup.</p>
                        </div>
                        <span class="font-label-caps text-label-caps text-outline mt-1 ml-1">10:42 AM</span>
                    </div>
                    <!-- Message From Admin -->
                    <div class="flex flex-col items-end self-end max-w-[80%]">
                        <div class="bg-primary text-on-primary px-4 py-3 rounded-2xl rounded-br-none shadow-sm">
                            <p class="font-body-lg text-body-lg">Good morning Julian! Of course. I've flagged this for our specialist team. They will perform a microscopic inspection and reinforce the lining if needed. I'll send a photo in a moment.</p>
                        </div>
                        <div class="flex items-center gap-1 mt-1 mr-1">
                            <span class="font-label-caps text-label-caps text-outline">10:40 AM</span>
                            <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">done_all</span>
                        </div>
                    </div>
                    <!-- Message From Customer -->
                    <div class="flex flex-col items-start max-w-[80%]">
                        <div class="bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl rounded-bl-none">
                            <p class="font-body-lg text-body-lg">Hi, I have a quick question about order #LT-7892.</p>
                        </div>
                        <span class="font-label-caps text-label-caps text-outline mt-1 ml-1">10:38 AM</span>
                    </div>
                    <!-- Date Separator -->
                    <div class="flex items-center justify-center">
                        <div class="h-[1px] flex-1 bg-border-subtle"></div>
                        <span class="px-4 font-label-caps text-label-caps text-outline uppercase">Today</span>
                        <div class="h-[1px] flex-1 bg-border-subtle"></div>
                    </div>
                </div>
                <!-- Chat Input Area -->
                <footer class="p-gutter border-t border-border-subtle bg-white">
                    <div class="max-w-container-max mx-auto relative">
                        <div class="flex items-center gap-3 bg-surface-wash rounded-full border border-border-subtle px-4 py-2 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                            <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined">add_circle</span>
                            </button>
                            <input class="flex-1 bg-transparent border-none focus:ring-0 font-body-lg text-body-lg py-2" placeholder="Type a message to Julian..." type="text" />
                            <div class="flex items-center gap-1">
                                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">mood</span>
                                </button>
                                <button class="bg-primary text-on-primary p-3 rounded-full flex items-center justify-center hover:opacity-90 active:scale-95 transition-all">
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">send</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
        <!-- Bottom Navigation Bar (Mobile only) -->
        <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 bg-surface-container-lowest dark:bg-inverse-surface border-t border-border-subtle shadow-lg rounded-t-full">
            <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
                <span class="material-symbols-outlined">home</span>
                <span class="font-label-caps text-label-caps">Home</span>
            </a>
            <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="font-label-caps text-label-caps">Orders</span>
            </a>
            <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1 scale-90 transition-all duration-200" href="#">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                <span class="font-label-caps text-label-caps">Chat</span>
            </a>
            <a class="flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container-low px-4 py-1" href="#">
                <span class="material-symbols-outlined">query_stats</span>
                <span class="font-label-caps text-label-caps">Track</span>
            </a>
        </nav>
    </main>
    <!-- Contextual FAB (Only on specific screens, but technically active for "New Order" intent if required) -->
    <!-- Suppressed for this detailed chat/details screen to prioritize content canvas as per mandate -->
</body>

</html>