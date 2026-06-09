<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Financial Management | LaundryTrack</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-high": "#e7e7f5",
                        "on-primary-fixed": "#001452",
                        "surface-container-lowest": "#ffffff",
                        "secondary": "#565e74",
                        "border-subtle": "#E2E8F0",
                        "surface-tint": "#004ced",
                        "primary-fixed": "#dde1ff",
                        "primary-fixed-dim": "#b7c4ff",
                        "error-container": "#ffdad6",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-surface": "#191b25",
                        "surface-container-low": "#f3f2ff",
                        "on-primary-container": "#dfe3ff",
                        "inverse-primary": "#b7c4ff",
                        "secondary-fixed": "#dae2fd",
                        "primary": "#003ec7",
                        "tertiary-fixed": "#ffdbd2",
                        "status-success": "#10B981",
                        "tertiary-fixed-dim": "#ffb4a1",
                        "tertiary-container": "#bf3003",
                        "background": "#fbf8ff",
                        "surface-dim": "#d9d9e7",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "inverse-on-surface": "#f0effe",
                        "on-primary": "#ffffff",
                        "surface-variant": "#e1e1ef",
                        "surface-bright": "#fbf8ff",
                        "surface-wash": "#F8FAFC",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#0038b6",
                        "on-tertiary-fixed": "#3c0800",
                        "error": "#ba1a1a",
                        "inverse-surface": "#2e303a",
                        "primary-container": "#0052ff",
                        "on-tertiary-container": "#ffddd5",
                        "outline-variant": "#c3c5d9",
                        "on-secondary-container": "#5c647a",
                        "on-tertiary-fixed-variant": "#891e00",
                        "on-error-container": "#93000a",
                        "on-background": "#191b25",
                        "on-secondary": "#ffffff",
                        "on-surface-variant": "#434656",
                        "secondary-container": "#dae2fd",
                        "surface": "#fbf8ff",
                        "outline": "#737688",
                        "tertiary": "#952200",
                        "surface-container": "#ededfb",
                        "on-secondary-fixed": "#131b2e",
                        "surface-container-highest": "#e1e1ef",
                        "status-error": "#EF4444",
                        "status-progress": "#F59E0B"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "gutter": "24px",
                        "section-padding": "48px",
                        "base": "8px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "label-caps": ["Inter"],
                        "headline-lg": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "display": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"]
                    },
                    "fontSize": {
                        "label-caps": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "data-mono": ["13px", {
                            "lineHeight": "16px",
                            "fontWeight": "500"
                        }],
                        "display": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
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
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "600"
                        }]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            background-color: #F8FAFC;
        }
    </style>
</head>

<body class="font-body-lg text-body-lg text-on-surface">
    <!-- TopNavBar -->
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-gutter h-16 max-w-container-max mx-auto bg-surface border-b border-border-subtle">
        <div class="flex items-center gap-8">
            <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
            <nav class="hidden md:flex gap-6">
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Dashboard</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Orders</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Inventory</a>
                <a class="text-primary font-bold border-b-2 border-primary pb-1" href="#">Financials</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Marketing</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-all duration-200 active:scale-95">notifications</button>
            <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-all duration-200 active:scale-95">settings</button>
            <div class="h-8 w-8 rounded-full bg-surface-container-high overflow-hidden border border-border-subtle">
                <img alt="Owner Profile" data-alt="A professional headshot of a business owner in a modern, brightly lit office environment. The individual is smiling warmly, conveying reliability and expertise. The lighting is soft and high-key, matching a premium hospitality aesthetic with a clean, clinical yet inviting background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBIOqoP8xDDx31cjdoWlJ8DjatqPrPv2PQB9oWFSQIysaVoYnLxCVoAQGZi3KHSkpIiBG2qrsFTI97E32_oejfkv7WiTJd_Uvwor00_QUQPkNTJ45X-u4WWITG2y8HG9V1T9ma1fseeH_C64YFCIUmAlPfwf9F-Ej8QK5cey_e3v5oQ1M-jlXXEspGMFndz49a1TVL9qA1dZX2zcbM2MQmtscYipyCv_-I2QBzI6QdifAuv0hVAHYHaCIHcfK6H2G9xPzw7ar4KlHE" />
            </div>
            <button class="bg-primary text-on-primary px-5 py-2.5 rounded-lg font-label-caps text-label-caps hover:bg-primary-container transition-all active:scale-95">New Order</button>
        </div>
    </header>
    <!-- Sidebar (Desktop) -->
    <aside class="hidden lg:flex flex-col fixed left-0 top-16 h-[calc(100vh-64px)] w-64 p-4 gap-2 bg-surface-container-low border-r border-border-subtle">
        <div class="px-4 py-6">
            <h2 class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest">Management Suite</h2>
        </div>
        <nav class="flex flex-col gap-1">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-label-caps text-label-caps">Overview</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Order Queue</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="font-label-caps text-label-caps">Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">sell</span>
                <span class="font-label-caps text-label-caps">Price Lists</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-bold rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">payments</span>
                <span class="font-label-caps text-label-caps">Payment Tracking</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-label-caps text-label-caps">Reports</span>
            </a>
        </nav>
        <div class="mt-auto border-t border-border-subtle pt-4">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">help</span>
                <span class="font-label-caps text-label-caps">Support</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
        </div>
    </aside>
    <!-- Main Content Canvas -->
    <main class="lg:ml-64 pt-16 pb-24 lg:pb-12 px- gutter">
        <div class="max-w-container-max mx-auto py-section-padding">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
                <div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface mb-2">Financial Management</h1>
                    <p class="text-on-surface-variant font-body-lg">Real-time performance metrics and detailed transaction logs.</p>
                </div>
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 px-4 py-2 border border-border-subtle rounded-lg bg-surface hover:bg-surface-container-low transition-colors font-label-caps text-label-caps">
                        <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                        Last 30 Days
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-lg hover:opacity-90 transition-opacity font-label-caps text-label-caps">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                        Export Report
                    </button>
                </div>
            </div>
            <!-- Bento Grid: Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-surface p-6 rounded-xl border border-border-subtle relative overflow-hidden">
                    <div class="absolute left-0 top-0 w-1 h-full bg-primary"></div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Total Revenue</span>
                        <span class="text-status-success font-label-caps text-label-caps flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">trending_up</span> +12.5%
                        </span>
                    </div>
                    <div class="font-display text-[32px] font-bold text-on-surface mb-1">$42,850.00</div>
                    <div class="text-on-surface-variant font-body-sm">vs $38,100.00 last month</div>
                </div>
                <!-- Net Profit -->
                <div class="bg-surface p-6 rounded-xl border border-border-subtle relative overflow-hidden">
                    <div class="absolute left-0 top-0 w-1 h-full bg-status-success"></div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Net Profit</span>
                        <span class="text-status-success font-label-caps text-label-caps flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">trending_up</span> +8.2%
                        </span>
                    </div>
                    <div class="font-display text-[32px] font-bold text-on-surface mb-1">$14,210.50</div>
                    <div class="text-on-surface-variant font-body-sm">33.2% Margin</div>
                </div>
                <!-- Expenses -->
                <div class="bg-surface p-6 rounded-xl border border-border-subtle relative overflow-hidden">
                    <div class="absolute left-0 top-0 w-1 h-full bg-status-error"></div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Expenses</span>
                        <span class="text-status-error font-label-caps text-label-caps flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">trending_down</span> -2.4%
                        </span>
                    </div>
                    <div class="font-display text-[32px] font-bold text-on-surface mb-1">$28,639.50</div>
                    <div class="text-on-surface-variant font-body-sm">Includes $4k utilities</div>
                </div>
            </div>
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue Trends (Line Chart Mockup) -->
                <div class="bg-surface p-8 rounded-xl border border-border-subtle">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-headline-md text-headline-md">Revenue Trends</h3>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-primary"></span>
                                <span class="font-label-caps text-label-caps">Current</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-outline-variant"></span>
                                <span class="font-label-caps text-label-caps text-on-surface-variant">Previous</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64 flex items-end gap-2 relative border-l border-b border-border-subtle pb-4 pl-4">
                        <!-- Chart Lines (Stylized with Gradients/Tailwind) -->
                        <div class="absolute inset-x-4 bottom-4 top-0 flex flex-col justify-between pointer-events-none opacity-20">
                            <div class="w-full h-[1px] bg-outline-variant"></div>
                            <div class="w-full h-[1px] bg-outline-variant"></div>
                            <div class="w-full h-[1px] bg-outline-variant"></div>
                            <div class="w-full h-[1px] bg-outline-variant"></div>
                        </div>
                        <div class="flex-1 h-full flex items-end justify-around">
                            <div class="w-3 h-3/4 bg-primary/10 rounded-t-sm relative group cursor-pointer">
                                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-on-surface text-surface px-2 py-1 rounded text-[10px] hidden group-hover:block">$12k</div>
                                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-primary rounded-t-sm"></div>
                            </div>
                            <div class="w-3 h-4/5 bg-primary/10 rounded-t-sm relative group cursor-pointer">
                                <div class="absolute inset-x-0 bottom-0 h-2/3 bg-primary rounded-t-sm"></div>
                            </div>
                            <div class="w-3 h-1/2 bg-primary/10 rounded-t-sm relative group cursor-pointer">
                                <div class="absolute inset-x-0 bottom-0 h-1/3 bg-primary rounded-t-sm"></div>
                            </div>
                            <div class="w-3 h-full bg-primary/10 rounded-t-sm relative group cursor-pointer">
                                <div class="absolute inset-x-0 bottom-0 h-4/5 bg-primary rounded-t-sm"></div>
                            </div>
                            <div class="w-3 h-2/3 bg-primary/10 rounded-t-sm relative group cursor-pointer">
                                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-primary rounded-t-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Expense Allocation (Bar Chart Mockup) -->
                <div class="bg-surface p-8 rounded-xl border border-border-subtle">
                    <h3 class="font-headline-md text-headline-md mb-8">Expense Allocation</h3>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <div class="flex justify-between font-label-caps text-label-caps">
                                <span>Salaries &amp; Wages</span>
                                <span>$12,400 (43%)</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-primary w-[43%]"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between font-label-caps text-label-caps">
                                <span>Logistics &amp; Fuel</span>
                                <span>$6,800 (24%)</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-status-progress w-[24%]"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between font-label-caps text-label-caps">
                                <span>Utilities</span>
                                <span>$5,100 (18%)</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-secondary w-[18%]"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between font-label-caps text-label-caps">
                                <span>Cleaning Supplies</span>
                                <span>$4,339 (15%)</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-tertiary w-[15%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Transactions Table -->
            <div class="bg-surface rounded-xl border border-border-subtle overflow-hidden">
                <div class="p-6 border-b border-border-subtle flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-6 w-full">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <h3 class="font-headline-md text-headline-md">Recent Transactions</h3>
                            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto"><button class="px-4 py-1.5 rounded-full bg-primary-container text-on-primary-container font-label-caps text-label-caps">All</button><button class="px-4 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container-high font-label-caps text-label-caps transition-colors">Completed</button><button class="px-4 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container-high font-label-caps text-label-caps transition-colors">Pending</button><button class="px-4 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container-high font-label-caps text-label-caps transition-colors">Refunded</button></div>
                        </div>
                        <div class="flex flex-col lg:flex-row items-center gap-4 w-full pt-4 border-t border-border-subtle">
                            <div class="relative flex-1 w-full"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span><input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary text-body-sm" placeholder="Search transactions..." type="text" /></div>
                            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                                <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-lg border border-border-subtle w-full sm:w-auto"><span class="text-[12px] font-label-caps text-on-surface-variant">From:</span><input class="bg-transparent border-none focus:ring-0 text-sm p-0 w-full sm:w-32" type="date" /></div>
                                <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-lg border border-border-subtle w-full sm:w-auto"><span class="text-[12px] font-label-caps text-on-surface-variant">To:</span><input class="bg-transparent border-none focus:ring-0 text-sm p-0 w-full sm:w-32" type="date" /></div><button class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps hover:opacity-90 transition-opacity whitespace-nowrap w-full sm:w-auto">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-border-subtle">
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Order ID</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Customer</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Date</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Amount</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Status</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle">
                            <!-- Row 1 -->
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-6 py-4 font-data-mono text-primary">#TRK-8821</td>
                                <td class="px-6 py-4 font-medium">Alex Rivera</td>
                                <td class="px-6 py-4 text-on-surface-variant text-sm">Oct 24, 2024</td>
                                <td class="px-6 py-4 font-bold">$124.50</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-status-success/10 text-status-success uppercase">Completed</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined">more_vert</button>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-6 py-4 font-data-mono text-primary">#TRK-8822</td>
                                <td class="px-6 py-4 font-medium">Elena Belova</td>
                                <td class="px-6 py-4 text-on-surface-variant text-sm">Oct 24, 2024</td>
                                <td class="px-6 py-4 font-bold">$45.00</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-status-progress/10 text-status-progress uppercase">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined">more_vert</button>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-6 py-4 font-data-mono text-primary">#TRK-8823</td>
                                <td class="px-6 py-4 font-medium">Jordan Smith</td>
                                <td class="px-6 py-4 text-on-surface-variant text-sm">Oct 23, 2024</td>
                                <td class="px-6 py-4 font-bold">$210.00</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-status-success/10 text-status-success uppercase">Completed</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined">more_vert</button>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-6 py-4 font-data-mono text-primary">#TRK-8824</td>
                                <td class="px-6 py-4 font-medium">Marcus Thorne</td>
                                <td class="px-6 py-4 text-on-surface-variant text-sm">Oct 23, 2024</td>
                                <td class="px-6 py-4 font-bold">$89.99</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-status-error/10 text-status-error uppercase">Refunded</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined">more_vert</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-border-subtle bg-surface-container-lowest flex justify-between items-center">
                    <span class="text-sm text-on-surface-variant">Showing 4 of 240 transactions</span>
                    <div class="flex gap-2">
                        <button class="p-2 border border-border-subtle rounded hover:bg-surface-container-low disabled:opacity-50" disabled="">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>
                        <button class="p-2 border border-border-subtle rounded hover:bg-surface-container-low">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- BottomNavBar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface border-t border-border-subtle rounded-t-xl shadow-sm">
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">storefront</span>
            <span class="font-label-caps text-label-caps">Shops</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-caps text-label-caps">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span class="font-label-caps text-label-caps">Chat</span>
        </a>
        <a class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1" href="#">
            <span class="material-symbols-outlined">payments</span>
            <span class="font-label-caps text-label-caps">Finance</span>
        </a>
    </nav>
    <!-- Footer -->
    <footer class="w-full py-12 px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto border-t border-border-subtle bg-surface-container-highest">
        <div class="mb-6 md:mb-0">
            <span class="font-headline-md text-headline-md font-bold text-on-surface">LaundryTrack</span>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">© 2024 LaundryTrack Logistics. All rights reserved.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Terms of Service</a>
            <a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Contact Support</a>
            <a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Merchant Portal</a>
        </div>
    </footer>
</body>

</html>