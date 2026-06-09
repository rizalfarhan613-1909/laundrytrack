<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
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
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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

<body class="bg-surface text-on-surface font-body-lg text-body-lg selection:bg-primary-fixed selection:text-on-primary-fixed">
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-gutter h-16 max-w-container-max mx-auto bg-surface border-b border-border-subtle">
        <div class="flex items-center gap-8">
            <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
            <nav class="hidden md:flex items-center gap-6">
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors cursor-pointer transition-all duration-200 active:scale-95" href="#">Dashboard</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors cursor-pointer transition-all duration-200 active:scale-95" href="#">Orders</a>
                <a class="text-primary font-bold border-b-2 border-primary pb-1 cursor-pointer transition-all duration-200 active:scale-95" href="#">Inventory</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors cursor-pointer transition-all duration-200 active:scale-95" href="#">Financials</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors cursor-pointer transition-all duration-200 active:scale-95" href="#">Marketing</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden lg:flex items-center bg-surface-container px-3 py-1.5 rounded-full border border-border-subtle">
                <span class="material-symbols-outlined text-[20px] text-outline mr-2" data-icon="search">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-body-sm font-body-sm w-48" placeholder="Search resources..." type="text" />
            </div>
            <button class="material-symbols-outlined p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" data-icon="notifications">notifications</button>
            <button class="material-symbols-outlined p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" data-icon="settings">settings</button>
            <button class="bg-primary text-on-primary px-5 py-2 rounded-lg font-label-caps text-label-caps hover:bg-primary-container transition-colors active:scale-95">New Order</button>
        </div>
    </header>
    <aside class="hidden lg:flex flex-col h-screen fixed left-0 top-16 w-64 p-4 gap-2 border-r border-border-subtle bg-surface-container-low">
        <div class="px-4 py-6 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
                    <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md font-black text-primary leading-none">LaundryTrack</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Management Suite</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-label-caps text-label-caps">Overview</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Order Queue</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-bold rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                <span class="font-label-caps text-label-caps">Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="sell">sell</span>
                <span class="font-label-caps text-label-caps">Price Lists</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="payments">payments</span>
                <span class="font-label-caps text-label-caps">Payment Tracking</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                <span class="font-label-caps text-label-caps">Reports</span>
            </a>
        </nav>
        <button class="mt-auto flex items-center justify-center gap-2 w-full py-3 px-4 border border-primary text-primary font-label-caps text-label-caps rounded-lg hover:bg-primary-fixed transition-colors mb-4">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            Add New Branch
        </button>
        <div class="border-t border-border-subtle pt-4 space-y-1">
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                <span class="material-symbols-outlined" data-icon="help">help</span>
                <span class="font-body-sm text-body-sm">Support</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-sm text-body-sm">Settings</span>
            </a>
        </div>
    </aside>
    <main class="lg:pl-64 pt-16 min-h-screen">
        <div class="max-w-container-max mx-auto p-gutter lg:p-12">
            <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <nav class="flex items-center gap-2 text-on-surface-variant mb-2">
                        <span class="font-label-caps text-label-caps">Admin</span>
                        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
                        <span class="font-label-caps text-label-caps text-primary">Inventory &amp; Pricing</span>
                    </nav>
                    <h1 class="font-display text-display tracking-tight text-on-surface">Resource Management</h1>
                </div>
                <div class="flex items-center gap-3 p-1 bg-surface-container rounded-xl">
                    <button class="px-6 py-2 bg-surface text-primary font-label-caps text-label-caps rounded-lg shadow-sm">Inventory</button>
                    <button class="px-6 py-2 text-on-surface-variant font-label-caps text-label-caps rounded-lg hover:bg-surface-container-high transition-colors">Pricing Lists</button>
                </div>
            </header>
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden">
                        <div class="p-6 border-b border-border-subtle flex justify-between items-center bg-surface-wash">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Stock Levels</h3>
                            <div class="flex gap-2">
                                <button class="p-2 border border-border-subtle rounded-lg hover:bg-surface-container transition-colors">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="filter_list">filter_list</span>
                                </button>
                                <button class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2 active:scale-95 transition-transform">
                                    <span class="material-symbols-outlined text-[18px]" data-icon="add">add</span>
                                    Add Stock Item
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto no-scrollbar">
                            <table class="w-full text-left">
                                <thead class="bg-surface-container-low border-b border-border-subtle">
                                    <tr>
                                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Resource Name</th>
                                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Current Level</th>
                                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Threshold</th>
                                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase">Status</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-subtle">
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-primary text-[18px]" data-icon="sanitizer">sanitizer</span>
                                                </div>
                                                <div>
                                                    <p class="font-body-lg text-body-lg font-medium">Premium Detergent XL</p>
                                                    <p class="text-[12px] text-on-surface-variant font-data-mono">SKU: DET-0912-PR</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface">14.2 Liters</td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface-variant">25.0 Liters</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-status-error/10 text-status-error">
                                                Low Stock
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <button class="text-primary font-label-caps text-label-caps hover:underline">Restock</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-primary text-[18px]" data-icon="opacity">opacity</span>
                                                </div>
                                                <div>
                                                    <p class="font-body-lg text-body-lg font-medium">Soft-Care Fabric Softener</p>
                                                    <p class="text-[12px] text-on-surface-variant font-data-mono">SKU: SOF-4421-SC</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface">42.8 Liters</td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface-variant">10.0 Liters</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-status-success/10 text-status-success">
                                                Optimal
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <button class="text-on-surface-variant font-label-caps text-label-caps hover:text-primary">Manage</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-primary text-[18px]" data-icon="dry_cleaning">dry_cleaning</span>
                                                </div>
                                                <div>
                                                    <p class="font-body-lg text-body-lg font-medium">Wooden Hangers (Pack 50)</p>
                                                    <p class="text-[12px] text-on-surface-variant font-data-mono">SKU: HAN-WOD-01</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface">12 Units</td>
                                        <td class="px-6 py-5 font-data-mono text-on-surface-variant">15 Units</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-status-progress/10 text-status-progress">
                                                Reorder Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <button class="text-on-surface-variant font-label-caps text-label-caps hover:text-primary">Track</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden">
                        <div class="p-6 border-b border-border-subtle flex justify-between items-center bg-surface-wash">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Service Pricing</h3>
                            <button class="text-primary font-label-caps text-label-caps hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]" data-icon="edit_note">edit_note</span>
                                Bulk Edit Prices
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between p-4 border border-border-subtle rounded-lg hover:border-primary transition-colors cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-surface-container-high rounded-full flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-headline-md text-on-surface">Wash &amp; Fold</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Standard laundry service per KG</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-display text-headline-md text-primary">$4.50</p>
                                    <p class="font-label-caps text-[10px] text-on-surface-variant uppercase">Base Rate</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4 border border-border-subtle rounded-lg hover:border-primary transition-colors cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-surface-container-high rounded-full flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined" data-icon="iron">iron</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-headline-md text-on-surface">Professional Ironing</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Steam press per item</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-display text-headline-md text-primary">$2.75</p>
                                    <p class="font-label-caps text-[10px] text-on-surface-variant uppercase">Per Item</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4 border border-border-subtle rounded-xl bg-primary/5 border-primary/20">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container">
                                        <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-headline-md text-on-surface">Special Fabric Care</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Silk, Linen, &amp; Delicates</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2">
                                        <span class="font-body-sm text-body-sm text-on-surface-variant line-through">$12.00</span>
                                        <p class="font-display text-headline-md text-primary">$9.99</p>
                                    </div>
                                    <p class="font-label-caps text-[10px] text-status-success uppercase font-bold">Limited Promotion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-primary text-on-primary p-8 rounded-xl relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="material-symbols-outlined text-[40px] mb-4 opacity-80" data-icon="notification_important">notification_important</span>
                            <h4 class="font-headline-md text-headline-md mb-2">Critical Alerts</h4>
                            <p class="font-body-sm text-body-sm opacity-90 mb-6 leading-relaxed">
                                You have 2 inventory items currently below their critical threshold. Immediate action is required to avoid service disruption.
                            </p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between bg-white/10 p-3 rounded-lg border border-white/20">
                                    <span class="font-label-caps text-label-caps">Detergent</span>
                                    <span class="font-data-mono font-bold">14.2L / 25L</span>
                                </div>
                                <div class="flex items-center justify-between bg-white/10 p-3 rounded-lg border border-white/20">
                                    <span class="font-label-caps text-label-caps">Fabric Softener</span>
                                    <span class="font-data-mono font-bold">4.8L / 10L</span>
                                </div>
                            </div>
                            <button class="w-full mt-6 bg-white text-primary py-3 rounded-lg font-label-caps text-label-caps hover:bg-surface-wash transition-colors">
                                Quick Restock All
                            </button>
                        </div>
                        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
                    </div>
                    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6">
                        <h4 class="font-headline-md text-headline-md text-on-surface mb-6">Pricing Insights</h4>
                        <div class="space-y-6">
                            <div class="relative h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="absolute h-full bg-primary w-3/4 rounded-full"></div>
                            </div>
                            <div class="flex justify-between items-center text-body-sm font-body-sm">
                                <span class="text-on-surface-variant">Wash &amp; Fold Margin</span>
                                <span class="text-primary font-bold">68%</span>
                            </div>
                            <div class="pt-4 border-t border-border-subtle">
                                <p class="text-[12px] text-on-surface-variant italic mb-4">"Service pricing is 12% lower than regional competitors. Consider a slight adjustment for Delicates."</p>
                                <img alt="Analytics Chart" class="w-full h-32 object-cover rounded-lg" data-alt="A clean, minimalist bar chart showing revenue performance metrics for different laundry services. The aesthetic is professional with a soft color palette of blues and grays, using crisp lines and plenty of whitespace. The lighting is bright and even, reinforcing a data-driven, clinical management interface style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnnZrJjndSKjUcEaVW2ZvZswqcnKwzIv3w4n6NwNewCcVaTwr31LRvZc3E9UlJ687d7VoCrzjW-tiX_EWzPpRAXSgAVH4vD-ZS6EFdsCsgQusSNyN1kNlNET3X7bRhetWUN4DpOn97c5AHz3yOpxrlkEVuYeHa1bwWNIoq8OCyYLf2PYg1RR6zlGnVOnE4VaqDZBWAKb6oCRHSYkDlaSvqWH2Uwn3uVj3Yf0mJ-5DyfRaMH5vhqnjy71i86JkVvjIu7z21jE3w01c" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <footer class="w-full py-12 px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto border-t border-border-subtle lg:pl-72">
        <div class="mb-6 md:mb-0">
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">LaundryTrack</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">© 2024 LaundryTrack Logistics. All rights reserved.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-8">
            <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Terms of Service</a>
            <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Contact Support</a>
            <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Merchant Portal</a>
        </div>
    </footer>
    <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface border-t border-border-subtle shadow-sm">
        <a class="flex flex-col items-center justify-center text-on-surface-variant scale-95 duration-100" href="#">
            <span class="material-symbols-outlined" data-icon="storefront">storefront</span>
            <span class="font-label-caps text-label-caps">Shops</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant scale-95 duration-100" href="#">
            <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
            <span class="font-label-caps text-label-caps">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 scale-95 duration-100" href="#">
            <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
            <span class="font-label-caps text-label-caps">Stock</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant scale-95 duration-100" href="#">
            <span class="material-symbols-outlined" data-icon="person">person</span>
            <span class="font-label-caps text-label-caps">Profile</span>
        </a>
    </nav>
</body>

</html>