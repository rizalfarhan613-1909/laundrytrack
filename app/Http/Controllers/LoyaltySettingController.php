<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltySetting;
use App\Models\Laundry;

class LoyaltySettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan poin
     */
    public function index()
    {
        // Deteksi ID Laundry berdasarkan user yang sedang login (mengikuti logika OrderController kamu)
        $realLaundryId = auth()->user()->laundry_id ?? Laundry::where('user_id', auth()->id())->value('id');

        if (!$realLaundryId) {
            return redirect()->back()->with('error', 'Akses ditolak. Toko laundry tidak ditemukan.');
        }

        // Trik Aman: Otomatis buat data default jika di database belum ada baris untuk toko ini
        $setting = LoyaltySetting::firstOrCreate(
            ['laundry_id' => $realLaundryId],
            [
                'is_active' => false,         // Default: fitur nonaktif
                'threshold_amount' => 50000,  // Default: kelipatan Rp 50.000
                'points_earned' => 1          // Default: mendapatkan 1 poin
            ]
        );

        return view('kasir.loyalty.settings', compact('setting'));
    }

    /**
     * Menyimpan pembaruan pengaturan poin
     */
    public function update(Request $request)
    {
        $realLaundryId = auth()->user()->laundry_id ?? Laundry::where('user_id', auth()->id())->value('id');
        
        $setting = LoyaltySetting::where('laundry_id', $realLaundryId)->firstOrFail();

        $validated = $request->validate([
            'threshold_amount' => 'required|numeric|min:1000',
            'points_earned'    => 'required|integer|min:1',
        ]);

        // Update data ke database
        $setting->update([
            'is_active'        => $request->has('is_active'), // Berharga true jika checkbox dicentang, false jika tidak
            'threshold_amount' => $validated['threshold_amount'],
            'points_earned'    => $validated['points_earned'],
        ]);

        return redirect()->back()->with('success', 'Pengaturan poin loyalitas berhasil diperbarui!');
    }
}