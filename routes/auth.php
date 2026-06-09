<?php
// routes/auth.php
// File ini di-generate otomatis oleh Laravel Breeze.
// Jika menggunakan Breeze, file ini sudah otomatis ada setelah:
//   php artisan breeze:install blade
//
// Jika TIDAK menggunakan Breeze, buat file ini dengan konten berikut:

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});