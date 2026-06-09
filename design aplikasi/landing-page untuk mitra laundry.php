<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
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

        body {
            background-color: #fbf8ff;
        }
    </style>
</head>

<body class="font-body-lg text-on-background overflow-x-hidden">
    <!-- Top Navigation Bar -->
    <nav class="bg-surface-container-lowest dark:bg-surface-container-lowest border-b border-border-subtle dark:border-outline-variant docked full-width top-0 sticky z-50">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter max-w-container-max mx-auto h-16">
            <div class="flex items-center gap-8">
                <span class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">LaundryTrack</span>
                <div class="hidden md:flex gap-6">
                    <a class="text-primary font-bold border-b-2 border-primary font-label-caps text-label-caps h-16 flex items-center" href="#">Solutions</a>
                    <a class="text-on-surface-variant font-medium hover:bg-surface-container-low transition-colors duration-200 font-label-caps text-label-caps h-16 flex items-center px-2" href="#">Partners</a>
                    <a class="text-on-surface-variant font-medium hover:bg-surface-container-low transition-colors duration-200 font-label-caps text-label-caps h-16 flex items-center px-2" href="#">Pricing</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="material-symbols-outlined text-on-surface-variant p-2 hover:bg-surface-container-low transition-colors duration-200 rounded-full" data-icon="notifications">notifications</button>
                <button class="material-symbols-outlined text-on-surface-variant p-2 hover:bg-surface-container-low transition-colors duration-200 rounded-full" data-icon="chat_bubble">chat_bubble</button>
                <button class="material-symbols-outlined text-on-surface-variant p-2 hover:bg-surface-container-low transition-colors duration-200 rounded-full" data-icon="account_circle">account_circle</button>
                <button class="bg-primary text-on-primary px-5 py-2 rounded-xl font-label-caps text-label-caps font-bold hover:opacity-90 transition-all">Get Started</button>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <header class="relative bg-surface-wash pt-20 pb-32 overflow-hidden">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter flex flex-col md:flex-row items-center gap-16">
            <div class="flex-1 space-y-8 text-center md:text-left">
                <div class="inline-flex items-center px-3 py-1 bg-primary-fixed text-on-primary-fixed rounded-full">
                    <span class="font-label-caps text-label-caps">Merchant Partner Program 2024</span>
                </div>
                <h1 class="font-display text-display text-on-surface leading-tight">Elevate Your Laundry Business to <span class="text-primary">Global Standards</span></h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto md:mx-0">
                    LaundryTrack provides the clinical precision and premium infrastructure needed to manage high-volume logistics with hospitality-level care.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-headline-md text-headline-md font-bold shadow-lg hover:scale-105 transition-transform">Join as a Partner</button>
                    <button class="border border-border-subtle bg-white text-on-surface px-8 py-4 rounded-xl font-headline-md text-headline-md font-bold hover:bg-surface-container-low transition-colors">Book a Demo</button>
                </div>
            </div>
            <div class="flex-1 relative w-full aspect-square md:aspect-auto">
                <div class="bg-white rounded-[2rem] p-4 shadow-2xl border border-border-subtle relative z-10">
                    <img alt="Premium laundry facility" class="rounded-[1.5rem] w-full h-[500px] object-cover" data-alt="A high-end, clinical laundry facility with state-of-the-art stainless steel machines lined up in a pristine white environment. The lighting is bright and airy, emphasizing a sense of premium hospitality and hygiene. Professional staff members in clean uniforms are seen meticulously folding white linens. The overall aesthetic is minimalist and modern with soft blue and white tones." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMjBLFHg6P3rzgf7VZSFnBfc2M5KjpaMvSTtEYQuPo3fE68DB1GrWawLEJQURP13JJ_683zMJYz30A_14elWKb7B25stU1jpYhTajJAjPWe6lEikdO19jzGvTu8Xie26FbHABrN3n5nLWwmFjYnVhTLAfvG9nWwszIpM76hejtxxllLmDnTviENoYoOMyHb-7BwQkxzmINh9r7xtC-Fb_MPi8eFY0d0E9PSaVKRJTQgdAx479_ZydGsBlueL1xL-otWOddEdjJVCo" />
                </div>
                <!-- Decorative element -->
                <div class="absolute -top-12 -right-12 w-64 h-64 bg-primary-container opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-secondary-container opacity-20 rounded-full blur-3xl"></div>
            </div>
        </div>
    </header>
    <!-- Bento Grid Features Section -->
    <section class="py-section-padding bg-white">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter">
            <div class="text-center mb-16 space-y-4">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Integrated Logistics Ecosystem</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">One console to manage every touchpoint of your customer journey, from pickup to doorstep delivery.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-auto md:h-[600px]">
                <!-- Tracking Card -->
                <div class="md:col-span-8 bg-surface-container-low rounded-[2rem] p-8 border border-border-subtle flex flex-col justify-between overflow-hidden relative group">
                    <div class="space-y-4 z-10 relative">
                        <span class="material-symbols-outlined text-primary text-4xl" data-icon="location_on">location_on</span>
                        <h3 class="font-headline-lg text-headline-lg">Real-Time Live Tracking</h3>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-md">GPS-enabled courier tracking ensures every order is visible. Reduce customer inquiries by 40% with automated milestone notifications.</p>
                    </div>
                    <div class="mt-8 flex gap-4">
                        <div class="bg-white p-4 rounded-xl border border-border-subtle shadow-sm flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-label-caps text-label-caps text-on-surface-variant">Order #9821</span>
                                <span class="bg-status-success/10 text-status-success px-2 py-0.5 rounded-full font-label-caps text-[10px] uppercase">In Transit</span>
                            </div>
                            <div class="h-1 bg-surface-container-high rounded-full overflow-hidden">
                                <div class="w-3/4 h-full bg-status-success"></div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-border-subtle shadow-sm flex-1 hidden sm:block">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">ETA Courier</span>
                            <p class="font-data-mono text-data-mono text-primary">12:45 PM</p>
                        </div>
                    </div>
                    <img alt="Logistics background" class="absolute right-0 bottom-0 w-1/2 opacity-20 group-hover:scale-110 transition-transform duration-500" data-alt="A zoomed-in, high-contrast aerial view of a clean delivery van moving through a modern city grid. The perspective is from directly above, creating a geometric pattern of streets. The lighting is crisp afternoon sun with long, sharp shadows. The color palette is muted grays with a sharp blue highlight representing the tracking route." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUBe9oomGK1irU4kTYDiKS5hB23zDZs4IhtYvcNt2-Zot9jRdo7MuNPeFYApY-ea_IsVpoJ7hmYQkvDsKD1uODFkOEhVsr73MJNInSQpJMZdKj-1kHFd35hkdneCyjH71qUVvCuxZugh1li7JPKeloKYO8kTSRNs5c2Ss2PDwBDxbhrwt-FKdTTtrLo9PHbov5bQhe2pxDnuT_VQMiipgYlx64Lj85b3oGOQQaMj9anBpYBH-5K2jnxYtQ21egmlaOxb9oaoKH4Zc" />
                </div>
                <!-- Chat Card -->
                <div class="md:col-span-4 bg-primary text-on-primary rounded-[2rem] p-8 border border-primary flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="material-symbols-outlined text-4xl" data-icon="chat_bubble">chat_bubble</span>
                        <h3 class="font-headline-lg text-headline-lg">Concierge Chat</h3>
                        <p class="font-body-sm text-body-sm opacity-80">Direct, real-time communication between merchants, customers, and couriers. Resolve issues instantly with hospitality-focused messaging.</p>
                    </div>
                    <div class="space-y-3 mt-8">
                        <div class="bg-white/10 p-3 rounded-lg text-xs self-start max-w-[80%] border border-white/20">Is my duvet ready for pickup?</div>
                        <div class="bg-white text-primary p-3 rounded-lg text-xs self-end max-w-[80%] ml-auto font-medium">Yes! Our courier is 5 minutes away.</div>
                    </div>
                </div>
                <!-- Logistics Card -->
                <div class="md:col-span-5 bg-white rounded-[2rem] p-8 border border-border-subtle flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="material-symbols-outlined text-tertiary text-4xl" data-icon="settings_applications">settings_applications</span>
                        <h3 class="font-headline-md text-headline-md">Operations Ops Console</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Sophisticated inventory management and machine utilization tracking to optimize your daily throughput.</p>
                    </div>
                    <img alt="Analytics" class="rounded-xl mt-4 grayscale" data-alt="A clean, minimalist dashboard UI displayed on a high-resolution tablet screen. The interface shows sophisticated data visualizations including smooth line graphs and bar charts in shades of primary blue. The setting is a bright, modern office with soft natural lighting. The mood is professional and focused on technological efficiency." src="https://lh3.googleusercontent.com/aida-public/AB6AXuChsTzE3vXY918u_h7-3QlqNxEi2ntSWXV_M3n1kzj-a2uiTwOAYC6-6Me0lPeydIHzP32wQVcAmqwbE9a5sQpD-e0QYzuJkDOlXAQSQyArPeWctdP6tJqf1j7_l3iMrPYdVgCF23gKR6kiF7ZyZd3haUfMKbwZQtrunTlCnjhBwdRYhxYEXBKXTPlNBA2Dt_M6nWXGCHbPJ8g9UAL3jiQXc9AR5sBTJapWXbs2Mpff0LJFu0JoXnP22l0BuNvSS4upmdvVW72oR0k" />
                </div>
                <!-- Support Card -->
                <div class="md:col-span-7 bg-surface-wash rounded-[2rem] p-8 border border-border-subtle flex flex-col md:flex-row gap-8 items-center">
                    <div class="space-y-4 flex-1">
                        <h3 class="font-headline-md text-headline-md">24/7 Merchant Support</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Our dedicated success team ensures your operations never stop. Onboarding, training, and troubleshooting handled in minutes.</p>
                        <button class="font-label-caps text-label-caps text-primary flex items-center gap-2 group">Learn about success metrics <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span></button>
                    </div>
                    <div class="flex -space-x-4">
                        <img class="w-12 h-12 rounded-full border-2 border-white object-cover" data-alt="Close up portrait of a professional woman smiling softly, high-key studio lighting, modern minimalist aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDuVI2-I8XoQEqn4gJYDPdizR0PyeHDRfBJTVtcE5TpeK_vxsEmA7QYEcm9XnhtmBmFPFzeHDaNvPZexHbJtYKNGQqH1v-f8KKtZcM9JfT5VRhusOoqoJsVclH1WOL8lIjAxIXDCzeXICXjtxonbrrUpaLw-G35EVjCKfDZVwQ3VkkmpsiXHEE4lqIfgsHj3oI0GAV5yh1GbB9s7xPS3AtBFRnhMJA2ySo0ff-mvcUsAasAYJLZ0c4bTNncb2LSFVbNagbjmb_dqqk" />
                        <img class="w-12 h-12 rounded-full border-2 border-white object-cover" data-alt="Close up portrait of a professional man, soft natural lighting, high-end business photography style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCmhq6E0gRxB0RZC4iFX-7j_aQxJ3dpcOX78-XAB3auidbcrxWsGRrJT5ZD1trXWzQAAbXLogV8dhEo_hfNoPNM9boWlMFhwVInaLP-Ooc3dCsMQvD6hNfP6oLByY5jpKGcerrnxIKy4vaizjMKJe7KvV0GmGZvywL0-44T4Br0k0rL_utoPrKHdpDtDBqTmCLdF9cDT4mQVF3j3QxUE3n1INRiSJ_C-bUSzoLe-Be_uz-i7C9XRKrPUeD1KQs5TE8aysf-Sy4XL6E" />
                        <img class="w-12 h-12 rounded-full border-2 border-white object-cover" data-alt="Close up portrait of a professional support specialist, bright airy lighting, minimalist background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAJjzJBpRD2lN02OSZbCea0oyoBmvmYg142Slg2q_rEWibOKMAZ4DVWzIG_QrhGIZm6VagXsnYPRYp92qrY5AZaOdSEkjEQGwxoA5HOGNEcWRv_6DOL_WS5bwjTSsihGvAunnTy3uMY80uMUqclOg0FfUbJAz1M7YzBso7TeCrtdT5uM7P4rH1XaK3oMD7fdYG4gioGDSCyGdJZUKvwL1TWbKXnnbUWEpYphfNPL_hdMX0CwmKyJP4jseRSG_lca-k_ChcQbTlofqM" />
                        <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-caps text-[10px] border-2 border-white">+12</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section -->
    <section class="py-section-padding bg-surface">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter">
            <div class="text-center mb-16 space-y-4">
                <span class="font-label-caps text-label-caps text-primary tracking-widest">TRANSPARENT PRICING</span>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Choose Your Path to Growth</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Starter Plan -->
                <div class="bg-white rounded-[2rem] p-10 border border-border-subtle hover:border-primary-container transition-colors group">
                    <div class="mb-8">
                        <h3 class="font-headline-md text-headline-md mb-2">Starter Plan</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Perfect for boutique laundry shops entering the digital space.</p>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-headline-lg">Free</span>
                        </div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant mt-2">X% PER TRANSACTION</p>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-status-success text-sm" data-icon="check_circle">check_circle</span>
                            Standard Logistics Console
                        </li>
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-status-success text-sm" data-icon="check_circle">check_circle</span>
                            Community Support
                        </li>
                        <li class="flex items-center gap-3 font-body-sm text-body-sm opacity-50">
                            <span class="material-symbols-outlined text-sm" data-icon="block">block</span>
                            Zero Transaction Fees
                        </li>
                    </ul>
                    <button class="w-full border border-border-subtle py-4 rounded-xl font-bold font-label-caps text-label-caps group-hover:bg-primary group-hover:text-on-primary group-hover:border-primary transition-all">Get Started for Free</button>
                </div>
                <!-- Pro Plan -->
                <div class="bg-primary text-on-primary rounded-[2rem] p-10 relative overflow-hidden shadow-2xl scale-105">
                    <div class="absolute top-0 right-0 px-6 py-2 bg-white/20 font-label-caps text-[10px] rounded-bl-xl">MOST POPULAR</div>
                    <div class="mb-8">
                        <h3 class="font-headline-md text-headline-md mb-2">Pro Plan</h3>
                        <p class="font-body-sm text-body-sm opacity-80">For high-volume merchants scaling their operations nationwide.</p>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-headline-lg">$X</span>
                            <span class="font-body-lg text-body-lg">/month</span>
                        </div>
                        <p class="font-label-caps text-label-caps opacity-80 mt-2">0% TRANSACTION FEES</p>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-white text-sm" data-icon="check_circle">check_circle</span>
                            Advanced Operations Console
                        </li>
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-white text-sm" data-icon="check_circle">check_circle</span>
                            Priority 24/7 Chat Support
                        </li>
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-white text-sm" data-icon="check_circle">check_circle</span>
                            Live Driver Tracking API
                        </li>
                        <li class="flex items-center gap-3 font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-white text-sm" data-icon="check_circle">check_circle</span>
                            Unlimited Monthly Orders
                        </li>
                    </ul>
                    <button class="w-full bg-white text-primary py-4 rounded-xl font-bold font-label-caps text-label-caps hover:bg-surface-container-high transition-colors">Go Pro Today</button>
                </div>
            </div>
        </div>
    </section>
    <!-- Global Trust Stats -->
    <section class="py-24 bg-white border-y border-border-subtle">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-2">
                <p class="font-display text-headline-lg text-primary">500+</p>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Merchant Partners</p>
            </div>
            <div class="space-y-2">
                <p class="font-display text-headline-lg text-primary">1.2M</p>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Orders Delivered</p>
            </div>
            <div class="space-y-2">
                <p class="font-display text-headline-lg text-primary">99.9%</p>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Uptime SLA</p>
            </div>
            <div class="space-y-2">
                <p class="font-display text-headline-lg text-primary">4.9/5</p>
                <p class="font-label-caps text-label-caps text-on-surface-variant">Customer Rating</p>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-surface-container-lowest pt-20 pb-10">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="space-y-6">
                    <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">The clinical infrastructure for the modern hospitality logistics industry.</p>
                </div>
                <div>
                    <h4 class="font-label-caps text-label-caps text-on-surface mb-6">Product</h4>
                    <ul class="space-y-4 font-body-sm text-body-sm text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Merchant Console</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Live Tracking</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Customer Chat</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Logistics Hub</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-label-caps text-label-caps text-on-surface mb-6">Company</h4>
                    <ul class="space-y-4 font-body-sm text-body-sm text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">About Us</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Careers</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Press Kit</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-label-caps text-label-caps text-on-surface mb-6">Join Our Newsletter</h4>
                    <div class="flex gap-2">
                        <input class="flex-1 bg-surface-wash border border-border-subtle rounded-lg px-4 py-2 font-body-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="Email address" type="email" />
                        <button class="bg-primary text-on-primary p-2 rounded-lg material-symbols-outlined" data-icon="arrow_forward">arrow_forward</button>
                    </div>
                </div>
            </div>
            <div class="pt-8 border-t border-border-subtle flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant">© 2024 LaundryTrack. All rights reserved.</p>
                <div class="flex gap-8">
                    <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                    <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bottom Nav for Mobile -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 md:hidden bg-surface-container-lowest dark:bg-inverse-surface border-t border-border-subtle shadow-lg rounded-t-full">
        <a class="flex flex-col items-center justify-center text-primary bg-primary-container rounded-full px-4 py-1" href="#">
            <span class="material-symbols-outlined" data-icon="home">home</span>
            <span class="font-label-caps text-[10px]">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
            <span class="font-label-caps text-[10px]">Orders</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="chat">chat</span>
            <span class="font-label-caps text-[10px]">Chat</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant" href="#">
            <span class="material-symbols-outlined" data-icon="query_stats">query_stats</span>
            <span class="font-label-caps text-[10px]">Track</span>
        </a>
    </nav>
</body>

</html>