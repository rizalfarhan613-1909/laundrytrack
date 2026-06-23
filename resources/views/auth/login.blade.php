{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LaundryTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center p-4">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
            <div class="w-12 h-12 bg-blue-000 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform">
                <img src="{{ asset('images/logou.png') }}" alt="LaundryTrack Logo" class="h-12 w-auto object-contain">
            </div>
            <span class="font-extrabold text-blue-400 text-2xl">LaundryTrack</span>
        </a>
        <p class="text-gray-400 text-sm mt-2">Masuk ke akun kamu</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8">

            {{-- Errors --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5 flex items-start gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                <div class="text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-green-50 border border-green-100 rounded-xl px-4 py-3 mb-5 text-sm text-green-700">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" id="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-blue-400 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 mt-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Masuk
                </button>
            </form>
        </div>

        <div class="border-t border-gray-50 px-8 py-4 bg-gray-50 text-center">
            <p class="text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline ml-1">Daftar sekarang</a>
            </p>
        </div>
    </div>

    {{-- Demo credentials --}}
    @if(app()->environment('local'))
    <div class="mt-5 bg-amber-50 border border-amber-100 rounded-xl p-4 text-xs text-amber-700">
        <p class="font-bold mb-2">🔑 Demo Akun (Dev only):</p>
        <div class="grid grid-cols-2 gap-1">
            <span class="font-medium">Admin:</span><span>admin@laundrytrack.id / admin123</span>
            <span class="font-medium">Kasir:</span><span>kasir@laundrytrack.id / kasir123</span>
            <span class="font-medium">Kurir:</span><span>kurir@laundrytrack.id / kurir123</span>
            <span class="font-medium">Customer:</span><span>customer@laundrytrack.id / customer123</span>
        </div>
    </div>
    @endif

    <p class="text-center text-xs text-gray-300 mt-6">
        <a href="{{ route('home') }}" class="hover:text-gray-400">← Kembali ke Beranda</a>
    </p>
</div>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>