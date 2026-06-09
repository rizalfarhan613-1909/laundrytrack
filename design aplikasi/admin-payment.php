<!DOCTYPE html>

<html lang="en">

<head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        display: inline-block;
                        vertical-align: middle;
                }
        </style>
</head>

<body class="bg-surface-wash text-on-surface font-body-lg overflow-x-hidden">
        <!-- TopNavBar -->
        <nav class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-gutter h-16 max-w-container-max mx-auto bg-surface border-b border-border-subtle">
                <div class="flex items-center gap-8">
                        <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
                        <div class="hidden md:flex gap-6 items-center">
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Dashboard</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Orders</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Inventory</a>
                                <a class="text-primary font-bold border-b-2 border-primary pb-1" href="#">Financials</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors" href="#">Marketing</a>
                        </div>
                </div>
                <div class="flex items-center gap-4">
                        <div class="hidden lg:flex items-center bg-surface-container px-3 py-1.5 rounded-lg border border-border-subtle">
                                <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                                <input class="bg-transparent border-none focus:ring-0 text-body-sm w-48" placeholder="Search transactions..." type="text" />
                        </div>
                        <button class="material-symbols-outlined text-on-surface-variant cursor-pointer transition-all active:scale-95">notifications</button>
                        <button class="material-symbols-outlined text-on-surface-variant cursor-pointer transition-all active:scale-95">settings</button>
                        <div class="w-8 h-8 rounded-full bg-primary-fixed overflow-hidden border border-border-subtle">
                                <img alt="Owner Profile" data-alt="A professional close-up headshot of a business owner in a clean, high-key office environment. The lighting is soft and directional, emphasizing a reliable and clinical look. The color palette is composed of soft blues, whites, and neutral grays, maintaining a premium hospitality-driven aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC90Zex9_uejr0lgo92geBJy2YLVfd1wEuB-R_QDDKeblFfvZ1QRz9JjEzmW9vbMm8UnnYjZuQ6NxJVHcJqRUDSMw25yEkTlIQPDta0xV5g8UASyYa5QXoUvSDUQHRfjb4N2PTFn0DIPFE76eYEkkraYiA3YaNCrJs_ygV1jP3NzVHXauXAdHgFHk6HmemrB8e-UqoJZawxHR_y5F8PMRJ5fO25Wfw3YqpQMMhw2AOi42FLLSNZMqziJBcJxvmZkNj47TuupOmy3hE" />
                        </div>
                </div>
        </nav>
        <div class="flex min-h-screen pt-16">
                <!-- SideNavBar -->
                <aside class="hidden lg:flex flex-col h-[calc(100vh-64px)] w-64 p-4 gap-2 bg-surface-container-low border-r border-border-subtle fixed left-0">
                        <div class="px-2 py-4">
                                <h2 class="font-headline-md text-headline-md font-black text-primary">LaundryTrack</h2>
                                <p class="font-label-caps text-label-caps text-on-surface-variant">Management Suite</p>
                        </div>
                        <nav class="flex flex-col gap-1 mt-4">
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">dashboard</span>
                                        <span class="font-label-caps text-label-caps uppercase">Overview</span>
                                </a>
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">local_laundry_service</span>
                                        <span class="font-label-caps text-label-caps uppercase">Order Queue</span>
                                </a>
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">inventory_2</span>
                                        <span class="font-label-caps text-label-caps uppercase">Inventory</span>
                                </a>
                                <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-bold rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">payments</span>
                                        <span class="font-label-caps text-label-caps uppercase">Payment Tracking</span>
                                </a>
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">analytics</span>
                                        <span class="font-label-caps text-label-caps uppercase">Reports</span>
                                </a>
                        </nav>
                        <div class="mt-auto flex flex-col gap-1 border-t border-border-subtle pt-4">
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">help</span>
                                        <span class="font-label-caps text-label-caps uppercase">Support</span>
                                </a>
                                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span class="font-label-caps text-label-caps uppercase">Settings</span>
                                </a>
                        </div>
                </aside>
                <!-- Main Content -->
                <main class="flex-1 lg:ml-64 p-gutter max-w-container-max mx-auto w-full">
                        <!-- Header Section -->
                        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                                <div>
                                        <h1 class="font-headline-lg text-headline-lg text-on-surface">Payment Management</h1>
                                        <p class="text-on-surface-variant font-body-lg">Track and manage your branch revenue and payouts.</p>
                                </div>
                                <div class="flex gap-3">
                                        <button class="px-5 py-2.5 bg-surface border border-border-subtle text-on-surface font-label-caps uppercase flex items-center gap-2 hover:bg-surface-container transition-colors">
                                                <span class="material-symbols-outlined text-sm">download</span> Export CSV
                                        </button>
                                        <button class="px-5 py-2.5 bg-primary text-on-primary font-label-caps uppercase flex items-center gap-2 transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-outlined text-sm">add</span> New Order
                                        </button>
                                </div>
                        </header>
                        <!-- Summary Bento Grid -->
                        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                                <!-- Pending Settlements Card -->
                                <div class="bg-surface border border-border-subtle p-6 flex flex-col justify-between relative overflow-hidden">
                                        <div class="absolute top-0 left-0 w-1 h-full bg-status-progress"></div>
                                        <div>
                                                <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Pending Settlements</span>
                                                <div class="flex items-baseline gap-2 mt-2">
                                                        <h3 class="font-display text-display text-on-surface">$12,450.80</h3>
                                                </div>
                                        </div>
                                        <div class="mt-4 flex items-center text-status-progress font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-sm mr-1">schedule</span> 14 transactions waiting
                                        </div>
                                </div>
                                <!-- Daily Payouts Card -->
                                <div class="bg-surface border border-border-subtle p-6 flex flex-col justify-between relative overflow-hidden">
                                        <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
                                        <div>
                                                <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Daily Payouts</span>
                                                <div class="flex items-baseline gap-2 mt-2">
                                                        <h3 class="font-display text-display text-on-surface">$3,820.00</h3>
                                                </div>
                                        </div>
                                        <div class="mt-4 flex items-center text-status-success font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-sm mr-1">check_circle</span> Scheduled for 6:00 PM
                                        </div>
                                </div>
                                <!-- Quick Stats -->
                                <div class="bg-surface-container-low border border-border-subtle p-6">
                                        <div class="flex flex-col gap-4">
                                                <div class="flex justify-between items-center">
                                                        <span class="font-body-sm text-on-surface-variant">Success Rate</span>
                                                        <span class="font-data-mono text-status-success">99.2%</span>
                                                </div>
                                                <div class="h-1.5 w-full bg-surface-container-high overflow-hidden">
                                                        <div class="h-full bg-status-success" style="width: 99.2%"></div>
                                                </div>
                                                <div class="flex justify-between items-center">
                                                        <span class="font-body-sm text-on-surface-variant">Average Ticket</span>
                                                        <span class="font-data-mono text-on-surface">$42.50</span>
                                                </div>
                                                <div class="flex justify-between items-center">
                                                        <span class="font-body-sm text-on-surface-variant">Refunds (24h)</span>
                                                        <span class="font-data-mono text-status-error">$0.00</span>
                                                </div>
                                        </div>
                                </div>
                        </section>
                        <!-- Filters & Search -->
                        <div class="flex flex-col lg:flex-row gap-4 mb-6 items-center justify-between">
                                <div class="flex items-center gap-4 w-full lg:w-auto">
                                        <div class="relative flex-1 lg:w-80">
                                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                                                <input class="w-full pl-10 pr-4 py-2 bg-surface border border-border-subtle focus:border-primary focus:ring-0 font-body-sm transition-colors" placeholder="Filter by ID or Name..." type="text" />
                                        </div>
                                        <button class="flex items-center gap-2 px-4 py-2 border border-border-subtle bg-surface text-on-surface-variant font-label-caps uppercase">
                                                <span class="material-symbols-outlined text-sm">filter_list</span> Filters
                                        </button>
                                </div>
                                <div class="flex items-center gap-2 bg-surface border border-border-subtle p-1">
                                        <button class="px-4 py-1.5 bg-primary-container text-on-primary-container font-label-caps uppercase">All</button>
                                        <button class="px-4 py-1.5 text-on-surface-variant font-label-caps uppercase hover:bg-surface-container transition-colors">Completed</button>
                                        <button class="px-4 py-1.5 text-on-surface-variant font-label-caps uppercase hover:bg-surface-container transition-colors">Processing</button>
                                </div>
                        </div>
                        <!-- Transaction Spreadsheet UI -->
                        <div class="bg-surface border border-border-subtle overflow-hidden">
                                <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                                <thead>
                                                        <tr class="bg-surface-container-low border-b border-border-subtle">
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Order ID</th>
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Customer</th>
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Method</th>
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Date/Time</th>
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase text-right">Amount</th>
                                                                <th class="p-4 font-label-caps text-label-caps text-on-surface-variant uppercase text-center">Settlement</th>
                                                                <th class="p-4"></th>
                                                        </tr>
                                                </thead>
                                                <tbody class="divide-y divide-border-subtle">
                                                        <!-- Row 1 -->
                                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                                                <td class="p-4 font-data-mono text-primary">#LT-8921-X</td>
                                                                <td class="p-4 font-body-lg text-on-surface font-medium">Alexander Wright</td>
                                                                <td class="p-4">
                                                                        <div class="flex items-center gap-2">
                                                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">credit_card</span>
                                                                                <span class="text-body-sm">Visa **** 4492</span>
                                                                        </div>
                                                                </td>
                                                                <td class="p-4 text-on-surface-variant text-body-sm">Oct 24, 2024 • 14:32</td>
                                                                <td class="p-4 text-right font-data-mono font-bold">$124.50</td>
                                                                <td class="p-4 text-center">
                                                                        <span class="px-2 py-1 bg-status-success/10 text-status-success font-label-caps text-[10px] rounded-full uppercase">Settled</span>
                                                                </td>
                                                                <td class="p-4 text-right">
                                                                        <button class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">more_vert</button>
                                                                </td>
                                                        </tr>
                                                        <!-- Row 2 -->
                                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                                                <td class="p-4 font-data-mono text-primary">#LT-8922-A</td>
                                                                <td class="p-4 font-body-lg text-on-surface font-medium">Elena Rodriguez</td>
                                                                <td class="p-4">
                                                                        <div class="flex items-center gap-2">
                                                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">account_balance_wallet</span>
                                                                                <span class="text-body-sm">Apple Pay</span>
                                                                        </div>
                                                                </td>
                                                                <td class="p-4 text-on-surface-variant text-body-sm">Oct 24, 2024 • 15:10</td>
                                                                <td class="p-4 text-right font-data-mono font-bold">$45.00</td>
                                                                <td class="p-4 text-center">
                                                                        <span class="px-2 py-1 bg-status-progress/10 text-status-progress font-label-caps text-[10px] rounded-full uppercase">Processing</span>
                                                                </td>
                                                                <td class="p-4 text-right">
                                                                        <button class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">more_vert</button>
                                                                </td>
                                                        </tr>
                                                        <!-- Row 3 -->
                                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                                                <td class="p-4 font-data-mono text-primary">#LT-8923-B</td>
                                                                <td class="p-4 font-body-lg text-on-surface font-medium">Marcus Chen</td>
                                                                <td class="p-4">
                                                                        <div class="flex items-center gap-2">
                                                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">payments</span>
                                                                                <span class="text-body-sm">Cash</span>
                                                                        </div>
                                                                </td>
                                                                <td class="p-4 text-on-surface-variant text-body-sm">Oct 24, 2024 • 15:45</td>
                                                                <td class="p-4 text-right font-data-mono font-bold">$18.20</td>
                                                                <td class="p-4 text-center">
                                                                        <span class="px-2 py-1 bg-on-surface-variant/10 text-on-surface-variant font-label-caps text-[10px] rounded-full uppercase">On-Hand</span>
                                                                </td>
                                                                <td class="p-4 text-right">
                                                                        <button class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">more_vert</button>
                                                                </td>
                                                        </tr>
                                                        <!-- Row 4 -->
                                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                                                <td class="p-4 font-data-mono text-primary">#LT-8924-M</td>
                                                                <td class="p-4 font-body-lg text-on-surface font-medium">Sarah Jenkins</td>
                                                                <td class="p-4">
                                                                        <div class="flex items-center gap-2">
                                                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">credit_card</span>
                                                                                <span class="text-body-sm">Mastercard **** 0012</span>
                                                                        </div>
                                                                </td>
                                                                <td class="p-4 text-on-surface-variant text-body-sm">Oct 24, 2024 • 16:20</td>
                                                                <td class="p-4 text-right font-data-mono font-bold">$210.00</td>
                                                                <td class="p-4 text-center">
                                                                        <span class="px-2 py-1 bg-status-success/10 text-status-success font-label-caps text-[10px] rounded-full uppercase">Settled</span>
                                                                </td>
                                                                <td class="p-4 text-right">
                                                                        <button class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">more_vert</button>
                                                                </td>
                                                        </tr>
                                                        <!-- Row 5 -->
                                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                                                <td class="p-4 font-data-mono text-primary">#LT-8925-P</td>
                                                                <td class="p-4 font-body-lg text-on-surface font-medium">David Miller</td>
                                                                <td class="p-4">
                                                                        <div class="flex items-center gap-2">
                                                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">account_balance_wallet</span>
                                                                                <span class="text-body-sm">G-Wallet</span>
                                                                        </div>
                                                                </td>
                                                                <td class="p-4 text-on-surface-variant text-body-sm">Oct 24, 2024 • 16:55</td>
                                                                <td class="p-4 text-right font-data-mono font-bold">$32.75</td>
                                                                <td class="p-4 text-center">
                                                                        <span class="px-2 py-1 bg-status-progress/10 text-status-progress font-label-caps text-[10px] rounded-full uppercase">Processing</span>
                                                                </td>
                                                                <td class="p-4 text-right">
                                                                        <button class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">more_vert</button>
                                                                </td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                </div>
                                <!-- Pagination -->
                                <div class="p-4 border-t border-border-subtle flex items-center justify-between">
                                        <span class="text-body-sm text-on-surface-variant">Showing 1 to 5 of 1,240 entries</span>
                                        <div class="flex items-center gap-2">
                                                <button class="p-1 border border-border-subtle text-on-surface-variant hover:bg-surface-container transition-colors disabled:opacity-50" disabled="">
                                                        <span class="material-symbols-outlined">chevron_left</span>
                                                </button>
                                                <button class="w-8 h-8 flex items-center justify-center bg-primary text-on-primary font-data-mono">1</button>
                                                <button class="w-8 h-8 flex items-center justify-center text-on-surface font-data-mono hover:bg-surface-container transition-colors">2</button>
                                                <button class="w-8 h-8 flex items-center justify-center text-on-surface font-data-mono hover:bg-surface-container transition-colors">3</button>
                                                <button class="p-1 border border-border-subtle text-on-surface-variant hover:bg-surface-container transition-colors">
                                                        <span class="material-symbols-outlined">chevron_right</span>
                                                </button>
                                        </div>
                                </div>
                        </div>
                </main>
        </div>
        <!-- Footer -->
        <footer class="w-full py-12 px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto border-t border-border-subtle bg-surface-container-highest">
                <div class="mb-6 md:mb-0">
                        <span class="font-headline-md text-headline-md font-bold text-on-surface">LaundryTrack Logistics</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">© 2024 LaundryTrack Logistics. All rights reserved.</p>
                </div>
                <div class="flex gap-8">
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Contact Support</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Merchant Portal</a>
                </div>
        </footer>
        <!-- BottomNavBar (Mobile Only) -->
        <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface border-t border-border-subtle rounded-t-xl shadow-sm">
                <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
                        <span class="material-symbols-outlined">storefront</span>
                        <span class="font-label-caps text-[10px] uppercase">Shops</span>
                </a>
                <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <span class="font-label-caps text-[10px] uppercase">Orders</span>
                </a>
                <a class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1" href="#">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="font-label-caps text-[10px] uppercase">Financials</span>
                </a>
                <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
                        <span class="material-symbols-outlined">person</span>
                        <span class="font-label-caps text-[10px] uppercase">Profile</span>
                </a>
        </nav>
</body>

</html>