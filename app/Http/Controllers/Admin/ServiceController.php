<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

/**
 * ServiceController
 *
 * Bertanggung jawab untuk semua operasi CRUD pada tabel `services`.
 * Namespace: App\Http\Controllers\Admin  →  dikelompokkan terpisah
 * dari controller customer/kasir agar mudah dikelola.
 *
 * Route resource akan generate 7 route otomatis:
 *   GET    /admin/services           → index()
 *   GET    /admin/services/create    → create()
 *   POST   /admin/services           → store()
 *   GET    /admin/services/{id}      → show()   (tidak kita pakai)
 *   GET    /admin/services/{id}/edit → edit()
 *   PUT    /admin/services/{id}      → update()
 *   DELETE /admin/services/{id}      → destroy()
 */
class ServiceController extends Controller
{
    // ─── Daftar Ikon yang boleh dipilih (Lucide icon names) ──────────
    // Dipakai di form create/edit sebagai pilihan icon layanan
    private array $availableIcons = [
        'shirt'       => 'Cuci + Setrika',
        'droplets'    => 'Cuci Saja',
        'zap'         => 'Setrika / Express',
        'clock'       => 'Express / Waktu',
        'wind'        => 'Angin / Kering',
        'star'        => 'Premium',
        'package'     => 'Paket',
        'sparkles'    => 'Eksklusif',
    ];

    // ──────────────────────────────────────────────────────────────────
    // INDEX — Tampilkan daftar semua layanan
    // GET /admin/services
    // ──────────────────────────────────────────────────────────────────
    public function index(): View
    {
        // Ambil semua layanan, urutkan dari harga terendah
        // withCount('orders') → hitung berapa order pakai layanan ini
        $services = Service::withCount('orders')
            ->orderBy('price_per_kg')
            ->get();

        // Hitung total pendapatan per layanan dari order yang selesai
        $revenuePerService = \App\Models\Order::query()
            ->selectRaw('service_id, SUM(total_price) as total_revenue, COUNT(*) as order_count')
            ->where('status', 'finished')
            ->groupBy('service_id')
            ->pluck('total_revenue', 'service_id');

        return view('admin.services.index', compact('services', 'revenuePerService'));
    }

    // ──────────────────────────────────────────────────────────────────
    // CREATE — Tampilkan form tambah layanan baru
    // GET /admin/services/create
    // ──────────────────────────────────────────────────────────────────
    public function create(): View
    {
        return view('admin.services.create', [
            'icons'   => $this->availableIcons,
            'service' => new Service(), // kosong, untuk konsistensi dengan edit()
        ]);
    }

    // ──────────────────────────────────────────────────────────────────
    // STORE — Simpan layanan baru ke database
    // POST /admin/services
    // ──────────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name'           => [
                'required',
                'string',
                'max:100',
                // Nama layanan harus unik di tabel services
                Rule::unique('services', 'name'),
            ],
            'description'    => 'nullable|string|max:500',
            'price_per_kg'   => 'required|numeric|min:500|max:999999',
            'estimated_days' => 'required|integer|min:0|max:30',
            'icon'           => ['nullable', 'string', Rule::in(array_keys($this->availableIcons))],
            'is_active'      => 'nullable|boolean',
        ], [
            // Pesan error dalam Bahasa Indonesia
            'name.required'           => 'Nama layanan wajib diisi.',
            'name.unique'             => 'Nama layanan ini sudah ada. Gunakan nama lain.',
            'price_per_kg.required'   => 'Harga per kg wajib diisi.',
            'price_per_kg.min'        => 'Harga minimal Rp 500/kg.',
            'estimated_days.required' => 'Estimasi hari wajib diisi.',
            'estimated_days.min'      => 'Estimasi hari tidak boleh negatif.',
        ]);

        // Checkbox 'is_active' tidak dikirim jika tidak dicentang
        // sehingga kita fallback ke false jika tidak ada
        $validated['is_active'] = $request->boolean('is_active', true);

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Layanan \"{$validated['name']}\" berhasil ditambahkan!");
    }

    // ──────────────────────────────────────────────────────────────────
    // EDIT — Tampilkan form ubah layanan
    // GET /admin/services/{service}/edit
    // ──────────────────────────────────────────────────────────────────
    public function edit(Service $service): View
    {
        // Route Model Binding: Laravel otomatis ambil Service berdasarkan {id}
        // Jika tidak ditemukan → otomatis 404
        return view('admin.services.edit', [
            'service' => $service,
            'icons'   => $this->availableIcons,
        ]);
    }

    // ──────────────────────────────────────────────────────────────────
    // UPDATE — Simpan perubahan layanan
    // PUT /admin/services/{service}
    // ──────────────────────────────────────────────────────────────────
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => [
                'required', 'string', 'max:100',
                // Unique tapi kecualikan ID layanan yang sedang diedit
                Rule::unique('services', 'name')->ignore($service->id),
            ],
            'description'    => 'nullable|string|max:500',
            'price_per_kg'   => 'required|numeric|min:500|max:999999',
            'estimated_days' => 'required|integer|min:0|max:30',
            'icon'           => ['nullable', 'string', Rule::in(array_keys($this->availableIcons))],
            'is_active'      => 'nullable|boolean',
        ], [
            'name.required'         => 'Nama layanan wajib diisi.',
            'name.unique'           => 'Nama layanan ini sudah dipakai layanan lain.',
            'price_per_kg.required' => 'Harga per kg wajib diisi.',
            'price_per_kg.min'      => 'Harga minimal Rp 500/kg.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        // Simpan harga lama untuk ditampilkan di flash message
        $oldPrice = $service->price_per_kg;
        $service->update($validated);

        $priceNote = '';
        if ((float)$oldPrice !== (float)$validated['price_per_kg']) {
            $priceNote = " (harga diubah dari Rp "
                . number_format($oldPrice, 0, ',', '.')
                . " → Rp " . number_format($validated['price_per_kg'], 0, ',', '.') . "/kg)";
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Layanan \"{$service->name}\" berhasil diperbarui{$priceNote}.");
    }

    // ──────────────────────────────────────────────────────────────────
    // DESTROY — Hapus layanan
    // DELETE /admin/services/{service}
    // ──────────────────────────────────────────────────────────────────
    public function destroy(Service $service): RedirectResponse
    {
        // Cek apakah layanan pernah dipakai di order aktif
        // Jika iya, tidak boleh dihapus (hanya bisa dinonaktifkan)
        $activeOrderCount = $service->orders()
            ->whereNotIn('status', ['finished', 'cancelled'])
            ->count();

        if ($activeOrderCount > 0) {
            return back()->withErrors([
                'error' => "Layanan \"{$service->name}\" tidak bisa dihapus karena masih ada {$activeOrderCount} order aktif yang menggunakannya. Nonaktifkan saja."
            ]);
        }

        $totalOrders = $service->orders()->count();
        if ($totalOrders > 0) {
            // Ada order historis → soft-delete dengan nonaktifkan saja
            $service->update(['is_active' => false]);
            return redirect()
                ->route('admin.services.index')
                ->with('success', "Layanan \"{$service->name}\" dinonaktifkan (ada {$totalOrders} order historis, tidak bisa dihapus permanen).");
        }

        $name = $service->name;
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Layanan \"{$name}\" berhasil dihapus.");
    }

    // ──────────────────────────────────────────────────────────────────
    // TOGGLE — Aktifkan / nonaktifkan layanan via AJAX
    // PATCH /admin/services/{service}/toggle
    // ──────────────────────────────────────────────────────────────────
    public function toggle(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';

        if (request()->wantsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => $service->is_active,
                'message'   => "Layanan \"{$service->name}\" berhasil {$status}.",
            ]);
        }

        return back()->with('success', "Layanan \"{$service->name}\" berhasil {$status}.");
    }
}