<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileTokoController extends Controller
{
    /**
     * Tampilkan form edit profil toko laundry
     */
    public function edit()
    {
        $laundryId = Auth::user()->laundry_id;

        if (!$laundryId) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun admin Anda belum ditautkan dengan data toko laundry.');
        }

        $laundry = Laundry::findOrFail($laundryId);

        return view('admin.profile.edit', compact('laundry'));
    }

    /**
     * Proses update data profil toko laundry
     */
    public function update(Request $request)
    {
        $laundryId = Auth::user()->laundry_id;
        $laundry = Laundry::findOrFail($laundryId);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:500',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Proses upload file gambar jika ada perubahan foto toko
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari public storage jika ada untuk menghemat memori
            if ($laundry->image) {
                Storage::disk('public')->delete($laundry->image);
            }
            
            // Simpan gambar baru ke folder storage/app/public/laundries
            $validated['image'] = $request->file('image')->store('laundries', 'public');
        }

        // Jalankan mass assignment update ke tabel laundries
        $laundry->update($validated);

        return back()->with('success', 'Profil toko laundry Anda berhasil diperbarui!');
    }
}