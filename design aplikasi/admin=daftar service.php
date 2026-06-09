<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Price List Management | LaundryTrack</title>
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
                        "status-error": "#EF4444",
                        "on-primary-fixed": "#001452",
                        "on-secondary-fixed": "#131b2e",
                        "inverse-primary": "#b7c4ff",
                        "tertiary-container": "#bf3003",
                        "on-primary-fixed-variant": "#0038b6",
                        "primary-container": "#0052ff",
                        "outline": "#737688",
                        "error": "#ba1a1a",
                        "status-success": "#10B981",
                        "surface-container": "#ededfb",
                        "on-tertiary-fixed": "#3c0800",
                        "primary": "#003ec7",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#ffb4a1",
                        "on-secondary-container": "#5c647a",
                        "primary-fixed": "#dde1ff",
                        "secondary-container": "#dae2fd",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191b25",
                        "surface-container-high": "#e7e7f5",
                        "on-error": "#ffffff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-primary-container": "#dfe3ff",
                        "border-subtle": "#E2E8F0",
                        "tertiary": "#952200",
                        "surface-variant": "#e1e1ef",
                        "on-background": "#191b25",
                        "secondary": "#565e74",
                        "surface": "#fbf8ff",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#434656",
                        "surface-dim": "#d9d9e7",
                        "surface-bright": "#fbf8ff",
                        "tertiary-fixed": "#ffdbd2",
                        "outline-variant": "#c3c5d9",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#f0effe",
                        "surface-tint": "#004ced",
                        "on-tertiary-container": "#ffddd5",
                        "surface-container-low": "#f3f2ff",
                        "inverse-surface": "#2e303a",
                        "on-tertiary-fixed-variant": "#891e00",
                        "background": "#fbf8ff",
                        "on-secondary": "#ffffff",
                        "surface-container-highest": "#e1e1ef",
                        "primary-fixed-dim": "#b7c4ff",
                        "error-container": "#ffdad6",
                        "status-progress": "#F59E0B",
                        "secondary-fixed-dim": "#bec6e0",
                        "surface-wash": "#F8FAFC",
                        "secondary-fixed": "#dae2fd"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "margin-mobile": "16px",
                        "section-padding": "48px",
                        "gutter": "24px",
                        "base": "8px"
                    },
                    "fontFamily": {
                        "body-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "display": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-caps": ["Inter"]
                    },
                    "fontSize": {
                        "body-lg": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "data-mono": ["13px", {
                            "lineHeight": "16px",
                            "fontWeight": "500"
                        }],
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "600"
                        }],
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "display": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "label-caps": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
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

        .price-input-focus:focus-within {
            border-color: #003ec7;
        }
    </style>
</head>

<body class="bg-surface-wash font-body-lg text-on-surface">
    <!-- Desktop Side Navigation -->
    <aside class="hidden md:flex flex-col fixed left-0 top-0 h-full py-base px-base space-y-4 bg-surface border-r border-border-subtle w-64 z-40">
        <div class="px-4 py-6">
            <h1 class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Laundry Ops Console</p>
        </div>
        <nav class="flex-1 space-y-1 px-2">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                <span class="font-label-caps text-label-caps">Orders</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
                <span class="font-label-caps text-label-caps">Inbox</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="location_on">location_on</span>
                <span class="font-label-caps text-label-caps">Live Tracking</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-semibold rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="settings_applications">settings_applications</span>
                <span class="font-label-caps text-label-caps">Operations</span>
            </a>
        </nav>
        <div class="border-t border-border-subtle pt-4 px-2">
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-highest transition-colors duration-150 rounded-xl" href="#">
                <span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
                <span class="font-label-caps text-label-caps">Help Center</span>
            </a>
        </div>
    </aside>
    <!-- Main Content Area -->
    <main class="md:ml-64 min-h-screen pb-24 md:pb-8">
        <!-- Top App Bar -->
        <header class="flex justify-between items-center w-full px-margin-mobile md:px-gutter max-w-container-max mx-auto h-16 bg-surface-container-lowest border-b border-border-subtle sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <h2 class="font-headline-md text-headline-md font-bold text-primary md:hidden">LaundryTrack</h2>
                <div class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-border-subtle w-96">
                    <span class="material-symbols-outlined text-on-surface-variant mr-2" data-icon="search">search</span>
                    <input class="bg-transparent border-none focus:ring-0 w-full text-body-sm font-body-sm" placeholder="Search services..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
                </button>
                <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center overflow-hidden">
                    <img alt="User Profile" class="w-full h-full object-cover" data-alt="A professional headshot of a business manager, smiling gently, against a clean clinical white background with soft daylight. The photography style is high-end corporate minimalist, featuring soft focus on the background to emphasize the subject's friendly and reliable expression." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJ1vkhnfhvCpcK3QRXcBVnTq5PtjH8xND6iSbKJfOkkNF4WwkwujyBRYRJ9GfklcaIl9Bx9Ul8W9Q_zzRJwHvLXxedp0RErMnf81A9FdzAdS9z3kyw2IbwMgrBQpF3C5Du_rPSmR2DQzCzxrXDVbu3kqeD1J6BLPpU8pIoEpW53_tTVSLHFdm7ZKfMCw7wKYCyXoiaooXlpucKCZYw-IXTG5wvhKhr8WPY2jz_ptI-eBZDxcbAwME_7Am2SP5j-BdSRJYgqs4isjM" />
                </div>
            </div>
        </header>
        <!-- Page Header -->
        <section class="max-w-container-max mx-auto px-margin-mobile md:px-gutter pt-8 pb-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-on-surface-variant mb-2">
                        <span class="font-label-caps text-label-caps">Operations</span>
                        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
                        <span class="font-label-caps text-label-caps text-primary">Price List</span>
                    </nav>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Price List Management</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">Adjust rates and service availability for your business.</p>
                </div>
                <button class="flex items-center justify-center gap-2 bg-primary text-on-primary px-5 py-2.5 rounded-xl font-semibold shadow-sm hover:opacity-90 transition-all active:scale-95">
                    <span class="material-symbols-outlined" data-icon="add">add</span>
                    <span>Add New Service</span>
                </button>
            </div>
        </section>
        <!-- Stats Overview (Bento Style Lite) -->
        <section class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest border border-border-subtle p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-primary-container/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                    </div>
                    <span class="font-label-caps text-label-caps text-status-success">+2 NEW</span>
                </div>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Total Services</p>
                <h3 class="font-headline-lg text-headline-lg font-bold">24</h3>
            </div>
            <div class="bg-surface-container-lowest border border-border-subtle p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-secondary-container/20 rounded-lg text-secondary">
                        <span class="material-symbols-outlined" data-icon="payments">payments</span>
                    </div>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">AVG</span>
                </div>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Average Price</p>
                <h3 class="font-headline-lg text-headline-lg font-bold">$12.40</h3>
            </div>
            <div class="bg-surface-container-lowest border border-border-subtle p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-status-success/10 rounded-lg text-status-success">
                        <span class="material-symbols-outlined" data-icon="toggle_on">toggle_on</span>
                    </div>
                    <span class="font-label-caps text-label-caps text-status-success">92% ACTIVE</span>
                </div>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Active Status</p>
                <h3 class="font-headline-lg text-headline-lg font-bold">22</h3>
            </div>
        </section>
        <!-- Price Table Sections -->
        <section class="max-w-container-max mx-auto px-margin-mobile md:px-gutter space-y-8">
            <!-- Category: Wash & Fold -->
            <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-border-subtle flex items-center justify-between bg-surface-container-low">
                    <h4 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                        <span class="w-1 h-6 bg-primary rounded-full"></span>
                        Wash &amp; Fold
                    </h4>
                    <span class="bg-primary-container/20 text-primary px-3 py-1 rounded-full font-label-caps text-label-caps">6 Items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest border-b border-border-subtle">
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Service Name</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Unit</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Price</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-center">Status</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle">
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-6 py-5 font-body-lg text-on-surface">Standard Load (Regular Detergent)</td>
                                <td class="px-6 py-5 font-data-mono text-data-mono text-on-surface-variant">kg</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center border border-border-subtle rounded-lg px-3 py-1 price-input-focus transition-all bg-surface-container-lowest">
                                        <span class="text-on-surface-variant text-sm mr-1">$</span>
                                        <input class="border-none p-0 w-12 text-right font-data-mono text-on-surface focus:ring-0" type="text" value="3.50" />
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-status-success">
                                            <span class="translate-x-5 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-5 font-body-lg text-on-surface">Delicates &amp; Hand Wash</td>
                                <td class="px-6 py-5 font-data-mono text-data-mono text-on-surface-variant">kg</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center border border-border-subtle rounded-lg px-3 py-1 price-input-focus transition-all bg-surface-container-lowest">
                                        <span class="text-on-surface-variant text-sm mr-1">$</span>
                                        <input class="border-none p-0 w-12 text-right font-data-mono text-on-surface focus:ring-0" type="text" value="6.00" />
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-status-success">
                                            <span class="translate-x-5 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Category: Dry Cleaning -->
            <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-border-subtle flex items-center justify-between bg-surface-container-low">
                    <h4 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                        <span class="w-1 h-6 bg-tertiary rounded-full"></span>
                        Dry Cleaning
                    </h4>
                    <span class="bg-tertiary-fixed text-on-tertiary-fixed-variant px-3 py-1 rounded-full font-label-caps text-label-caps">12 Items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest border-b border-border-subtle">
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Service Name</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Unit</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Price</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-center">Status</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle">
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-5 font-body-lg text-on-surface">Men's 2-Piece Suit</td>
                                <td class="px-6 py-5 font-data-mono text-data-mono text-on-surface-variant">piece</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center border border-border-subtle rounded-lg px-3 py-1 price-input-focus transition-all bg-surface-container-lowest">
                                        <span class="text-on-surface-variant text-sm mr-1">$</span>
                                        <input class="border-none p-0 w-12 text-right font-data-mono text-on-surface focus:ring-0" type="text" value="18.50" />
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-status-success">
                                            <span class="translate-x-5 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-5 font-body-lg text-on-surface">Evening Gown (Standard)</td>
                                <td class="px-6 py-5 font-data-mono text-data-mono text-on-surface-variant">piece</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center border border-border-subtle rounded-lg px-3 py-1 price-input-focus transition-all bg-surface-container-lowest">
                                        <span class="text-on-surface-variant text-sm mr-1">$</span>
                                        <input class="border-none p-0 w-12 text-right font-data-mono text-on-surface focus:ring-0" type="text" value="25.00" />
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-outline-variant">
                                            <span class="translate-x-0 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Category: Special Care -->
            <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-border-subtle flex items-center justify-between bg-surface-container-low">
                    <h4 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span>
                        Special Care
                    </h4>
                    <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-caps text-label-caps">3 Items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest border-b border-border-subtle">
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Service Name</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant">Unit</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Price</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-center">Status</th>
                                <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle">
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-5 font-body-lg text-on-surface">Leather Jacket Treatment</td>
                                <td class="px-6 py-5 font-data-mono text-data-mono text-on-surface-variant">piece</td>
                                <td class="px-6 py-5 text-right">
                                    <div class="inline-flex items-center border border-border-subtle rounded-lg px-3 py-1 price-input-focus transition-all bg-surface-container-lowest">
                                        <span class="text-on-surface-variant text-sm mr-1">$</span>
                                        <input class="border-none p-0 w-12 text-right font-data-mono text-on-surface focus:ring-0" type="text" value="45.00" />
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-status-success">
                                            <span class="translate-x-5 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Action Bar Footer -->
        <div class="fixed bottom-0 right-0 left-0 md:left-64 bg-surface-container-lowest border-t border-border-subtle p-4 z-20 flex justify-between items-center shadow-lg md:shadow-none">
            <span class="font-body-sm text-body-sm text-on-surface-variant hidden md:block">Unsaved changes will be lost if you leave this page.</span>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button class="flex-1 md:flex-none px-6 py-2.5 font-semibold text-on-surface-variant border border-border-subtle rounded-xl hover:bg-surface-container-low transition-colors">Discard Changes</button>
                <button class="flex-1 md:flex-none px-8 py-2.5 font-semibold bg-primary text-on-primary rounded-xl hover:opacity-90 transition-all shadow-sm">Save Price List</button>
            </div>
        </div>
    </main>
    <!-- Mobile Navigation Bar -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 md:hidden bg-surface-container-lowest border-t border-border-subtle rounded-t-full shadow-lg">
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="home">home</span>
            <span class="font-label-caps text-label-caps">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
            <span class="font-label-caps text-label-caps">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="chat">chat</span>
            <span class="font-label-caps text-label-caps">Chat</span>
        </a>
        <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1" href="#">
            <span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
            <span class="font-label-caps text-label-caps">Track</span>
        </a>
    </nav>
</body>

</html>