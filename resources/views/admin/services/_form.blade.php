{{--
    resources/views/admin/services/_form.blade.php
    ───────────────────────────────────────────────
    Partial reusable — dipakai oleh create.blade.php DAN edit.blade.php.
    Variabel yang dibutuhkan dari parent:
      $service  → object Service (baru atau yang diedit)
      $icons    → array ['icon-name' => 'label']
      $action   → URL tujuan form (route create/update)
      $method   → 'POST' atau 'PUT'
--}}

<form method="POST" action="{{ $action }}"
      x-data="serviceForm({{ old('price_per_kg', $service->price_per_kg) ?? 0 }}, {{ old('estimated_days', $service->estimated_days) ?? 2 }})"
      class="space-y-6">

    @csrf
    {{-- Untuk PUT/PATCH (update), tambahkan method spoofing --}}
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- ── Section 1: Info Dasar ──────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-blue-500"></i>
                Informasi Dasar
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nama Layanan --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama Layanan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $service->name) }}"
                       placeholder="Contoh: Cuci + Setrika, Express 6 Jam"
                       maxlength="100"
                       required
                       class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors
                              {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                @error('name')
                    {{-- Tampilkan pesan error validasi --}}
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="2"
                          placeholder="Penjelasan singkat layanan untuk ditampilkan ke customer..."
                          maxlength="500"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description', $service->description) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Maks. 500 karakter</p>
            </div>
        </div>
    </div>

    {{-- ── Section 2: Harga & Waktu ────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2">
                <i data-lucide="banknote" class="w-4 h-4 text-green-500"></i>
                Harga & Estimasi
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Harga per KG --}}
            <div>
                <label for="price_per_kg" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Harga per Kilogram (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">Rp</span>
                    <input type="number"
                           id="price_per_kg"
                           name="price_per_kg"
                           placeholder="7000"
                           min="500"
                           max="999999"
                           step="500"
                           required
                           x-model="price"
                           class="w-full border rounded-xl pl-10 pr-16 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors
                                  {{ $errors->has('price_per_kg') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400">/kg</span>
                </div>
                @error('price_per_kg')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Minimal Rp 500/kg</p>
            </div>

            {{-- Estimasi hari selesai --}}
            <div>
                <label for="estimated_days" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Estimasi Hari Selesai <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number"
                           id="estimated_days"
                           name="estimated_days"
                           placeholder="2"
                           min="0"
                           max="30"
                           required
                           x-model="days"
                           class="w-full border rounded-xl px-4 pr-16 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors
                                  {{ $errors->has('estimated_days') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400">hari</span>
                </div>
                @error('estimated_days')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3"></i>{{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Isi 0 untuk layanan Express (dalam jam)</p>
            </div>

            {{-- Preview Kalkulasi Harga —— live preview dengan Alpine.js --}}
            <div class="md:col-span-2">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4" x-show="price > 0">
                    <p class="text-xs font-semibold text-blue-600 mb-2 flex items-center gap-1.5">
                        <i data-lucide="calculator" class="w-3.5 h-3.5"></i>
                        Preview Harga (Contoh Kalkulasi)
                    </p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white rounded-lg p-2">
                            <p class="text-xs text-gray-400">3 kg (Antar Sendiri)</p>
                            <p class="font-bold text-gray-800 text-sm" x-text="'Rp ' + (price * 3).toLocaleString('id-ID')"></p>
                        </div>
                        <div class="bg-white rounded-lg p-2">
                            <p class="text-xs text-gray-400">5 kg (Antar Sendiri)</p>
                            <p class="font-bold text-gray-800 text-sm" x-text="'Rp ' + (price * 5).toLocaleString('id-ID')"></p>
                        </div>
                        <div class="bg-white rounded-lg p-2 border border-blue-200">
                            <p class="text-xs text-blue-500">5 kg + Jemput</p>
                            <p class="font-bold text-blue-700 text-sm" x-text="'Rp ' + (price * 5 + 1000).toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                    <p class="text-xs text-blue-400 mt-2">
                        Estimasi: <span x-text="days == 0 ? '⚡ Express (6 jam)' : days + ' hari kerja'"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Section 3: Tampilan & Status ───────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2">
                <i data-lucide="palette" class="w-4 h-4 text-purple-500"></i>
                Tampilan & Status
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pilih Icon --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Icon Layanan
                    <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($icons as $iconName => $iconLabel)
                    <label class="relative cursor-pointer group">
                        <input type="radio"
                               name="icon"
                               value="{{ $iconName }}"
                               class="peer sr-only"
                               {{ old('icon', $service->icon) === $iconName ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-2.5 text-center transition-all
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                    border-gray-200 hover:border-blue-300 hover:bg-gray-50">
                            <i data-lucide="{{ $iconName }}"
                               class="w-5 h-5 mx-auto text-gray-400 peer-checked:text-blue-500"></i>
                            <p class="text-xs text-gray-400 mt-1 leading-tight">{{ $iconLabel }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('icon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status Layanan
                </label>
                <label class="flex items-start gap-3 cursor-pointer p-4 border rounded-xl transition-colors
                              hover:bg-gray-50 border-gray-200">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
                           class="mt-0.5 w-4 h-4 rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Aktifkan Layanan</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Layanan yang aktif akan muncul di halaman "Order Baru" customer.
                            Nonaktifkan untuk menyembunyikan sementara tanpa menghapus.
                        </p>
                    </div>
                </label>
            </div>
        </div>
    </div>

    {{-- ── Tombol Submit ───────────────────────────────────────────── --}}
    <div class="flex items-center gap-3">
        <button type="submit"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition-colors shadow-sm">
            <i data-lucide="save" class="w-4 h-4"></i>
            {{ $method === 'POST' ? 'Tambah Layanan' : 'Simpan Perubahan' }}
        </button>
        <a href="{{ route('admin.services.index') }}"
           class="flex items-center gap-2 text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-5 py-3 rounded-xl text-sm font-medium transition-colors">
            Batal
        </a>
    </div>

</form>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>

<script>
/**
 * Alpine.js component untuk form layanan
 */
function serviceForm(initialPrice, initialDays) {
    return {
        price: initialPrice,
        days: initialDays,
    };
}

/**
 * 2. Memicu Lucide untuk merender ikon setelah HTML selesai dimuat
 */
document.addEventListener("DOMContentLoaded", function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    } else {
        console.error("Library Lucide gagal dimuat. Periksa koneksi internet atau letak CDN script.");
    }
});
</script>
@endpush