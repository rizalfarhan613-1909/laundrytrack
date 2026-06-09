<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; // 👈 Pastikan impor ini ada di paling atas

// Daftarkan route login mobile di sini
Route::post('/login', [AuthController::class, 'login']);