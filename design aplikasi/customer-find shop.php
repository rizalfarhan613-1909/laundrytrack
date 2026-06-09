<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LaundryTrack | Find a Shop</title>
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
            background-color: #fbf8ff;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #fbf8ff;
        }

        ::-webkit-scrollbar-thumb {
            background: #e1e1ef;
            border-radius: 4px;
        }
    </style>
</head>

<body class="font-body-lg text-on-surface antialiased">
    <!-- TopNavBar (Desktop) -->
    <header class="fixed top-0 left-0 w-full z-50 bg-surface border-b border-border-subtle h-16">
        <div class="max-w-container-max mx-auto px-gutter h-full flex justify-between items-center">
            <div class="flex items-center gap-8">
                <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
                <nav class="hidden md:flex gap-6">
                    <a class="text-primary font-bold border-b-2 border-primary pb-1 font-body-lg text-body-lg" href="#">Dashboard</a>
                    <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Orders</a>
                    <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Inventory</a>
                    <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Financials</a>
                    <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Marketing</a>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-border-subtle">
                    <span class="material-symbols-outlined text-outline text-[20px] mr-2">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-body-sm font-body-sm w-48" placeholder="Search shops..." type="text" />
                </div>
                <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">notifications</button>
                <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">settings</button>
                <div class="w-8 h-8 rounded-full overflow-hidden border border-border-subtle">
                    <img alt="Owner Profile" data-alt="A professional close-up portrait of a clean-shaven business owner with a friendly and reliable expression. The lighting is soft and natural, emphasizing a trustworthy persona. The background is a slightly blurred, high-end laundry boutique interior with neutral tones and pristine white surfaces, reinforcing a premium hospitality aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB68ddB3xbIJGBtPbtq5S91irPrcDHSsScJnmcK8PYQFwyu4InozK2KB4WhatTzLjS_OiR_ESPt18TXzVC_c0ADoXSJP8d-RxZG3bc4h6HXEJbT5O58bipfxbxCuOeOaHyoo0b_XFQsrEtA8S86AdRJ5PLBmyodPJSee1phUQuc3FO3KpASxSQVIiDLvjrSone0Rc-kRovfl2KPCrB1s87ReRPoSMShUcM7lLCSDmh5LXd-dH79_veq8rpEyr0r5JEbZJTO_JkI650" />
                </div>
            </div>
        </div>
    </header>
    <main class="pt-24 pb-20 md:pb-12 max-w-container-max mx-auto px-gutter min-h-screen">
        <!-- Search & Header Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface mb-2">Find a Shop Near You</h1>
                <p class="text-on-surface-variant max-w-xl">Select from our vetted premium laundry partners for clinical precision and hospitality-grade service.</p>
            </div>
            <div class="flex flex-col gap-2 w-full md:w-auto">
                <label class="font-label-caps text-label-caps text-on-surface-variant">YOUR LOCATION</label>
                <div class="flex gap-2">
                    <div class="relative flex-grow">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-primary">location_on</span>
                        <input class="w-full pl-10 pr-4 py-3 bg-surface border border-border-subtle rounded-xl focus:border-primary focus:ring-1 focus:ring-primary text-body-lg font-body-lg" type="text" value="Manhattan, NY 10012" />
                    </div>
                    <button class="bg-primary text-on-primary px-6 py-3 rounded-xl font-body-lg font-semibold hover:opacity-90 transition-all flex items-center gap-2">
                        <span>Search</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- List Section -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <!-- Shop Card 1 -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden flex flex-col sm:flex-row group hover:border-primary transition-colors cursor-pointer relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-success"></div>
                    <div class="w-full sm:w-48 h-48 relative">
                        <img class="w-full h-full object-cover" data-alt="A clean and modern laundry shop interior with industrial washers behind a minimalist glass counter. The atmosphere is clinical and bright with soft overhead lighting. Neutral color palette of whites, grays, and soft blues, creating a sense of professional reliability and premium hospitality." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCItIpQVkCPG9dy-DRDwmMJ8yjclDdRpKbV2PaQTxYdh0Ivlb-hJM7XvNZ5OP8Xdwm7ddU3kGcoLp9c5q1fh7v7GIKhxvNzz8ZCHsOSwMmAWAt-eJQglJMVbtTnbpKTiMgL_JWVSmMrrUGfz6LEUi5LWOGbIhXo5e2LChqnNri4KgamUssjzmWzwDXP3WA8Ah1kZv9JCoDIwXxRH9AbwyVmrQ1pd5VpTaHQ_2O__DX9AAT3nM5fQqIb2vhRuSn0WwJqJbShKDklMnE" />
                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="font-data-mono text-data-mono">4.9</span>
                        </div>
                    </div>
                    <div class="flex-grow p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-headline-md text-headline-md">Lustrous Linens Soho</h3>
                                <span class="font-label-caps text-label-caps px-2 py-1 bg-primary/10 text-primary rounded">0.4 MILES</span>
                            </div>
                            <p class="text-on-surface-variant text-body-sm font-body-sm mb-4">Specializing in organic detergents and high-thread-count delicate care.</p>
                            <!-- Pricing Quick View -->
                            <div class="grid grid-cols-2 gap-4 border-t border-border-subtle pt-4">
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">WASH &amp; FOLD</span>
                                    <span class="font-headline-md text-headline-md text-primary">$2.50<small class="text-body-sm font-normal">/lb</small></span>
                                </div>
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">DRY CLEAN</span>
                                    <span class="font-headline-md text-headline-md text-primary">$8.00<small class="text-body-sm font-normal">/pc</small></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <button class="flex-grow bg-primary text-on-primary py-2.5 rounded-lg font-body-lg font-semibold hover:shadow-lg transition-shadow">Select Shop</button>
                            <button class="px-3 border border-border-subtle rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined mt-1">favorite</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Shop Card 2 -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden flex flex-col sm:flex-row group hover:border-primary transition-colors cursor-pointer relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-success"></div>
                    <div class="w-full sm:w-48 h-48 relative">
                        <img class="w-full h-full object-cover" data-alt="Interior of a boutique laundry valet service featuring wooden shelving units with perfectly folded white linens. Soft, warm directional lighting highlights the texture of the fabric. The aesthetic is warm yet professionally curated, moving away from utility toward a luxury hospitality experience." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBO_CZx5qjY-nEg2sLVvBRUazF7Wn3prfoeS8k91bBHodofqNQ6bTl4Xyg0GQR5br7flHuV9JVK_1dEGkLAOXiicXO5ipfoXXGTj2xfp71OR_UiU_TRgAg_u6Ixaq4NF53WijaOPDQJ27V9yrG44xYyAaZyqWGDJEzQYcTHmab0MOD8vuviexSjJbF2QUOnmwfYCCYPgPKqHcp6u2SQ-HEQ3cNP_nAO1XvQEVqP72y-B15HWuVqrYrvvE6jME3wiQ4Tp5E2_ejx-W8" />
                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="font-data-mono text-data-mono">4.7</span>
                        </div>
                    </div>
                    <div class="flex-grow p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-headline-md text-headline-md">The Clean Slate</h3>
                                <span class="font-label-caps text-label-caps px-2 py-1 bg-primary/10 text-primary rounded">0.9 MILES</span>
                            </div>
                            <p class="text-on-surface-variant text-body-sm font-body-sm mb-4">Same-day turnaround for business attire and corporate clients.</p>
                            <!-- Pricing Quick View -->
                            <div class="grid grid-cols-2 gap-4 border-t border-border-subtle pt-4">
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">WASH &amp; FOLD</span>
                                    <span class="font-headline-md text-headline-md text-primary">$1.95<small class="text-body-sm font-normal">/lb</small></span>
                                </div>
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">DRY CLEAN</span>
                                    <span class="font-headline-md text-headline-md text-primary">$6.50<small class="text-body-sm font-normal">/pc</small></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <button class="flex-grow bg-primary text-on-primary py-2.5 rounded-lg font-body-lg font-semibold hover:shadow-lg transition-shadow">Select Shop</button>
                            <button class="px-3 border border-border-subtle rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined mt-1">favorite</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Shop Card 3 -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl overflow-hidden flex flex-col sm:flex-row group hover:border-primary transition-colors cursor-pointer relative opacity-80">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-status-progress"></div>
                    <div class="w-full sm:w-48 h-48 relative">
                        <img class="w-full h-full object-cover grayscale" data-alt="A brightly lit, minimalist laundry room featuring contemporary equipment and organized supply shelves. The lighting is high-key and clean, suggesting a high standard of hygiene. The color palette is dominated by whites and soft gray tones, reinforcing a clinical yet inviting service environment." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoBqlxxamqpi8I3r2GT8DUkDY7rOdZpCmcUvwDDexLh7-ul1G8n-OWd8ZpTrD9Bn93n4gUS9F19PaguAtX_TQRNrqRS9ZIFGQupU20ZAVDV8p3K4Vb1eGlVPN4qKOjBs6BiB88VXZerykPzwFTWqCK_b8_6--Tnpkv1bqPJe5_oQsTxbtBbJo46masQGDGf_GFGfvL2TjRhz33Uk-16a1T8aLYfnJlCykoTj7JzswnFFO4LReAF0zf4UykjsZTp-k7RRvSEsWaYwc" />
                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="font-data-mono text-data-mono">4.5</span>
                        </div>
                        <div class="absolute inset-0 bg-on-surface/40 flex items-center justify-center">
                            <span class="font-label-caps text-label-caps text-white bg-error px-3 py-1 rounded-full">FULLY BOOKED</span>
                        </div>
                    </div>
                    <div class="flex-grow p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-headline-md text-headline-md">Village Wash Co.</h3>
                                <span class="font-label-caps text-label-caps px-2 py-1 bg-primary/10 text-primary rounded">1.2 MILES</span>
                            </div>
                            <p class="text-on-surface-variant text-body-sm font-body-sm mb-4">Eco-friendly traditional laundering with a community focus.</p>
                            <div class="grid grid-cols-2 gap-4 border-t border-border-subtle pt-4">
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">WASH &amp; FOLD</span>
                                    <span class="font-headline-md text-headline-md text-primary">$2.10<small class="text-body-sm font-normal">/lb</small></span>
                                </div>
                                <div>
                                    <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">DRY CLEAN</span>
                                    <span class="font-headline-md text-headline-md text-primary">$7.25<small class="text-body-sm font-normal">/pc</small></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <button class="flex-grow bg-outline text-on-surface py-2.5 rounded-lg font-body-lg font-semibold cursor-not-allowed">Waitlist Only</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Map & Summary Section -->
            <div class="lg:col-span-5 h-[600px] lg:sticky lg:top-24 rounded-2xl overflow-hidden border border-border-subtle bg-surface-container flex flex-col">
                <div class="flex-grow relative">
                    <img class="w-full h-full object-cover" data-alt="A detailed, clean minimalist digital map of a metropolitan city area. The map uses a soft palette of whites, light grays, and primary blue accents for points of interest. It features subtle markers indicating shop locations and a soft user location pulse. The design is elegant, uncluttered, and highly readable, matching a premium logistics UI." data-location="New York City" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJsAnjfwxLtPfAXMwZtTQQiGHbbmP_lPV8HiXdZtuSznevu6OBiypqJRXVGyG0TvmhinqSS8lO5rw2cQcIQ8Y8vgSRoGG9llCsvcTcUfXZQdD07xq7mjoOko1kTwnGjExJH-TcUuV5j-kK-CYlyvPqRZWnDR3lC3MY6uEIVu6l7H9kn2YiJ7Oty0Ua6WDfAtZ96VR3xd2g6vfrofT-K7GpY5ovnU9S3_UlVRFbgYJK74o9RfSF9OTdhJ3NKg8hj6wsBXenwaWtZ4o" />
                    <!-- Map Pin Overlays (Visual elements) -->
                    <div class="absolute top-[40%] left-[30%] -translate-x-1/2 -translate-y-1/2">
                        <div class="flex flex-col items-center">
                            <div class="bg-primary text-white p-2 rounded-full shadow-lg scale-110 border-2 border-white">
                                <span class="material-symbols-outlined text-[20px]">local_laundry_service</span>
                            </div>
                            <div class="bg-white px-2 py-1 rounded shadow text-label-caps font-label-caps mt-1 border border-border-subtle">$2.50</div>
                        </div>
                    </div>
                    <div class="absolute top-[60%] left-[70%] -translate-x-1/2 -translate-y-1/2">
                        <div class="flex flex-col items-center opacity-70">
                            <div class="bg-on-surface-variant text-white p-2 rounded-full shadow-lg border-2 border-white">
                                <span class="material-symbols-outlined text-[20px]">local_laundry_service</span>
                            </div>
                            <div class="bg-white px-2 py-1 rounded shadow text-label-caps font-label-caps mt-1 border border-border-subtle">$1.95</div>
                        </div>
                    </div>
                </div>
                <!-- Active Shop Card Mini -->
                <div class="bg-surface p-6 border-t border-border-subtle">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="font-label-caps text-label-caps text-primary">SELECTED SHOP</span>
                            <h4 class="font-headline-md text-headline-md">Lustrous Linens Soho</h4>
                        </div>
                        <div class="text-right">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">EST. TOTAL</span>
                            <div class="font-headline-md text-headline-md">$24.50</div>
                        </div>
                    </div>
                    <button class="w-full bg-primary text-on-primary py-4 rounded-xl font-body-lg font-bold shadow-lg flex justify-center items-center gap-3 active:scale-95 transition-all">
                        <span>Continue to Order Details</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-surface-container-highest border-t border-border-subtle mt-20">
        <div class="w-full py-12 px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto gap-8">
            <div class="flex flex-col items-center md:items-start">
                <span class="font-headline-md text-headline-md font-bold text-on-surface mb-2">LaundryTrack</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant">© 2024 LaundryTrack Logistics. All rights reserved.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Contact Support</a>
                <a class="text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">Merchant Portal</a>
            </div>
        </div>
    </footer>
    <!-- BottomNavBar (Mobile) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface border-t border-border-subtle rounded-t-xl shadow-sm">
        <div class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 active:scale-95 duration-100 transition-all">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
            <span class="font-label-caps text-label-caps">Shops</span>
        </div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant active:scale-95 duration-100 transition-all">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-caps text-label-caps">Orders</span>
        </div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant active:scale-95 duration-100 transition-all">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span class="font-label-caps text-label-caps">Chat</span>
        </div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant active:scale-95 duration-100 transition-all">
            <span class="material-symbols-outlined">person</span>
            <span class="font-label-caps text-label-caps">Profile</span>
        </div>
    </nav>
</body>

</html>