<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laundry;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view for Customer.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request for Customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim($request->email)),
        ]);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('customer.dashboard', absolute: false));
    }

    /**
     * =========================================================================
     * ALUR REGISTRASI KHUSUS MITRA / OWNER LAUNDRY (DIPERBARUI & SINKRON DATABASE)
     * =========================================================================
     */

    /**
     * Menampilkan halaman form registrasi khusus Mitra.
     */
    public function createMitra(): View
    {
        return view('auth.register-mitra');
    }

    /**
     * Memproses data pendaftaran Mitra sekaligus data Toko Laundry-nya.
     */
    public function storeMitra(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim($request->email)),
        ]);

        // 1. VALIDASI: Menerima input 'commission' atau 'monthly' dari form Blade
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone'             => ['nullable', 'string', 'max:20'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'laundry_name'      => ['required', 'string', 'max:255'],
            'laundry_address'   => ['required', 'string', 'max:500'],
            'latitude'          => ['required', 'numeric'],
            'longitude'         => ['required', 'numeric'],
            'subscription_type' => ['required', 'string', 'in:commission,monthly'],
        ]);

        // Trik Sinkronisasi: Ubah 'commission' dari form menjadi 'free_commission' agar sesuai ENUM DB kamu
        $dbSubscriptionType = $request->subscription_type === 'commission' ? 'free_commission' : $request->subscription_type;

        // 2. SIMPAN: Memasukkan nilai variabel yang sudah disesuaikan dengan ENUM database
        $laundry = Laundry::create([
            'name'              => $request->laundry_name,
            'address'           => $request->laundry_address,
            'latitude'          => $request->latitude,           
            'longitude'         => $request->longitude,          
            'subscription_type' => $dbSubscriptionType, // Menggunakan nilai hasil filter di atas
            'unpaid_commission' => 0,
            'status'            => 'active',
        ]);

        // 3. SIMPAN: Data user dengan role 'admin'
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'admin',
            'laundry_id' => $laundry->id,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Pendaftaran Berhasil! Selamat datang di LaundryTrack.');
    }
}