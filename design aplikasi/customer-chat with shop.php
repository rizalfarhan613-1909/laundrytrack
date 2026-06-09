<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Customer Chat - LaundryTrack</title>
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
            color: #191b25;
        }

        .chat-container {
            height: calc(100vh - 128px);
        }

        @media (min-width: 1024px) {
            .chat-container {
                height: calc(100vh - 64px);
            }
        }
    </style>
</head>

<body class="font-body-lg text-body-lg overflow-hidden">
    <!-- TopNavBar (Desktop & Mobile Shell) -->
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-gutter h-16 max-w-container-max mx-auto bg-surface dark:bg-on-background border-b border-border-subtle dark:border-outline-variant">
        <div class="flex items-center gap-6">
            <span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed">LaundryTrack</span>
            <nav class="hidden md:flex gap-6">
                <a class="text-on-surface-variant dark:text-outline-variant font-medium hover:text-primary transition-colors cursor-pointer active:scale-95" href="#">Dashboard</a>
                <a class="text-on-surface-variant dark:text-outline-variant font-medium hover:text-primary transition-colors cursor-pointer active:scale-95" href="#">Orders</a>
                <a class="text-primary dark:text-primary-fixed font-bold border-b-2 border-primary dark:border-primary-fixed pb-1" href="#">Inventory</a>
                <a class="text-on-surface-variant dark:text-outline-variant font-medium hover:text-primary transition-colors cursor-pointer active:scale-95" href="#">Financials</a>
                <a class="text-on-surface-variant dark:text-outline-variant font-medium hover:text-primary transition-colors cursor-pointer active:scale-95" href="#">Marketing</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95" data-icon="notifications">notifications</button>
            <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95" data-icon="settings">settings</button>
            <div class="h-8 w-8 rounded-full overflow-hidden border border-border-subtle">
                <img alt="Owner Profile" data-alt="A professional headshot of a boutique laundry shop owner, wearing a clean linen shirt, looking friendly and approachable. The lighting is soft and natural, with a blurred minimalist interior background reflecting a premium hospitality service environment." src="https://lh3.googleusercontent.com/aida-public/AB6AXuANK8oegskl9qXCaU2q_nU6QyHKJmnAfNJPo_DY01aLO1f3eZ2mtnr0_B7K4LCZAUnsB9JTXk7CyheKlVF_T3DI5xh2bTkeQWTDuhbcFBMjgmtTKkdt5N_8DW1xGZAGT4l2o0xUe269-SmuCjkCAKLb820tIf48yOIp6xWlarsqclX78v953uwzxB119jBSEjAbUFtOQpL-5rbCqGPxeSKOtXabWrxYmGjjgIWmBEKjwJJmGnkydMjFE12XF1GbuiQXQP3s6iR1MhM" />
            </div>
        </div>
    </header>
    <div class="flex pt-16 h-screen">
        <!-- SideNavBar (Desktop Only) -->
        <aside class="hidden lg:flex flex-col h-full w-64 p-4 gap-2 bg-surface-container-low dark:bg-on-background border-r border-border-subtle dark:border-outline-variant">
            <div class="flex items-center gap-3 px-3 py-4 mb-4">
                <div class="h-10 w-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md font-black text-primary dark:text-primary-fixed">LaundryTrack</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Management Suite</p>
                </div>
            </div>
            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                    <span class="font-label-caps text-label-caps">Overview</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="local_laundry_service">local_laundry_service</span>
                    <span class="font-label-caps text-label-caps">Order Queue</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 bg-primary-container text-on-primary-container font-bold rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
                    <span class="font-label-caps text-label-caps">Active Chats</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                    <span class="font-label-caps text-label-caps">Inventory</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="sell">sell</span>
                    <span class="font-label-caps text-label-caps">Price Lists</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="payments">payments</span>
                    <span class="font-label-caps text-label-caps">Payment Tracking</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                    <span class="font-label-caps text-label-caps">Reports</span>
                </a>
            </nav>
            <button class="w-full py-3 px-4 bg-primary text-white font-bold rounded-full mb-4 active:scale-95 transition-all">
                Add New Branch
            </button>
            <div class="border-t border-border-subtle pt-4 space-y-1">
                <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                    <span class="font-body-sm text-body-sm">Support</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all" href="#">
                    <span class="material-symbols-outlined" data-icon="settings">settings</span>
                    <span class="font-body-sm text-body-sm">Settings</span>
                </a>
            </div>
        </aside>
        <!-- Main Content Area (Chat Interface) -->
        <main class="flex-1 flex flex-col bg-surface-wash relative">
            <!-- Chat Header / Shop & Order Info -->
            <div class="flex items-center justify-between px-gutter py-4 bg-white border-b border-border-subtle shrink-0">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl" data-icon="storefront">storefront</span>
                    </div>
                    <div>
                        <h1 class="font-headline-md text-headline-md text-on-surface">Pristine Linens &amp; Co.</h1>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-status-success"></span>
                            <span class="font-label-caps text-label-caps text-status-success">Order #LT-4829 • In Cleaning</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <button class="px-4 py-2 border border-border-subtle rounded-xl font-label-caps text-label-caps hover:bg-surface-container-low transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm" data-icon="info">info</span> Order Details
                    </button>
                    <button class="px-4 py-2 bg-primary text-white rounded-xl font-label-caps text-label-caps active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Call Shop
                    </button>
                </div>
            </div>
            <!-- Messages Canvas -->
            <div class="flex-1 overflow-y-auto p-gutter space-y-6 flex flex-col">
                <!-- System Divider -->
                <div class="flex justify-center my-4">
                    <span class="px-3 py-1 bg-surface-container text-on-surface-variant font-label-caps text-label-caps rounded-full">Today, 10:45 AM</span>
                </div>
                <!-- Shop Message -->
                <div class="flex gap-4 max-w-[80%]">
                    <div class="h-8 w-8 rounded-full bg-surface-variant shrink-0 flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-lg" data-icon="person">person</span>
                    </div>
                    <div class="space-y-1">
                        <div class="bg-white p-4 rounded-2xl rounded-tl-none border border-border-subtle">
                            <p class="font-body-lg text-body-lg">Hello! Your laundry has been picked up and is currently in the wash. We noticed a small loose thread on your silk blouse—would you like us to secure it for you?</p>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-medium px-1">10:46 AM</span>
                    </div>
                </div>
                <!-- User Message -->
                <div class="flex gap-4 max-w-[80%] self-end flex-row-reverse">
                    <div class="h-8 w-8 rounded-full bg-primary shrink-0 flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-lg" data-icon="account_circle">account_circle</span>
                    </div>
                    <div class="space-y-1 items-end flex flex-col">
                        <div class="bg-primary text-white p-4 rounded-2xl rounded-tr-none">
                            <p class="font-body-lg text-body-lg">Yes, please! That would be great. Thank you for catching that.</p>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-medium px-1">10:48 AM • Read</span>
                    </div>
                </div>
                <!-- Shop Message with Image -->
                <div class="flex gap-4 max-w-[80%]">
                    <div class="h-8 w-8 rounded-full bg-surface-variant shrink-0 flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-lg" data-icon="person">person</span>
                    </div>
                    <div class="space-y-1">
                        <div class="bg-white p-2 rounded-2xl rounded-tl-none border border-border-subtle">
                            <div class="rounded-xl overflow-hidden mb-2">
                                <img alt="Laundry Rack" data-alt="A close-up, high-resolution photo of neatly folded premium white linens and a silk blouse on a clinical, polished stainless steel table in a modern laundry facility. The lighting is bright and even, highlighting the clean texture of the fabrics. The aesthetic is ultra-modern and hygienic, consistent with a premium concierge service." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBW4D1nCwnAgnZixirzZPWPCFBm7gDyF61LQq87f1W2SPrwwGte4WR3_6Mee91-YavBNG3OXQAkV8mqJ_3rGy2vfQJu6-NeT6YTlxfIKgPJZkEA06Nnkv-dXlVLeCr4dRPKRCJ-SGLz6KbglNX8fo38UsOlwXURLJ3BXP4hr8gk1dDXQyecM7tOhuS20-6NVwS9UJNZYKBCcGyVuczbH22jaNPHwmdjYXa2WEPEht8lLJ1tjbaJZX48k8Q2vl7enhr_7H1D6v6yDqw" />
                            </div>
                            <div class="p-2">
                                <p class="font-body-lg text-body-lg">Of course! We'll take care of it right away. Here's a quick look at your batch before it moves to steaming.</p>
                            </div>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-medium px-1">11:02 AM</span>
                    </div>
                </div>
                <!-- User Message -->
                <div class="flex gap-4 max-w-[80%] self-end flex-row-reverse">
                    <div class="h-8 w-8 rounded-full bg-primary shrink-0 flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-lg" data-icon="account_circle">account_circle</span>
                    </div>
                    <div class="space-y-1 items-end flex flex-col">
                        <div class="bg-primary text-white p-4 rounded-2xl rounded-tr-none">
                            <p class="font-body-lg text-body-lg">Everything looks perfect. What is the estimated delivery time for today?</p>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-medium px-1">11:15 AM</span>
                    </div>
                </div>
            </div>
            <!-- Input Controls -->
            <div class="p-gutter bg-white border-t border-border-subtle shrink-0">
                <!-- Quick Actions -->
                <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                    <button class="whitespace-nowrap px-4 py-2 bg-surface-container-low border border-border-subtle rounded-full font-label-caps text-label-caps text-primary hover:bg-surface-container-high transition-colors active:scale-95">
                        Request Update
                    </button>
                    <button class="whitespace-nowrap px-4 py-2 bg-surface-container-low border border-border-subtle rounded-full font-label-caps text-label-caps text-primary hover:bg-surface-container-high transition-colors active:scale-95">
                        Edit Delivery Time
                    </button>
                    <button class="whitespace-nowrap px-4 py-2 bg-surface-container-low border border-border-subtle rounded-full font-label-caps text-label-caps text-primary hover:bg-surface-container-high transition-colors active:scale-95">
                        Add Special Request
                    </button>
                </div>
                <!-- Text Input Area -->
                <div class="flex items-center gap-3">
                    <button class="h-12 w-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary hover:bg-surface-container-high active:scale-95 transition-all">
                        <span class="material-symbols-outlined" data-icon="add_a_photo">add_a_photo</span>
                    </button>
                    <div class="flex-1 relative">
                        <input class="w-full h-12 bg-surface-wash border border-border-subtle rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent outline-none font-body-lg text-body-lg transition-all" placeholder="Type a message..." type="text" />
                        <button class="absolute right-2 top-1 h-10 w-10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined" data-icon="mic">mic</span>
                        </button>
                    </div>
                    <button class="h-12 w-12 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/10 hover:bg-primary-container active:scale-95 transition-all">
                        <span class="material-symbols-outlined" data-icon="send">send</span>
                    </button>
                </div>
            </div>
        </main>
    </div>
    <!-- BottomNavBar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex lg:hidden justify-around items-center px-4 py-2 bg-surface dark:bg-on-background border-t border-border-subtle dark:border-outline-variant shadow-sm">
        <div class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant active:bg-surface-variant scale-95 duration-100">
            <span class="material-symbols-outlined" data-icon="storefront">storefront</span>
            <span class="font-label-caps text-label-caps">Shops</span>
        </div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant active:bg-surface-variant scale-95 duration-100">
            <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
            <span class="font-label-caps text-label-caps">Orders</span>
        </div>
        <div class="flex flex-col items-center justify-center bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-full px-4 py-1 active:bg-surface-variant scale-95 duration-100">
            <span class="material-symbols-outlined" data-icon="chat_bubble" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
            <span class="font-label-caps text-label-caps">Chat</span>
        </div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant active:bg-surface-variant scale-95 duration-100">
            <span class="material-symbols-outlined" data-icon="person">person</span>
            <span class="font-label-caps text-label-caps">Profile</span>
        </div>
    </nav>
    <!-- Footer (Standard Branding - Desktop Only in this context) -->
    <footer class="hidden md:flex w-full py-12 px-gutter flex-col md:flex-row justify-between items-center max-w-container-max mx-auto bg-surface-container-highest dark:bg-inverse-surface border-t border-border-subtle dark:border-outline-variant">
        <div class="flex flex-col items-center md:items-start gap-4">
            <span class="font-headline-md text-headline-md font-bold text-on-surface dark:text-surface-bright">LaundryTrack</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant">© 2024 LaundryTrack Logistics. All rights reserved.</span>
        </div>
        <div class="flex gap-8 mt-8 md:mt-0">
            <a class="text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed transition-colors font-body-sm text-body-sm" href="#">Privacy Policy</a>
            <a class="text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed transition-colors font-body-sm text-body-sm" href="#">Terms of Service</a>
            <a class="text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed transition-colors font-body-sm text-body-sm" href="#">Contact Support</a>
            <a class="text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed transition-colors font-body-sm text-body-sm" href="#">Merchant Portal</a>
        </div>
    </footer>
</body>

</html>