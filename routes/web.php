<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Middleware\RoleMiddleware;

use Illuminate\Support\Facades\Route;

// ─── Public ──────────────────────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/track', [OrderController::class, 'track'])->name('order.track');
Route::get('/track/{code}', fn(string $code) => redirect()->route('order.track', ['code' => $code]));

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->dashboardRoute());
    })->name('dashboard');

    // ── CUSTOMER ──────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':customer')
        ->prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', fn() => view('customer.dashboard'))->name('dashboard');
            Route::get('/orders',              [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/create',       [OrderController::class, 'create'])->name('orders.create');
            Route::post('/orders',             [OrderController::class, 'store'])->name('orders.store');
            Route::get('/orders/{order}',      [OrderController::class, 'show'])->name('orders.show');
            Route::get('/orders/{order}/pay',  [OrderController::class, 'createPayment'])->name('orders.pay');
            Route::post('/orders/{order}/pay', [OrderController::class, 'storePayment'])->name('orders.pay.store');
        });

    // ── KASIR ─────────────────────────────────────────────────────────────────
    Route::middleware(RoleMiddleware::class . ':kasir,admin')
        ->prefix('kasir')->name('kasir.')->group(function () {
            Route::get('/dashboard',                         [OrderController::class, 'kasirIndex'])->name('dashboard');
            Route::patch('/orders/{order}/weight',           [OrderController::class, 'updateWeight'])->name('orders.weight');
            Route::patch('/orders/{order}/advance',          [OrderController::class, 'advanceStatus'])->name('orders.advance');
            Route::patch('/orders/{order}/kurir',            [OrderController::class, 'assignKurir'])->name('orders.kurir');

            // ── TAMBAHAN FITUR WORKFLOW LAUNDRY HALAL ──
            Route::post('/orders/{order}/complete-thaharah', [OrderController::class, 'completeThaharah'])->name('orders.complete-thaharah');
            Route::post('/orders/{order}/start-main-wash',   [OrderController::class, 'startMainWash'])->name('orders.start-main-wash');

            Route::get('/payments',                          [PaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/{payment}',                [PaymentController::class, 'show'])->name('payments.show');
            Route::post('/payments/{payment}/verify',        [PaymentController::class, 'verify'])->name('payments.verify');
            Route::post('/payments/{payment}/quick-verify',  [PaymentController::class, 'quickVerify'])->name('payments.quick-verify');
            Route::get('/payments/{payment}/proof',          [PaymentController::class, 'viewProof'])->name('payments.proof');
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

            // Reports & Users
            Route::get('/reports',                         [AdminController::class, 'reports'])->name('reports');
            Route::get('/users',                           [AdminController::class, 'users'])->name('users.index');
            Route::patch('/users/{user}/toggle',           [AdminController::class, 'toggleUserStatus'])->name('users.toggle');

            // Services CRUD
            Route::resource('services', ServiceController::class)->except(['show']);
            Route::patch('services/{service}/toggle', [ServiceController::class, 'toggle'])->name('services.toggle');
        });

    // Halaman chat umum (bisa diakses admin & customer)
    Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth'])->name('chat.index');
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chat.start');
    // Halaman chat spesifik untuk satu percakapan
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->middleware(['auth'])->name('chat.show');
});
