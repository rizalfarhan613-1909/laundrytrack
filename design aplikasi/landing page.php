<!DOCTYPE html>

<html lang="en">

<head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
        <style>
                .material-symbols-outlined {
                        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
                }

                body {
                        font-family: 'Inter', sans-serif;
                        scroll-behavior: smooth;
                }
        </style>
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
</head>

<body class="bg-background text-on-surface">
        <!-- Top Navigation Bar -->
        <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-gutter h-16 max-w-container-max mx-auto bg-surface border-b border-border-subtle">
                <div class="flex items-center gap-8">
                        <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
                        <nav class="hidden md:flex gap-6 items-center">
                                <a class="text-primary font-bold border-b-2 border-primary pb-1 font-body-lg text-body-lg" href="#">Dashboard</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Orders</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Inventory</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Financials</a>
                                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors font-body-lg text-body-lg" href="#">Marketing</a>
                        </nav>
                </div>
                <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-low border border-border-subtle">
                                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                                <input class="bg-transparent border-none focus:ring-0 text-body-sm font-body-sm w-32" placeholder="Search orders..." type="text" />
                        </div>
                        <button class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-body-lg text-body-lg font-bold cursor-pointer transition-all duration-200 active:scale-95 shadow-sm">New Order</button>
                        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">notifications</span>
                        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">settings</span>
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-border-subtle">
                                <img alt="Owner Profile" data-alt="A professional close-up portrait of a laundry business owner smiling warmly in a bright, modern office setting. The background is softly blurred with hints of white walls and organized retail shelving. The lighting is clean and high-key, emphasizing a reliable and high-end hospitality aesthetic with a palette of crisp whites and soft blues." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjG1gmtfHLQACTCi4UgW2X6hCIRuKol6d9r7FpjfuYtj0In3zD7JVqI992bEF64fUzpD9xHGoVrEwbFWlb9FSFQYyPMKoYFR6263utMWJRKphUPPEouhHIczK0ktx9e4B9RVPkMJNJCWTc7Ggj2wwvY5qsx0DZAtH6kzBEz-7F661ztCq9R4lTXT483GKInfOIrTSh98bl_jd0k7cheXoRt68BVqVjXck3RziWR7pujMvHoSzs0nOT8PIhvD2ZTSOf8DQTNURB2ZU" />
                        </div>
                </div>
        </header>
        <main class="pt-16">
                <!-- Hero Section -->
                <section class="relative w-full overflow-hidden bg-surface-wash py-24 md:py-32 border-b border-border-subtle">
                        <div class="max-w-container-max mx-auto px-gutter grid lg:grid-cols-2 gap-12 items-center">
                                <div>
                                        <span class="inline-block font-label-caps text-label-caps text-primary px-3 py-1 bg-primary-fixed rounded-full mb-6">LOGISTICS REDEFINED</span>
                                        <h1 class="font-display text-display text-on-surface mb-6 leading-tight">Fresh laundry, tracked in real-time.</h1>
                                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg leading-relaxed">
                                                Transforming the fabric of laundry management. Experience high-end hospitality for your garments with real-time updates and seamless owner tools to optimize every thread of your business.
                                        </p>
                                        <div class="flex flex-col sm:flex-row gap-4">
                                                <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-headline-md text-headline-md font-bold transition-all hover:bg-primary-container active:scale-95 shadow-lg">Track My Order</button>
                                                <button class="border border-border-subtle bg-white text-on-surface px-8 py-4 rounded-xl font-headline-md text-headline-md font-bold transition-all hover:bg-surface-container-low active:scale-95">Merchant Portal</button>
                                        </div>
                                </div>
                                <div class="relative group">
                                        <div class="absolute -inset-4 bg-gradient-to-tr from-primary/10 to-transparent rounded-3xl blur-2xl"></div>
                                        <div class="relative rounded-3xl overflow-hidden border border-border-subtle bg-white shadow-2xl">
                                                <img alt="Real-time Tracking Interface" data-alt="A high-fidelity digital interface displaying a clean, minimalist laundry tracking dashboard on a sleek tablet screen. The UI features smooth progress bars, elegant icons for washing and folding stages, and a localized map view. The scene is set in a bright, modern laundry lounge with high-end machinery and polished surfaces. The aesthetic is clinical yet premium, using a palette of white, slate, and vibrant primary blue." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCU2Xyg8aqr3ZL8qtlblb43rLr2Ee5hZh5160yp21gdtb30rtiuWbnOnsg1dLpEjsZrj7GutjPcukK5AXT1Ip2xnLokCXFRRqOR0HRMl802vubozjtD5f5ZFAhwjgHj48JKvawoZItwJxRSFx-zOPnqq6uzZpIkcjzVApCJ6S37_1z81HpFqAG62wTv0QTzyTRI1mKQYQxXltrp3XpNp2c3uTFUrjXuY-PJc2pb2fbZQUI3pmlTwqeqHRw8IFR5e9stR-WLmzlPUWo" />
                                        </div>
                                </div>
                        </div>
                </section>
                <!-- Key Features: Bento Grid -->
                <section class="py-section-padding bg-surface">
                        <div class="max-w-container-max mx-auto px-gutter">
                                <div class="text-center mb-16">
                                        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4">Precision-Crafted Logistics</h2>
                                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Uncluttered interfaces for complex operations. We prioritize speed and clarity in every interaction.</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-auto md:h-[600px]">
                                        <!-- Real-time Tracking -->
                                        <div class="md:col-span-7 bg-white p-10 rounded-3xl border border-border-subtle flex flex-col justify-between group hover:border-primary transition-colors cursor-pointer overflow-hidden relative">
                                                <div class="relative z-10">
                                                        <span class="material-symbols-outlined text-primary mb-4 text-4xl">my_location</span>
                                                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Real-time Tracking</h3>
                                                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs">Follow your garments from the moment they are picked up until they arrive back fresh at your doorstep.</p>
                                                </div>
                                                <div class="absolute right-0 bottom-0 translate-y-4 translate-x-4 opacity-10 group-hover:opacity-100 transition-all duration-500 scale-110 group-hover:scale-100">
                                                        <img alt="Logistics Flow" class="rounded-tl-3xl" data-alt="An abstract, top-down view of organized, high-quality linen folded with surgical precision on a clean metallic surface. The lighting is soft and directional, highlighting the textures of the fabric. The overall mood is clinical, clean, and extremely professional, reflecting a high level of craft in garment care." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9uDMBQl6Ryu3y1GAswlBXv2wGi0wdPxyggClPdirqRyrj3TWlMkbvGaBqQYFpeylXoSgBZD35e2zu3iNS0c2b5DwkeW7PNhrYZCzVc8WDL-IpFPg4EoWq48deoYR1Vcw8qZLgkgI6FpvHz-68yij1FAixbOvJgdR118UsVbIFYUEpXjfsivdQUWRVrjmCa746dlcn7Omp0Uj8TLNOXuDVVVFd9ry-TGWGuNyPdtpU2qwOICCirT7V6HLKCp3uADFKBJRIF3bpoT4" />
                                                </div>
                                        </div>
                                        <!-- Contextual Chat -->
                                        <div class="md:col-span-5 bg-surface-container-low p-10 rounded-3xl border border-border-subtle flex flex-col items-center text-center justify-center hover:bg-white transition-all cursor-pointer">
                                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-6">
                                                        <span class="material-symbols-outlined text-primary text-3xl">chat_bubble</span>
                                                </div>
                                                <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Contextual Chat</h3>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">Instant communication tied directly to specific orders, ensuring no special requests are ever missed.</p>
                                        </div>
                                        <!-- Financial Ops -->
                                        <div class="md:col-span-5 bg-inverse-surface p-10 rounded-3xl border border-transparent flex flex-col justify-center text-white hover:border-primary-fixed transition-all cursor-pointer">
                                                <span class="material-symbols-outlined text-primary-fixed mb-4 text-4xl">payments</span>
                                                <h3 class="font-headline-md text-headline-md text-surface-bright mb-3">Financial Operations</h3>
                                                <p class="font-body-sm text-body-sm text-surface-variant">Automated billing, expense tracking, and deep financial analytics for the modern laundry merchant.</p>
                                        </div>
                                        <!-- Inventory -->
                                        <div class="md:col-span-7 bg-white p-10 rounded-3xl border border-border-subtle flex items-center gap-8 group hover:border-primary transition-all cursor-pointer">
                                                <div class="flex-1">
                                                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Atomic Inventory</h3>
                                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Track detergent levels, hanger counts, and machinery health with precision-focused management tools.</p>
                                                </div>
                                                <div class="hidden sm:block w-32 h-32 rounded-2xl bg-surface-container-high overflow-hidden">
                                                        <img alt="Clean Inventory" data-alt="A macro photograph of neatly arranged, high-end laundry supplies on a minimalist white shelf. The products are labeled with clean typography. The lighting is bright and airy, creating a clinical and organized aesthetic. The background is a soft-focus clean wall." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB5-bAD1YwWfik8xRTHdnh9VjBhJNq2FR4Tg4fEpBQYP9wmlWj0Z-QsmylEpV0QfUGpCleGqucrfDkkChJdOXMhL47-S-x5oiPATIg-n0FdLajPEuROIpY__EiQ4KCRMqTuaQyNV2gNh4TS3NKzy55RmYjKIWPhkfWgE7VRvfURDFFK1yIpuPGPzkCJqAKM4Y6LjHpe6f0EHjtfLsoGBTdr-niF15zkNKQM50pZvOJaVdVlxEp1bZdIB8MfmNzYE_uh1CLPlJZsfX8" />
                                                </div>
                                        </div>
                                </div>
                        </div>
                </section>
                <!-- How it Works: Stepper -->
                <section class="py-section-padding bg-surface-wash">
                        <div class="max-w-container-max mx-auto px-gutter">
                                <div class="grid lg:grid-cols-2 gap-20">
                                        <div>
                                                <h2 class="font-display text-display text-on-surface mb-8">Elegance in Execution</h2>
                                                <div class="space-y-12">
                                                        <!-- Step 1 -->
                                                        <div class="flex gap-6 relative">
                                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold z-10">1</div>
                                                                <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-border-subtle -mb-12"></div>
                                                                <div>
                                                                        <h4 class="font-headline-md text-headline-md text-on-surface mb-2">Schedule &amp; Tag</h4>
                                                                        <p class="font-body-lg text-body-lg text-on-surface-variant">Simply book a pickup. Our system generates unique ID tags using <span class="font-data-mono text-data-mono bg-surface-container px-1 rounded">LaundryTrack_QR</span> for 100% item accountability.</p>
                                                                </div>
                                                        </div>
                                                        <!-- Step 2 -->
                                                        <div class="flex gap-6 relative">
                                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold z-10">2</div>
                                                                <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-border-subtle -mb-12"></div>
                                                                <div>
                                                                        <h4 class="font-headline-md text-headline-md text-on-surface mb-2">The Lab Process</h4>
                                                                        <p class="font-body-lg text-body-lg text-on-surface-variant">Items are treated in a clinical environment. Each stage—wash, dry, press—is updated in the app instantly by our technicians.</p>
                                                                </div>
                                                        </div>
                                                        <!-- Step 3 -->
                                                        <div class="flex gap-6">
                                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold z-10">3</div>
                                                                <div>
                                                                        <h4 class="font-headline-md text-headline-md text-on-surface mb-2">Premium Delivery</h4>
                                                                        <p class="font-body-lg text-body-lg text-on-surface-variant">Fresh, crisp garments arrive in eco-friendly packaging. Confirm your satisfaction directly through the real-time order interface.</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="hidden lg:block">
                                                <div class="sticky top-32 rounded-3xl overflow-hidden border border-border-subtle aspect-square">
                                                        <img alt="Process Detail" class="w-full h-full object-cover" data-alt="A focused close-up of a professional garment worker's hands inspecting a clean white shirt under soft studio lighting. The background features high-end, stainless steel commercial laundry equipment. The color palette is composed of cool blues, whites, and metallic silvers, creating a premium and reliable atmosphere of meticulous care." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBwLbRk5bS1K6O6LbMpCg-PVV-SVG6b1EkeQDHq8TM82jNkdquoqaiq0I76rmvuiR25FkmwuOShlVtJmULIuucIKRZptVSvEsioMedNpCo-6pDdf39wVsgYhQDRReFtxugqVBf0LtY8xI2uCEyPAp_yKikcMZbmqWsr5zR_cBajlUJjDXnGMbQ_IqevgX47rdijoTWw8XM4lXvc5rJBrOa1n-ynuz4xFdij5shn1qWLIyhwOEh8LVdxxqZMRqMRwP-E1YsW5BK2PLg" />
                                                </div>
                                        </div>
                                </div>
                        </div>
                </section>
                <!-- CTA Section -->
                <section class="py-section-padding bg-surface">
                        <div class="max-w-container-max mx-auto px-gutter">
                                <div class="bg-primary-container/10 border border-primary/20 rounded-[40px] p-12 md:p-20 text-center relative overflow-hidden">
                                        <div class="absolute top-0 right-0 p-8 opacity-20 select-none">
                                                <span class="material-symbols-outlined text-9xl text-primary">local_laundry_service</span>
                                        </div>
                                        <div class="relative z-10 max-w-3xl mx-auto">
                                                <h2 class="font-display text-display text-primary mb-6">Ready to elevate your laundry experience?</h2>
                                                <p class="font-body-lg text-body-lg text-on-surface-variant mb-12">Whether you're a customer seeking perfection or an owner pursuing excellence, LaundryTrack is your partner in premium logistics.</p>
                                                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                                                        <div class="p-8 bg-white rounded-3xl border border-border-subtle text-left flex-1 hover:shadow-xl transition-shadow group">
                                                                <span class="font-label-caps text-label-caps text-primary mb-4 block">FOR CUSTOMERS</span>
                                                                <h3 class="font-headline-md text-headline-md text-on-surface mb-4">Book Your First Order</h3>
                                                                <button class="w-full py-3 bg-primary text-on-primary rounded-xl font-bold active:scale-95 transition-transform">Get Started</button>
                                                        </div>
                                                        <div class="p-8 bg-white rounded-3xl border border-border-subtle text-left flex-1 hover:shadow-xl transition-shadow group">
                                                                <span class="font-label-caps text-label-caps text-primary mb-4 block">FOR OWNERS</span>
                                                                <h3 class="font-headline-md text-headline-md text-on-surface mb-4">Launch Your Branch</h3>
                                                                <button class="w-full py-3 bg-inverse-surface text-white rounded-xl font-bold active:scale-95 transition-transform">Add New Branch</button>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </section>
        </main>
        <!-- Footer -->
        <footer class="w-full py-12 px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto border-t border-border-subtle bg-surface-container-highest">
                <div class="flex flex-col items-center md:items-start gap-4 mb-8 md:mb-0">
                        <span class="font-headline-md text-headline-md font-bold text-on-surface">LaundryTrack</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">© 2024 LaundryTrack Logistics. All rights reserved.</p>
                </div>
                <div class="flex gap-8">
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Contact Support</a>
                        <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Merchant Portal</a>
                </div>
        </footer>
        <!-- Bottom Nav Bar (Mobile Only) -->
        <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface border-t border-border-subtle shadow-sm rounded-t-xl">
                <div class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1">
                        <span class="material-symbols-outlined">storefront</span>
                        <span class="font-label-caps text-label-caps">Shops</span>
                </div>
                <div class="flex flex-col items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <span class="font-label-caps text-label-caps">Orders</span>
                </div>
                <div class="flex flex-col items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined">chat_bubble</span>
                        <span class="font-label-caps text-label-caps">Chat</span>
                </div>
                <div class="flex flex-col items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined">person</span>
                        <span class="font-label-caps text-label-caps">Profile</span>
                </div>
        </nav>
</body>

</html>