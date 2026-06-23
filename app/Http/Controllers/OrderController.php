<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Laundry;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use App\Models\LoyaltySetting;
use App\Models\LoyaltyTransaction;
use App\Services\WhatsAppService;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct(
        private WhatsAppService $whatsApp
    ) {}

    // ─────────────────────────────────────────────────────────────
    // CUSTOMER: Buat & Pantau Order
    // ─────────────────────────────────────────────────────────────

    public function selectLaundry()
    {
        $shops = Laundry::latest()->get();
        return view('customer.orders.select-laundry', compact('shops'));
    }

    public function create(Request $request)
    {
        $shopId = $request->get('shop_id');

        if (!$shopId) {
            return redirect()->route('customer.orders.select_laundry')
                ->with('error', 'Silakan pilih toko laundry terlebih dahulu.');
        }

        $services     = Service::active()->where('laundry_id', $shopId)->orderBy('price_per_kg')->get();
        $kurirEnabled = Setting::get('kurir_enabled', false);
        $shop         = Laundry::findOrFail($shopId);

        return view('customer.orders.create', compact('services', 'kurirEnabled', 'shop'));
    }

    public function store(Request $request)
    {
        $kurirEnabled = Setting::get('kurir_enabled', false);

        $validated = $request->validate([
            'shop_id'        => 'required|exists:laundries,id',
            'service_id'     => 'required|exists:services,id',
            'pickup_type'    => ['required', Rule::in(['antar_sendiri', 'jemput'])],
            'pickup_address' => [
                Rule::requiredIf($request->pickup_type === 'jemput'),
                'nullable',
                'string',
                'max:500',
            ],
            'pickup_note'    => 'nullable|string|max:255',
            'notes'          => 'nullable|string|max:500',
            'is_syariah'     => 'nullable|in:1,0',
            'has_najis'      => 'nullable|in:tidak,ada',
        ]);

        if ($validated['pickup_type'] === 'jemput' && !$kurirEnabled) {
            return back()->withErrors(['pickup_type' => 'Layanan jemput sedang tidak tersedia.']);
        }

        $service    = Service::findOrFail($validated['service_id']);
        $serviceFee = Order::getConvenienceFee($validated['pickup_type']);

        $isHalal     = $request->boolean('is_syariah');
        $hasNajis    = $request->get('has_najis') === 'ada';
        $halalStatus = 'none';

        if ($isHalal) {
            $halalStatus = $hasNajis ? 'pending_thaharah' : 'thaharah_completed';
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_code'       => Order::generateCode(),
                'customer_id'      => Auth::id(),
                'laundry_id'       => $validated['shop_id'],
                'service_id'       => $service->id,
                'price_per_kg'     => $service->price_per_kg,
                'service_fee'      => $serviceFee,
                'total_price'      => $serviceFee,
                'pickup_type'      => $validated['pickup_type'],
                'pickup_address'   => $validated['pickup_address'] ?? null,
                'pickup_note'      => $validated['pickup_note'] ?? null,
                'notes'            => $validated['notes'] ?? null,
                'status'           => 'pending',
                'is_halal_service' => $isHalal,
                'has_najis'        => $hasNajis,
                'halal_status'     => $halalStatus,
            ]);

            DB::commit();

            // 🔔 TRIGGER NOTIFIKASI
            $laundry = Laundry::find($order->laundry_id);
            if ($laundry) {
                $owner = User::find($laundry->user_id);
                if ($owner) {
                    $owner->notify(new OrderCreatedNotification($order));
                }

                $staffs = User::where('laundry_id', $laundry->id)->get();
                foreach ($staffs as $staff) {
                    $staff->notify(new OrderCreatedNotification($order));
                }
            }

            $this->whatsApp->notifyOrderCreated($order);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat order: ' . $e->getMessage()]);
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('success', "Order {$order->order_code} berhasil dibuat!");
    }

    public function show(Order $order)
    {
        $this->authorizeCustomerOrder($order);
        $order->load(['service', 'payment', 'kurir']);
        $waDeepLink = null;

        if ($order->payment?->method !== 'cash' && $order->payment?->isPending()) {
            $waDeepLink = $this->whatsApp->generateDeepLink(
                config('services.whatsapp.admin_phone', ''),
                "Halo, saya sudah transfer untuk order *{$order->order_code}*. Mohon dikonfirmasi. 🙏"
            );
        }

        return view('customer.orders.show', compact('order', 'waDeepLink'));
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Order::where('customer_id', Auth::id())
            ->with(['service', 'payment'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->appends($request->query());

        return view('customer.orders.index', compact('orders'));
    }

    // ─────────────────────────────────────────────────────────────
    // KASIR: Manajemen & Validasi Order
    // ─────────────────────────────────────────────────────────────

    public function kasirIndex(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');

        $realLaundryId = auth()->user()->laundry_id ?? Laundry::where('user_id', auth()->id())->value('id');

        $query = Order::where('laundry_id', $realLaundryId)
            ->with(['customer', 'service', 'payment', 'kurir'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(15);

        $stats = [
            'pending'       => Order::where('laundry_id', $realLaundryId)->where('status', 'pending')->count(),
            'in_process'    => Order::where('laundry_id', $realLaundryId)->where('status', 'in_process')->count(),
            'ready'         => Order::where('laundry_id', $realLaundryId)->where('status', 'ready')->count(),
            'today_revenue' => Payment::whereHas('order', fn($q) => $q->where('laundry_id', $realLaundryId))
                ->whereDate('verified_at', today())
                ->where('status', 'verified')
                ->sum('amount'),
        ];

        return view('kasir.orders.index', compact('orders', 'stats', 'status', 'search'));
    }

    public function kasirShow(Order $order)
    {
        $realLaundryId = auth()->user()->laundry_id ?? Laundry::where('user_id', auth()->id())->value('id');
        if ($order->laundry_id !== $realLaundryId) {
            abort(403, 'Anda tidak berhak mengakses order dari toko laundry lain.');
        }

        $order->load(['customer', 'service', 'payment', 'kurir']);
        $kurirs = User::where('role', 'kurir')->get();

        return view('kasir.orders.show', compact('order', 'kurirs'));
    }

    public function updateWeight(Request $request, Order $order)
    {
        $validated = $request->validate([
            'weight_kg' => 'required|numeric|min:0.1|max:100',
        ]);

        $weight = (float) $validated['weight_kg'];
        $total  = ($weight * $order->price_per_kg) + $order->service_fee;

        $order->update([
            'weight_kg'   => $weight,
            'total_price' => $total,
        ]);

        return response()->json([
            'success'         => true,
            'weight_kg'       => $weight,
            'total_price'     => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    public function advanceStatus(Order $order)
    {
        if ($order->status === 'pending' && $order->is_halal_service && $order->halal_status === 'pending_thaharah') {
            return back()->withErrors(['error' => 'Order Syariah terdeteksi najis. Silakan selesaikan proses Thaharah (bilas najis) terlebih dahulu sebelum memproses order ini!']);
        }

        if (!$order->advanceStatus()) {
            return back()->withErrors(['error' => 'Tidak bisa memajukan status order ini.']);
        }

        // ✨ FIX BUG: Memaksa object Order memuat ulang state status terbaru dari Database!
        // Sebelumnya, variable in-memory masih memegang status lama sehingga bypass sistem poin.
        $order->refresh();
        $order->load('payment');

        // ✨ TRIGGER SISTEM POIN LOYALITAS DIGITAL (Mendukung beberapa penamaan status akhir)
        if (in_array(strtolower($order->status), ['finished', 'completed', 'selesai'])) {
            $this->processLoyaltyPoints($order);
        }

        $this->whatsApp->notifyStatusChanged($order);

        if ($order->status === 'pickup' && $order->kurir) {
            $this->whatsApp->notifyKurir($order);
        }

        return back()->with('success', "Status order {$order->order_code} berhasil diperbarui.");
    }

    public function assignKurir(Request $request, Order $order)
    {
        $request->validate(['kurir_id' => 'required|exists:users,id']);

        $order->update(['kurir_id' => $request->kurir_id]);
        $this->whatsApp->notifyKurir($order->fresh(['kurir', 'customer']));

        return back()->with('success', 'Kurir berhasil ditugaskan.');
    }

    // ─────────────────────────────────────────────────────────────
    // SYARIAH COMPLIANCE: Alur Eksekusi Laundry Halal
    // ─────────────────────────────────────────────────────────────

    public function completeThaharah(Order $order)
    {
        if (!$order->is_halal_service || $order->halal_status !== 'pending_thaharah') {
            return back()->withErrors(['error' => 'Order ini tidak membutuhkan proses thaharah atau sudah dibilas.']);
        }

        $order->update([
            'halal_status' => 'thaharah_completed'
        ]);

        return back()->with('success', "Proses Thaharah (bilas najis) untuk order {$order->order_code} berhasil dikonfirmasi.");
    }

    public function startMainWash(Order $order)
    {
        if (!$order->is_halal_service || $order->halal_status !== 'thaharah_completed') {
            return back()->withErrors(['error' => 'Pakaian harus melalui pembasuhan thaharah terlebih dahulu sebelum masuk mesin cuci.']);
        }

        $order->update([
            'halal_status' => 'main_wash'
        ]);

        if ($order->status === 'pending') {
            $order->update(['status' => 'in_process']);
        }

        return back()->with('success', "Order {$order->order_code} berhasil dimasukkan ke mesin cuci utama.");
    }

    // ─────────────────────────────────────────────────────────────
    // PAYMENT: Pemrosesan Transaksi
    // ─────────────────────────────────────────────────────────────

    public function createPayment(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        if ($order->payment) {
            return redirect()->route('customer.orders.show', $order)
                ->with('info', 'Pembayaran sudah diproses.');
        }

        $loyaltySetting = LoyaltySetting::where('laundry_id', $order->laundry_id)->first();

        return view('customer.payments.create', compact('order', 'loyaltySetting'));
    }

    public function storePayment(Request $request, Order $order)
    {
        $this->authorizeCustomerOrder($order);

        $validated = $request->validate([
            'method'      => ['required', Rule::in(['cash', 'transfer', 'qris'])],
            'proof_image' => 'required_if:method,transfer,qris|nullable|image|max:2048',
            'notes'       => 'nullable|string|max:255',
            'use_points'  => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $finalAmount = $order->total_price;
        $discountAmount = 0;
        $pointsToDeduct = 0;

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('payments', 'public');
        }

        DB::beginTransaction();
        try {
            if ($request->boolean('use_points')) {
                $loyaltySetting = LoyaltySetting::where('laundry_id', $order->laundry_id)->first();

                $currentPoints = $user->loyalty_points ?? 0;

                if ($loyaltySetting && $loyaltySetting->is_active && $currentPoints > 0) {
                    $cashbackPerPoint = $loyaltySetting->cashback_per_point ?? 0;

                    if ($cashbackPerPoint > 0) {
                        $maxPointsNeeded = ceil($order->total_price / $cashbackPerPoint);
                        $pointsToDeduct = min($currentPoints, $maxPointsNeeded);

                        if ($pointsToDeduct > 0) {
                            $discountAmount = $pointsToDeduct * $cashbackPerPoint;
                            $finalAmount = max(0, $order->total_price - $discountAmount);

                            $user->loyalty_points = $currentPoints - $pointsToDeduct;
                            $user->save();

                            LoyaltyTransaction::create([
                                'user_id'     => $user->id,
                                'laundry_id'  => $order->laundry_id,
                                'order_id'    => $order->id,
                                'amount'      => $pointsToDeduct,
                                'type'        => 'redemption',
                                'description' => "Menukarkan {$pointsToDeduct} poin sebagai potongan harga Rp " . number_format($discountAmount, 0, ',', '.')
                            ]);

                            $order->update([
                                'total_price' => $finalAmount,
                                'notes'       => trim(($order->notes ? $order->notes . ' | ' : '') . "Potongan Saldo Poin: Rp " . number_format($discountAmount, 0, ',', '.'))
                            ]);
                        }
                    }
                }
            }

            Payment::create([
                'order_id'     => $order->id,
                'payment_code' => Payment::generateCode(),
                'amount'       => $finalAmount,
                'method'       => $validated['method'],
                'status'       => 'pending',
                'proof_image'  => $proofPath,
                'notes'        => $validated['notes'] ?? null,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($proofPath) {
                Storage::disk('public')->delete($proofPath);
            }
            return back()->withErrors(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()]);
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi Kasir.');
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => ['required', Rule::in(['verify', 'reject'])],
        ]);

        if ($request->action === 'verify') {
            $payment->update([
                'status'      => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // ✨ FIX BUG: Selalu tarik Data Order & Payment yang paling Fresh langsung dari DB!
            $freshOrder = Order::with('payment')->find($payment->order_id);
            if ($freshOrder) {
                $this->processLoyaltyPoints($freshOrder);
            }

            $this->whatsApp->notifyPaymentVerified($payment->order->load('customer'));
        } else {
            $payment->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────
    // PUBLIC: Lacak Order tanpa Auth
    // ─────────────────────────────────────────────────────────────

    public function track(Request $request)
    {
        $order = null;
        if ($code = $request->get('code')) {
            $order = Order::where('order_code', $code)
                ->with(['service', 'customer', 'payment'])
                ->first();
        }

        return view('public.track', compact('order'));
    }

    // ─────────────────────────────────────────────────────────────
    // PRIVATES / HELPERS
    // ─────────────────────────────────────────────────────────────

    private function processLoyaltyPoints(Order $order): void
    {
        // 1. CEK STATUS
        $finalStatuses = ['finished', 'completed', 'selesai'];
        if (!in_array(strtolower($order->status), $finalStatuses)) {
            dd('STOP DI 1: Gagal. Status order bukan selesai/finished. Status saat ini terbaca sebagai: ' . $order->status);
        }

        // 2. CEK RELASI PEMBAYARAN
        if (!$order->payment) {
            dd('STOP DI 2: Gagal. Order belum memiliki data pembayaran (Relasi tabel Payment kosong).');
        }

        // 3. CEK STATUS LUNAS
        if ($order->payment->status !== 'verified') {
            dd('STOP DI 3: Gagal. Pembayaran ada, tapi status belum diverifikasi. Status saat ini: ' . $order->payment->status);
        }

        // 4. CEK SETTING DATABASE
        $settings = LoyaltySetting::where('laundry_id', $order->laundry_id)->first();
        if (!$settings) {
            // Fallback: Jika ternyata tabel setting tidak memakai kolom laundry_id
            $settings = LoyaltySetting::first();
            if (!$settings) {
                dd('STOP DI 4: Gagal. Setting loyalitas tidak ditemukan sama sekali di tabel loyalty_settings.');
            }
        }

        // 5. CEK APAKAH AKTIF
        if (!$settings->is_active) {
            dd('STOP DI 5: Gagal. Setting loyalitas ada di database, TAPI is_active bernilai 0 (Tidak aktif).');
        }

        // 6. CEK APAKAH SUDAH PERNAH DIKASIH POIN
        $alreadyCalculated = LoyaltyTransaction::where('order_id', $order->id)->where('type', 'earning')->exists();
        if ($alreadyCalculated) {
            dd('STOP DI 6: Gagal. Poin order ini sudah pernah dicairkan sebelumnya (Data sudah ada di tabel).');
        }

        // 7. CEK THRESHOLD
        if ($settings->threshold_amount <= 0) {
            dd('STOP DI 7: Gagal. Batas minimal transaksi (threshold_amount) di setting nilainya 0.');
        }

        // 8. CEK PERHITUNGAN MATEMATIKA
        $totalPrice = (float) $order->total_price;
        $threshold = (float) $settings->threshold_amount;
        $points = floor($totalPrice / $threshold) * $settings->points_earned;

        if ($points <= 0) {
            dd('STOP DI 8: Gagal. Poin yang didapat adalah 0. (Total Harga: ' . $totalPrice . ' dibagi ' . $threshold . ')');
        }

        // 9. COBA SIMPAN KE DATABASE (Biasanya sering gagal disini)
        try {
            LoyaltyTransaction::create([
                'user_id'     => $order->customer_id,
                'laundry_id'  => $order->laundry_id,
                'order_id'    => $order->id,
                'amount'      => $points,
                'type'        => 'earning',
                'description' => "Mendapatkan {$points} poin dari order #{$order->order_code}"
            ]);

            $customer = User::find($order->customer_id);
            if ($customer) {
                $customer->loyalty_points = ($customer->loyalty_points ?? 0) + $points;
                $customer->save();
            }

            // Jika sampai ke baris ini, berarti AMAN dan BERHASIL.
            // Tidak ada dd(), agar order tetap jalan dan kembali ke halaman kasir.

        } catch (\Exception $e) {
            // Menangkap error database (Misal: kolom belum masuk $fillable)
            dd('STOP DI 9 (ERROR DATABASE): Gagal menyimpan karena ada masalah di model. Pesan Error: ' . $e->getMessage());
        }
    }
    private function authorizeCustomerOrder(Order $order): void
    {
        if ($order->customer_id !== Auth::id() && !Auth::user()->isStaff()) {
            abort(403, 'Anda tidak berhak mengakses order ini.');
        }
    }
}
