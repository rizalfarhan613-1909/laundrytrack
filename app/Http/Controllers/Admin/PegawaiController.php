<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar pegawai yang bekerja di outlet admin saat ini
     */
    public function index()
    {
        // ✨ PERBAIKAN TENANT & ROLE: Hanya mengambil pegawai (kasir & kurir) 
        // yang terikat dengan laundry_id milik admin yang sedang login.
        $pegawai = User::where('laundry_id', auth()->user()->laundry_id)
            ->whereIn('role', ['kasir', 'kurir'])
            ->latest()
            ->get();

        return view('admin.pegawai.index', compact('pegawai'));
    }

    /**
     * Form tambah pegawai
     */
    public function create()
    {
        // Sesuai konsep SaaS, tidak ada lagi pengambilan data model Laundry.
        // Dropdown dihapus karena outlet otomatis dikunci ke laundry_id milik admin di method store.
        return view('admin.pegawai.create');
    }

    /**
     * Menyimpan data pegawai baru otomatis terikat ke outlet admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'     => ['required', 'string', 'max:20'],
            'address'   => ['nullable', 'string'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'], // Wajib 'confirmed' untuk memvalidasi input konfirmasi password
            'role'      => ['required', Rule::in(['kasir', 'kurir'])],
            'is_active' => ['required', 'boolean'],
        ]);

        User::create([
            'laundry_id' => auth()->user()->laundry_id, // ✨ PROTEKSI: Otomatis mengunci ke outlet admin yang sedang login
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'password'   => Hash::make($request->password), // Wajib di-hash untuk keamanan log-in
            'role'       => $request->role,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    /**
     * Form edit data pegawai
     */
    public function edit(User $pegawai)
    {
        // 🔒 PROTEKSI TENANT: Mencegah admin nakal mengubah ID di URL untuk edit pegawai outlet lain
        if ($pegawai->laundry_id !== auth()->user()->laundry_id || !in_array($pegawai->role, ['kasir', 'kurir'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data pegawai ini.');
        }

        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Memperbarui data data pegawai
     */
    public function update(Request $request, User $pegawai)
    {
        // 🔒 PROTEKSI TENANT
        if ($pegawai->laundry_id !== auth()->user()->laundry_id || !in_array($pegawai->role, ['kasir', 'kurir'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data pegawai ini.');
        }

        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pegawai->id)],
            'phone'     => ['required', 'string', 'max:20'],
            'address'   => ['nullable', 'string'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'], // Dibuat nullable agar jika password kosong, tidak ikut terupdate
            'role'      => ['required', Rule::in(['kasir', 'kurir'])],
            'is_active' => ['required', 'boolean'],
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ];

        // Update password hanya jika diisi pada form edit
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus akun pegawai dari sistem
     */
    public function destroy(User $pegawai)
    {
        // 🔒 PROTEKSI TENANT
        if ($pegawai->laundry_id !== auth()->user()->laundry_id || !in_array($pegawai->role, ['kasir', 'kurir'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data pegawai ini.');
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Akun pegawai berhasil dihapus.');
    }

    /**
     * Mengubah status aktif/nonaktif akun pegawai dengan cepat (Route: admin.pegawai.toggle)
     */
    public function toggleStatus(User $user)
    {
        // 🔒 PROTEKSI TENANT
        if ($user->laundry_id !== auth()->user()->laundry_id || !in_array($user->role, ['kasir', 'kurir'])) {
            abort(403, 'Tindakan ilegal terdeteksi.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Status aktivitas pegawai berhasil diubah.');
    }
}