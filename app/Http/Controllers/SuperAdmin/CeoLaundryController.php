<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\SubscriptionPlan;
use App\Models\User; // ◄ TAMBAHAN: Import Model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // ◄ TAMBAHAN: Untuk Database Transaction
use Illuminate\Support\Facades\Hash; // ◄ TAMBAHAN: Untuk Hashing Password Owner
use Illuminate\Support\Facades\Storage;

class CeoLaundryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $query = Laundry::with(['subscriptionPlan', 'users' => function($q) {
            $q->where('role', 'owner'); // Menampilkan data Owner toko tersebut
        }])->withCount('users');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }

        $laundries = $query->paginate(10);
        $plans = SubscriptionPlan::all();

        return view('superadmin.laundries.index', compact('laundries', 'plans', 'search'));
    }

    // ─── TAMBAHAN BARU: Menampilkan Halaman Form Tambah Tenant ───
    public function create()
    {
        // Mengambil semua pilihan paket untuk dimasukkan ke dalam dropdown form penambahan tenant
        $plans = SubscriptionPlan::all();
        return view('superadmin.laundries.create', compact('plans'));
    }

    // ─── TAMBAHAN: Fitur Manual Pendaftaran Tenant oleh Super Admin ───
    public function store(Request $request)
    {
        // 1. Validasi Input Gabungan (Data Toko + Data Akun Owner)
        $request->validate([
            // Validasi Laundry
            'name'                 => 'required|string|max:255',
            'address'              => 'required|string',
            'phone'                => 'required|string|max:20',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB

            // Validasi Owner Toko
            'owner_name'           => 'required|string|max:255',
            'owner_email'          => 'required|string|email|unique:users,email',
            'owner_password'       => 'required|string|min:8',
        ]);

        // 2. Gunakan Transaction agar jika salah satu insert gagal, database otomatis di-rollback (dibatalkan)
        DB::beginTransaction();

        try {
            // Handle upload gambar jika ada
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('laundries', 'public');
            }

            // A. Ambil durasi default dari paket langganan yang dipilih (misal: 30 hari)
            $plan = SubscriptionPlan::find($request->subscription_plan_id);

            // B. Insert ke Tabel Laundries
            $laundry = Laundry::create([
                'name'                 => $request->name,
                'address'              => $request->address,
                'phone'                => $request->phone,
                'image'                => $imagePath,
                'latitude'             => $request->latitude,
                'longitude'            => $request->longitude,
                'subscription_plan_id' => $request->subscription_plan_id,
                'subscription_type'    => $plan->name ?? 'regular',
                'subscription_until'   => now()->addDays(30), // Set aktif 30 hari ke depan
                'unpaid_commission'    => 0, // Nilai awal komisi CEO 0 rupiah
                'status'               => 'active',
                'is_active'            => true,
            ]);

            // C. Insert ke Tabel Users (Akun Owner yang menguasai laundry_id tersebut)
            User::create([
                'name'       => $request->owner_name,
                'email'      => $request->owner_email,
                'password'   => Hash::make($request->owner_password),
                'role'       => 'owner', // Sesuai filter relasi di method index() Anda
                'laundry_id' => $laundry->id, // Mengikat user ke toko yang baru lahir
                'is_active'  => true,
            ]);

            // Jika semua proses aman, simpan permanen ke database
            DB::commit();

            return back()->with('success', "Tenant Toko {$laundry->name} & Akun Owner berhasil didaftarkan ke ekosistem.");

        } catch (\Exception $e) {
            // Jika ada error (misal: storage penuh atau query crash), batalkan semua insert sebelumnya
            DB::rollBack();

            // Hapus gambar yang terlanjur ter-upload jika gagal di tengah jalan
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()->with('error', 'Gagal mendaftarkan Tenant: ' . $e->getMessage());
        }
    }

    public function updatePlan(Request $request, Laundry $laundry)
    {
        $request->validate([
            // Diubah menjadi nullable/required sesuai kebutuhan Anda
            'subscription_plan_id' => 'required|exists:subscription_plans,id'
        ]);

        $laundry->update([
            'subscription_plan_id' => $request->subscription_plan_id
        ]);

        return back()->with('success', "Paket untuk toko {$laundry->name} berhasil diubah.");
    }

    public function toggleStatus(Laundry $laundry)
    {
        // Membalikkan status: Jika aktif jadi blokir, jika blokir jadi aktif
        $laundry->update([
            'is_active' => !$laundry->is_active
        ]);

        $statusMessage = $laundry->is_active ? 'diaktifkan kembali.' : 'diblokir sementara.';
        
        return back()->with('success', "Toko {$laundry->name} berhasil {$statusMessage}");
    }
}