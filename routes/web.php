<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProfileTokoController;
use App\Http\Controllers\Admin\PegawaiController; // ◄ DI INTEGRASIKAN: Import Pegawai Controller Baru
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController; // ◄ TAMBAHAN: Import Report Controller
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ── IMPORT CONTROLLERS BARU SUPER ADMIN (SUBFOLDER) ─────────────────────────
use App\Http\Controllers\SuperAdmin\CeoDashboardController;
use App\Http\Controllers\SuperAdmin\SubscriptionPlanController;
use App\Http\Controllers\SuperAdmin\CeoLaundryController;
use App\Http\Controllers\SuperAdmin\GlobalServiceTemplateController;

// ─── Public ──────────────────────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/track', [OrderController::class, 'track'])->name('order.track');
Route::get('/track/{code}', fn(string $code) => redirect()->route('order.track', ['code' => $code]));

// ── RUTE BARU KHUSUS PENDAFTARAN MITRA ───────────────────────────────────────
Route::get('/register-mitra', [RegisteredUserController::class, 'createMitra'])->name('register.mitra');
Route::post('/register-mitra', [RegisteredUserController::class, 'storeMitra']);

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->dashboardRoute());
    })->name('dashboard');

    // ── ONBOARDING BILLING MITRA (RUTE BARU) ──────────────────────────────────
    Route::get('/onboarding/billing', function () {
        return view('auth.onboarding-billing');
    })->name('onboarding.billing');

    // ── SUPER ADMIN / CEO (✨ INTEGRASI FULL BACKEND SAAS & MATA DEWA) ──────────
    // FIX: Mengembalikan ->name('superadmin.') menjadi ->name('ceo.') agar sinkron dengan file View yang memanggil ceo.plans.*
    Route::middleware(RoleMiddleware::class . ':super_admin')
        ->prefix('ceo')->name('ceo.')->group(function () {

            // 1. Dashboard Mata Dewa
            Route::get('/dashboard', [CeoDashboardController::class, 'index'])->name('dashboard');

            // 2. CRUD Paket Langganan SaaS (Mengatur Harga Langganan & Potongan Komisi)
            Route::resource('plans', SubscriptionPlanController::class);

            // 3. Manajemen Toko / Tenant (Bypass Filter, Ubah Paket, & Kontrol Status Blokir)
            Route::get('/laundries', [CeoLaundryController::class, 'index'])->name('laundries.index');
            // PERUBAHAN: Menambahkan rute create dan store yang sebelumnya belum didefinisikan
            Route::get('/laundries/create', [CeoLaundryController::class, 'create'])->name('laundries.create');
            // FIX TYPO: Membuka endpoint post untuk store laundry baru
            Route::post('/laundries', [CeoLaundryController::class, 'store'])->name('laundries.store');
            Route::patch('/laundries/{laundry}/plan', [CeoLaundryController::class, 'updatePlan'])->name('laundries.updatePlan');
            Route::patch('/laundries/{laundry}/toggle', [CeoLaundryController::class, 'toggleStatus'])->name('laundries.toggleStatus');

            // 4. Master Data & Template Layanan Global
            Route::get('/templates', [GlobalServiceTemplateController::class, 'index'])->name('templates.index');
            Route::post('/templates', [GlobalServiceTemplateController::class, 'store'])->name('templates.store');
            Route::put('/templates/{template}', [GlobalServiceTemplateController::class, 'update'])->name('templates.update');
            Route::delete('/templates/{template}', [GlobalServiceTemplateController::class, 'destroy'])->name('templates.destroy');
        });

    // ── CUSTOMER ──────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':customer')
        ->prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', fn() => view('customer.dashboard'))->name('dashboard');
            Route::get('orders/select-laundry', [OrderController::class, 'selectLaundry'])->name('orders.select_laundry');
            Route::get('/orders',               [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/create',        [OrderController::class, 'create'])->name('orders.create');
            Route::post('/orders',              [OrderController::class, 'store'])->name('orders.store');
            Route::get('/orders/{order}',       [OrderController::class, 'show'])->name('orders.show');
            Route::get('/orders/{order}/pay',  [OrderController::class, 'createPayment'])->name('orders.pay');
            Route::post('/orders/{order}/pay', [OrderController::class, 'storePayment'])->name('orders.pay.store');
        });

    // ── KASIR ─────────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':kasir,admin')
        ->prefix('kasir')->name('kasir.')->group(function () {
            Route::get('/dashboard',                                                                                     [OrderController::class, 'kasirIndex'])->name('dashboard');
            Route::patch('/orders/{order}/weight',                                                                       [OrderController::class, 'updateWeight'])->name('orders.weight');
            Route::patch('/orders/{order}/advance',                                                                      [OrderController::class, 'advanceStatus'])->name('orders.advance');
            Route::patch('/orders/{order}/kurir',                                                                        [OrderController::class, 'assignKurir'])->name('orders.kurir');

            // ── TAMBAHAN FITUR WORKFLOW LAUNDRY HALAL ──
            Route::post('/orders/{order}/complete-thaharah', [OrderController::class, 'completeThaharah'])->name('orders.complete-thaharah');
            Route::post('/orders/{order}/start-main-wash',   [OrderController::class, 'startMainWash'])->name('orders.start-main-wash');

            // Manajemen Pembayaran Kasir
            Route::get('/payments',                           [PaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/{payment}',                 [PaymentController::class, 'show'])->name('payments.show');
            Route::post('/payments/{payment}/verify',         [PaymentController::class, 'verify'])->name('payments.verify');
            Route::post('/payments/{payment}/quick-verify',   [PaymentController::class, 'quickVerify'])->name('payments.quick-verify');
            Route::get('/payments/{payment}/proof',           [PaymentController::class, 'viewProof'])->name('payments.proof');

            // ── FITUR BARU: ROUTE PENGATURAN POIN LOYALITAS (SISI KASIR) ──
            // Catatan: Karena berada di dalam grup Kasir yang otomatis memberi prefix 'kasir/' dan nama 'kasir.', 
            // URL cukup ditulis '/loyalty-settings' dan nama route cukup 'loyalty.settings' agar menghasilkan 'kasir.loyalty.settings'.
            //Route::get('/loyalty-settings', [App\Http\Controllers\LoyaltySettingController::class, 'index'])->name('loyalty.settings');
            //Route::put('/loyalty-settings', [App\Http\Controllers\LoyaltySettingController::class, 'update'])->name('loyalty.update');
        });

    // ── KURIR ─────────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':kurir,admin')
        ->prefix('kurir')->name('kurir.')->group(function () {

            // Dashboard utama
            Route::get('/dashboard',  [KurirController::class, 'dashboard'])->name('dashboard');

            // Riwayat semua order yang pernah ditangani
            Route::get('/history',    [KurirController::class, 'history'])->name('history');

            // Profil kurir (nama & nomor HP)
            Route::get('/profile',    [KurirController::class, 'profile'])->name('profile');
            Route::patch('/profile',  [KurirController::class, 'updateProfile'])->name('profile.update');

            // Detail satu order yang ditugaskan ke kurir ini
            Route::get('/orders/{order}', [KurirController::class, 'showOrder'])->name('order.detail');

            // Ambil tugas jemput
            Route::post('/orders/{order}/accept',  [KurirController::class, 'acceptPickup'])->name('pickup.accept');

            // Konfirmasi sudah dijemput & sedang menuju laundry
            Route::patch('/orders/{order}/confirm', [KurirController::class, 'confirmPickup'])->name('pickup.confirm');

            // Lepas tugas (jika tidak bisa menjemput)
            Route::patch('/orders/{order}/reject', [KurirController::class, 'rejectPickup'])->name('pickup.reject');
        });

    // ── ADMIN ─────────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':admin')
        ->prefix('admin')->name('admin.')->group(function () {

            Route::get('/dashboard',     [AdminController::class, 'dashboard'])->name('dashboard');
            Route::post('/toggle-kurir', [AdminController::class, 'toggleKurir'])->name('toggle.kurir');

            // Manajemen kurir (halaman khusus admin)
            Route::get('/kurir',         [AdminController::class, 'kurirManagement'])->name('kurir.index');

            // Inventory
            Route::get('/inventory',                       [AdminController::class, 'inventoryIndex'])->name('inventory.index');
            Route::post('/inventory',                      [AdminController::class, 'inventoryStore'])->name('inventory.store');
            Route::patch('/inventory/{inventory}/adjust',  [AdminController::class, 'inventoryAdjust'])->name('inventory.adjust');

            // Reports
            Route::get('/reports',                         [AdminController::class, 'reports'])->name('reports');
            // ◄ TAMBAHAN ROUTE EXPORT:
            Route::get('/reports/export',                  [ReportController::class, 'downloadFinancialReport'])->name('reports.export');

            // ── MANAJEMEN PEGAWAI (MENGGANTIKAN MANAJEMEN USERS LAMA) ──
            Route::resource('pegawai', PegawaiController::class);
            Route::patch('/pegawai/{user}/toggle',         [PegawaiController::class, 'toggleStatus'])->name('pegawai.toggle');

            // Services CRUD
            Route::resource('services', ServiceController::class)->except(['show']);
            $halal_clean_url = 'services/{service}/toggle';
            Route::patch($halal_clean_url, [ServiceController::class, 'toggle'])->name('services.toggle');

            // ── RUTE BARU: PROFIL TOKO LAUNDRY ──
            Route::get('/profile-toko', [ProfileTokoController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile-toko', [ProfileTokoController::class, 'update'])->name('profile.update');
        });

    // Halaman chat umum (bisa diakses admin & customer)
    Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth'])->name('chat.index');
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chat.start');
    // Halaman chat spesifik untuk satu percakapan
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->middleware(['auth'])->name('chat.show');
    // Tambahkan rute ini untuk mengambil data JSON chat secara berkala (Polling)
    Route::get('/chat/{conversation}/fetch-messages', [ChatController::class, 'fetchMessages'])->name('chat.messages.fetch');

    // ── RUTE NOTIFIKASI REAL-TIME (GLOBAL UNTUK NAVBAR/LAYOUT) ─────────────────
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});