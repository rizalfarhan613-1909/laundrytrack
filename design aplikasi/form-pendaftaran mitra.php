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
            background-color: #F8FAFC;
        }
    </style>
</head>

<body class="font-body-lg text-on-surface">
    <!-- TopNavBar (Minimal for Onboarding Journey) -->
    <header class="bg-surface-container-lowest border-b border-border-subtle fixed top-0 left-0 w-full z-50 h-16 flex items-center">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-gutter max-w-container-max mx-auto">
            <div class="flex items-center gap-2">
                <span class="font-headline-md text-headline-md font-bold text-primary">LaundryTrack</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="font-label-caps text-label-caps text-on-surface-variant">Merchant Onboarding</span>
                <div class="h-8 w-8 rounded-full bg-surface-container-high flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary" data-icon="account_circle">account_circle</span>
                </div>
            </div>
        </div>
    </header>
    <main class="pt-24 pb-section-padding px-margin-mobile md:px-gutter max-w-container-max mx-auto">
        <!-- Progress Indicator -->
        <nav class="mb-12 max-w-3xl mx-auto">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-1/2 left-0 w-full h-[2px] bg-surface-container-high -translate-y-1/2 z-0"></div>
                <!-- Step 1 (Active) -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">1</div>
                    <span class="font-label-caps text-label-caps text-primary">Business</span>
                </div>
                <!-- Step 2 (Upcoming) -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface-container-lowest border-2 border-surface-container-high text-on-surface-variant flex items-center justify-center font-bold">2</div>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">Services</span>
                </div>
                <!-- Step 3 (Upcoming) -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-surface-container-lowest border-2 border-surface-container-high text-on-surface-variant flex items-center justify-center font-bold">3</div>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">Billing</span>
                </div>
            </div>
        </nav>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- Main Form Canvas -->
            <div class="lg:col-span-8">
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-8 md:p-12">
                    <header class="mb-10">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-2">Business Details</h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant">Let's start with the basics. Tell us about your laundry facility to set up your digital storefront.</p>
                    </header>
                    <form class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant">Business Name</label>
                                <input class="border border-border-subtle rounded-lg px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-lg text-body-lg" placeholder="e.g. Pristine Cleaners" type="text" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant">Commercial License ID</label>
                                <input class="border border-border-subtle rounded-lg px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-data-mono text-data-mono" placeholder="L-992384" type="text" />
                            </div>
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant">Business Address</label>
                                <div class="relative">
                                    <input class="w-full border border-border-subtle rounded-lg pl-11 pr-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-lg text-body-lg" placeholder="Search for your facility location..." type="text" />
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="location_on">location_on</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant">Primary Contact Name</label>
                                <input class="border border-border-subtle rounded-lg px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-lg text-body-lg" placeholder="Full name" type="text" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant">Phone Number</label>
                                <input class="border border-border-subtle rounded-lg px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-lg text-body-lg" placeholder="+1 (555) 000-0000" type="tel" />
                            </div>
                        </div>
                        <div class="pt-8 border-t border-border-subtle flex justify-end gap-4">
                            <button class="px-6 py-2.5 rounded-lg border border-border-subtle font-body-lg text-body-lg hover:bg-surface-container-low transition-colors text-on-surface" type="button">Save Draft</button>
                            <button class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-body-lg text-body-lg hover:opacity-90 active:scale-95 transition-all flex items-center gap-2" type="button">
                                Continue to Services
                                <span class="material-symbols-outlined text-[20px]" data-icon="arrow_forward">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Bento Sidebar (Premium Insights) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Visual Card -->
                <div class="bg-primary-container text-on-primary-container rounded-xl overflow-hidden relative min-h-[240px] flex flex-col justify-end p-6">
                    <img alt="Premium laundry facility" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay" data-alt="A high-end, contemporary laundry facility with rows of sleek, stainless steel industrial washing machines. The lighting is clinical and bright, highlighting the pristine white tiled walls and marble folding tables. The scene conveys a sense of high-efficiency hospitality and professional cleanliness with a modern minimalist aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCT4e84j3UzcWUj8QiOH6RHP_ibwO3r7_ruZKKVo2iBedvh2YPAnvP4suf7xMx6VcF95c5BSTIrXlmoGgKPhIQvZmt2NNaNA1zEjhSvvNBfKewmnuVLbhDG5utxkk-7Or_YBhmk3wLSGcDgXGha0J3-sSrpS2U9uyb1Nc9_wxC3zqeIPIhFHEOEkr9bwz536AN7fmAMUGQ8wcMuXEAZ-t61CbPG2iGZaYDV0uAHTvrbqSUmjKJM6oGodwegXjLdn_0TtVrxGrIy6tE" />
                    <div class="relative z-10">
                        <span class="font-label-caps text-label-caps text-on-primary-container mb-2 block uppercase tracking-widest">Why LaundryTrack?</span>
                        <h3 class="font-headline-md text-headline-md font-bold mb-4">Join 5,000+ top-tier laundry merchants.</h3>
                        <p class="font-body-sm text-body-sm opacity-90">Scale your logistics from wash to door with our clinical-grade management console.</p>
                    </div>
                </div>
                <!-- Feature Breakdown Card -->
                <div class="bg-surface-container-low border border-border-subtle rounded-xl p-6">
                    <h4 class="font-label-caps text-label-caps text-on-surface-variant mb-4 uppercase">Next Steps</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-status-success/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[14px] text-status-success font-bold" data-icon="check">check</span>
                            </div>
                            <div>
                                <p class="font-body-sm text-body-sm font-semibold">Service Selection</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Define your dry-cleaning, wash-and-fold, and specialty treatments.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 opacity-50">
                            <div class="w-5 h-5 rounded-full bg-on-surface-variant/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[14px] text-on-surface-variant" data-icon="lock">lock</span>
                            </div>
                            <div>
                                <p class="font-body-sm text-body-sm font-semibold">Subscription Setup</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Choose between fixed monthly plans or scalable per-transaction fees.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Support Card -->
                <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 flex items-center justify-between">
                    <div>
                        <h4 class="font-body-sm text-body-sm font-semibold">Need help onboarding?</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Our concierge team is online.</p>
                    </div>
                    <button class="w-10 h-10 rounded-full border border-border-subtle flex items-center justify-center hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-primary" data-icon="chat_bubble">chat_bubble</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Contextual Footer (Help Only) -->
    <footer class="py-12 border-t border-border-subtle mt-12 bg-surface-container-low">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Merchant Handbook</a>
            </div>
            <p class="font-label-caps text-label-caps text-on-surface-variant">© 2024 LaundryTrack. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>