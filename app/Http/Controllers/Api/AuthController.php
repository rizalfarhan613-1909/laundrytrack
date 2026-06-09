<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input dari Flutter
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cek apakah email dan password cocok dengan database
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password yang kamu masukkan salah.'
            ], 401); // 401 berarti Unauthorized
        }

        // 3. Jika cocok, ambil data user tersebut
        $user = User::where('email', $request->email)->first();

        // 4. Generate Token (Menggunakan Laravel Sanctum bawaan Laravel modern)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kembalikan respons JSON ke Flutter
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Pastikan di tabel users kamu ada kolom 'role' (admin/kasir/kurir)
            ]
        ], 200);
    }
}