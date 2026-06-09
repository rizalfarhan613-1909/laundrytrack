<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
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
</head>

<body class="bg-background text-on-surface font-body-lg text-body-lg">
    <!-- Top Navigation Bar -->
    <header class="bg-surface-container-lowest border-b border-border-subtle fixed top-0 left-0 w-full z-50">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter max-w-container-max mx-auto h-16">
            <div class="flex items-center gap-4">
                <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
            </div>
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-body-sm focus:ring-2 focus:ring-primary/20" placeholder="Search orders..." type="text" />
                </div>
            </div>
            <nav class="flex items-center gap-6">
                <div class="hidden md:flex gap-4">
                    <a class="text-primary font-bold border-b-2 border-primary py-5" href="#">Track</a>
                    <a class="text-on-surface-variant font-medium hover:bg-surface-container-low transition-colors duration-200 px-2 py-5" href="#">Orders</a>
                </div>
                <div class="flex gap-4 items-center">
                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-all">notifications</button>
                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-all">chat_bubble</button>
                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-all">account_circle</button>
                </div>
            </nav>
        </div>
    </header>
    <main class="pt-24 pb-32 px-margin-mobile md:px-gutter max-w-container-max mx-auto">
        <!-- Search Section -->
        <section class="flex flex-col items-center text-center mb-16 max-w-2xl mx-auto">
            <h1 class="font-display text-display mb-4">Track Your Freshness</h1>
            <p class="text-on-surface-variant mb-8 font-body-lg">Enter your order ID or receipt number to get real-time updates on your laundry's journey.</p>
            <div class="w-full group">
                <div class="relative flex items-center bg-surface-container-lowest border border-border-subtle rounded-full p-2 shadow-sm focus-within:border-primary transition-all duration-300">
                    <span class="material-symbols-outlined ml-4 text-on-surface-variant">receipt_long</span>
                    <input class="w-full bg-transparent border-none focus:ring-0 px-4 py-3 font-data-mono text-headline-md placeholder:font-body-lg" placeholder="e.g. LT-00000" type="text" value="LT-94021-X" />
                    <button class="bg-primary text-on-primary px-8 py-3 rounded-full font-label-caps hover:opacity-90 active:scale-95 transition-all">
                        TRACK
                    </button>
                </div>
            </div>
        </section>
        <!-- Tracking Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- Left: Order Details & Status -->
            <div class="lg:col-span-8 space-y-gutter">
                <!-- Main Status Card -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-progress"></div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-12">
                            <div>
                                <span class="font-label-caps text-label-caps bg-status-progress/10 text-status-progress px-3 py-1 rounded-full inline-block mb-2">IN PROGRESS</span>
                                <h2 class="font-headline-lg text-headline-lg">Processing Order</h2>
                                <p class="text-on-surface-variant font-body-sm mt-1">Est. Completion: Today, 5:30 PM</p>
                            </div>
                            <div class="text-right">
                                <p class="font-label-caps text-label-caps text-on-surface-variant">ORDER ID</p>
                                <p class="font-data-mono text-headline-md text-primary">LT-94021-X</p>
                            </div>
                        </div>
                        <!-- Progress Stepper -->
                        <div class="relative flex justify-between items-center px-4">
                            <!-- Progress Line Background -->
                            <div class="absolute top-5 left-8 right-8 h-0.5 bg-surface-container-highest"></div>
                            <!-- Active Progress Line -->
                            <div class="absolute top-5 left-8 w-1/2 h-0.5 bg-primary"></div>
                            <!-- Step 1 -->
                            <div class="relative z-10 flex flex-col items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-[20px]" data-weight="fill">check</span>
                                </div>
                                <div class="text-center">
                                    <p class="font-label-caps text-label-caps text-primary">PICKUP</p>
                                    <p class="text-[10px] text-on-surface-variant mt-1">Completed</p>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="relative z-10 flex flex-col items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center ring-4 ring-primary-fixed">
                                    <span class="material-symbols-outlined text-[20px]">local_laundry_service</span>
                                </div>
                                <div class="text-center">
                                    <p class="font-label-caps text-label-caps text-primary">PROCESSING</p>
                                    <p class="text-[10px] text-on-surface-variant mt-1">Current State</p>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div class="relative z-10 flex flex-col items-center gap-4 opacity-40">
                                <div class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                                </div>
                                <div class="text-center">
                                    <p class="font-label-caps text-label-caps">READY</p>
                                    <p class="text-[10px] mt-1">Pending</p>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div class="relative z-10 flex flex-col items-center gap-4 opacity-40">
                                <div class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[20px]">delivery_dining</span>
                                </div>
                                <div class="text-center">
                                    <p class="font-label-caps text-label-caps">DELIVERY</p>
                                    <p class="text-[10px] mt-1">Scheduled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Details Accordion-like list -->
                    <div class="border-t border-border-subtle bg-surface-wash p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">wash</span>
                            <div>
                                <p class="font-label-caps text-[10px] text-on-surface-variant">SERVICE TYPE</p>
                                <p class="font-body-sm font-semibold">Wash &amp; Fold Premium</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">scale</span>
                            <div>
                                <p class="font-label-caps text-[10px] text-on-surface-variant">LOAD WEIGHT</p>
                                <p class="font-body-sm font-semibold">12.4 kg</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            <div>
                                <p class="font-label-caps text-[10px] text-on-surface-variant">LOCATION</p>
                                <p class="font-body-sm font-semibold">Central Hub A1</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Live Map Section -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-1 h-80 overflow-hidden relative">
                    <img alt="Delivery Map" class="w-full h-full object-cover rounded-lg grayscale opacity-80" data-alt="A clean, minimalist digital map showing a delivery tracking route in a stylized metropolitan area. The map uses a soft pastel color palette with primary blue accents for the route and a courier icon. Soft lighting and a clinical, high-end hospitality aesthetic are visible in the interface design, emphasizing reliability and professional service logistics." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCy2qQRGFfJOiWPoWCoptAy0It8VcFXJPIKmUT6S995Kq1bcE9NBNKfNdUROPXM2PO52tdeLOYEX0dap0vglnbo_B-cdTFMaOK__0deqxACvZp0EfJ7e8BmNWeMMyKX7PYOYne93Zlx_rg_eY39I0L1set22PZ1kUF37SsprYMSQjFGA7vXKs2UxFjEZHt2Cl75q0rZa8zw79YZchSv8zp-J-Fp87AKfbdyXftp3ELvvnue_2txu_4cZUBfZ3BLbe3UlYZGy4lntC0" />
                    <div class="absolute bottom-6 right-6 bg-surface-container-lowest shadow-xl border border-border-subtle p-4 rounded-xl flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary">
                            <img alt="Courier Profile" class="w-full h-full object-cover" data-alt="A professional, friendly-looking delivery courier wearing a clean, premium laundry service uniform. The person is smiling confidently in a modern, brightly lit urban setting. The photography style is high-key with natural lighting, evoking a sense of hospitality and premium clinical reliability." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAGpcswVUeLVnoiWrSJ2NQdDkKXDFfumTMa_LEUDczKWCFwVUUSiYIJJC_83Era7T5XeRWFbw1k9vT3m-rPRQnQAtjYOlJgSbmNnm0WAYz7hPctzZZVW7ZHYk-D6Lx_Lp33lDyBZR0ijbeD2lDEV8shYwV-q9fOGHRltBYn--t58jrJcRLrU0MaN56At-6ujIkkFMfPAidHyevk7n6cLg6a1qLV0WgDsk_ey-secN6EzBDrxFBgK4a0gormdS7cOAyQQVlKrNNze94" />
                        </div>
                        <div>
                            <p class="font-label-caps text-[10px] text-on-surface-variant">YOUR COURIER</p>
                            <p class="font-body-sm font-bold">Marcus Chen</p>
                            <div class="flex items-center gap-1 text-status-success">
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-[12px] font-bold">4.9</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right: Support & Summary -->
            <div class="lg:col-span-4 space-y-gutter">
                <!-- Chat with Support -->
                <div class="bg-primary-container text-on-primary-container rounded-xl p-8 shadow-lg shadow-primary-container/20">
                    <h3 class="font-headline-md text-headline-md mb-2">Need assistance?</h3>
                    <p class="font-body-sm mb-6 opacity-80">Our support team is online and ready to help with order LT-94021-X.</p>
                    <button class="w-full bg-on-primary text-primary font-bold py-4 rounded-full flex items-center justify-center gap-3 hover:opacity-90 active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
                        Chat with Support
                    </button>
                </div>
                <!-- Order Content Summary -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6">
                    <h4 class="font-label-caps text-label-caps text-on-surface-variant mb-6">ORDER SUMMARY</h4>
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">check_circle</span>
                                <span class="font-body-sm">Dress Shirts (x5)</span>
                            </div>
                            <span class="font-data-mono text-body-sm">$15.00</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">check_circle</span>
                                <span class="font-body-sm">Casual Trousers (x3)</span>
                            </div>
                            <span class="font-data-mono text-body-sm">$12.00</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">check_circle</span>
                                <span class="font-body-sm">Bedsheets (King)</span>
                            </div>
                            <span class="font-data-mono text-body-sm">$10.00</span>
                        </li>
                        <div class="h-px bg-border-subtle my-2"></div>
                        <li class="flex justify-between items-center font-bold">
                            <span class="font-body-sm">Total Paid</span>
                            <span class="font-data-mono text-body-lg text-primary">$37.00</span>
                        </li>
                    </ul>
                </div>
                <!-- Tip Card -->
                <div class="bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-xl p-6 flex gap-4 items-start border border-tertiary-container/10">
                    <span class="material-symbols-outlined text-tertiary-container mt-1">info</span>
                    <div>
                        <p class="font-label-caps text-[10px]">PRO TIP</p>
                        <p class="font-body-sm">You can change your delivery slot up to 2 hours before the scheduled time.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bottom Navigation Bar (Mobile only) -->
    <footer class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-surface-container-lowest border-t border-border-subtle shadow-lg flex justify-around items-center px-4 py-2">
        <a class="flex flex-col items-center justify-center text-on-surface-variant py-2" href="#">
            <span class="material-symbols-outlined">home</span>
            <span class="font-label-caps text-[10px]">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant py-2" href="#">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-caps text-[10px]">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1" href="#">
            <span class="material-symbols-outlined">query_stats</span>
            <span class="font-label-caps text-[10px]">Track</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant py-2" href="#">
            <span class="material-symbols-outlined">chat</span>
            <span class="font-label-caps text-[10px]">Chat</span>
        </a>
    </footer>
</body>

</html>