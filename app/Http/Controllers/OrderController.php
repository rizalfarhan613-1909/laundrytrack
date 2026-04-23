<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Setting;
use App\Services\WhatsAppService;
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
    // CUSTOMER: Buat Order Baru
    // ─────────────────────────────────────────────────────────────

    /** Form pembuatan order untuk customer */
    public function create()
    {
        $services     = Service::active()->orderBy('price_per_kg')->get();
        $kurirEnabled = Setting::get('kurir_enabled', false);

        return view('customer.orders.create', compact('services', 'kurirEnabled'));
    }

    /** Simpan order baru */
    public function store(Request $request)
    {
        $kurirEnabled = Setting::get('kurir_enabled', false);

        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'pickup_type'  => ['required', Rule::in(['antar_sendiri', 'jemput'])],
            'pickup_address' => [
                Rule::requiredIf($request->pickup_type === 'jemput'),
                'nullable', 'string', 'max:500',
            ],
            'pickup_note'  => 'nullable|string|max:255',
            'notes'        => 'nullable|string|max:500',
        ]);

        // Validasi: layanan jemput hanya bisa jika kurir aktif
        if ($validated['pickup_type'] === 'jemput' && !$kurirEnabled) {
            return back()->withErrors(['pickup_type' => 'Layanan jemput sedang tidak tersedia.']);
        }

        $service    = Service::findOrFail($validated['service_id']);
        $serviceFee = Order::getConvenienceFee($validated['pickup_type']);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_code'    => Order::generateCode(),
                'customer_id'   => Auth::id(),
                'service_id'    => $service->id,
                'price_per_kg'  => $service->price_per_kg,
                'service_fee'   => $serviceFee,
                'total_price'   => $serviceFee,             // berat belum diisi, kasir yg isi
                'pickup_type'   => $validated['pickup_type'],
                'pickup_address'=> $validated['pickup_address'] ?? null,
                'pickup_note'   => $validated['pickup_note'] ?? null,
                'notes'         => $validated['notes'] ?? null,
                'status'        => 'pending',
            ]);

            DB::commit();

            // Kirim notifikasi WA ke customer
            $this->whatsApp->notifyOrderCreated($order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat order: ' . $e->getMessage()]);
        }

        return redirect()->route('customer.orders.show', $order)
                         ->with('success', "Order {$order->order_code} berhasil dibuat!");
    }

    /** Detail order untuk customer */
    public function show(Order $order)
    {
        $this->authorizeCustomerOrder($order);
        $order->load(['service', 'payment', 'kurir']);
        $waDeepLink = null;

        // Jika ada payment pending transfer, generate deep-link WA untuk konfirmasi
        if ($order->payment?->method !== 'cash' && $order->payment?->isPending()) {
            $waDeepLink = $this->whatsApp->generateDeepLink(
                config('services.whatsapp.admin_phone', ''),
                "Halo, saya sudah transfer untuk order *{$order->order_code}*. Mohon dikonfirmasi. 🙏"
            );
        }

        return view('customer.orders.show', compact('order', 'waDeepLink'));
    }

    /** Daftar order customer */
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
                       ->with(['service', 'payment'])
                       ->latest()
                       ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    // ─────────────────────────────────────────────────────────────
    // KASIR: Manajemen Order
    // ─────────────────────────────────────────────────────────────

    /** Dashboard kasir: semua order aktif */
    public function kasirIndex(Request $request)
    {
        $status  = $request->get('status', 'all');
        $search  = $request->get('search', '');

        $query = Order::with(['customer', 'service', 'payment', 'kurir'])
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
            'pending'    => Order::where('status', 'pending')->count(),
            'in_process' => Order::where('status', 'in_process')->count(),
            'ready'      => Order::where('status', 'ready')->count(),
            'today_revenue' => Payment::whereDate('verified_at', today())
                                      ->where('status', 'verified')
                                      ->sum('amount'),
        ];

        return view('kasir.orders.index', compact('orders', 'stats', 'status', 'search'));
    }

    /** Kasir mengisi berat dan memperbarui total harga */
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
            'success'     => true,
            'weight_kg'   => $weight,
            'total_price' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    /** Kasir memajukan status order */
    public function advanceStatus(Order $order)
    {
        if (!$order->advanceStatus()) {
            return back()->withErrors(['error' => 'Tidak bisa memajukan status order ini.']);
        }

        // Kirim notifikasi WA saat status berubah
        $this->whatsApp->notifyStatusChanged($order);

        // Jika status 'pickup' dan ada kurir assigned, notif kurir juga
        if ($order->status === 'pickup' && $order->kurir) {
            $this->whatsApp->notifyKurir($order);
        }

        return back()->with('success', "Status order {$order->order_code} berhasil diperbarui.");
    }

    /** Assign kurir ke order */
    public function assignKurir(Request $request, Order $order)
    {
        $request->validate(['kurir_id' => 'required|exists:users,id']);

        $order->update(['kurir_id' => $request->kurir_id]);
        $this->whatsApp->notifyKurir($order->fresh(['kurir', 'customer']));

        return back()->with('success', 'Kurir berhasil ditugaskan.');
    }

    // ─────────────────────────────────────────────────────────────
    // PAYMENT: Customer Upload Bukti / Bayar Cash
    // ─────────────────────────────────────────────────────────────

    public function createPayment(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        if ($order->payment) {
            return redirect()->route('customer.orders.show', $order)
                             ->with('info', 'Pembayaran sudah diproses.');
        }

        return view('customer.payments.create', compact('order'));
    }

    public function storePayment(Request $request, Order $order)
    {
        $this->authorizeCustomerOrder($order);

        $validated = $request->validate([
            'method'      => ['required', Rule::in(['cash', 'transfer', 'qris'])],
            'proof_image' => 'required_if:method,transfer,qris|nullable|image|max:2048',
            'notes'       => 'nullable|string|max:255',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('payments', 'public');
        }

        Payment::create([
            'order_id'     => $order->id,
            'payment_code' => Payment::generateCode(),
            'amount'       => $order->total_price,
            'method'       => $validated['method'],
            'status'       => $validated['method'] === 'cash' ? 'pending' : 'pending',
            'proof_image'  => $proofPath,
            'notes'        => $validated['notes'] ?? null,
        ]);

        return redirect()->route('customer.orders.show', $order)
                         ->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi.');
    }

    /** Kasir verifikasi pembayaran */
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
            $this->whatsApp->notifyPaymentVerified($payment->order->load('customer'));
        } else {
            $payment->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────
    // PUBLIC: Track Order (tanpa login)
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
    // HELPERS
    // ─────────────────────────────────────────────────────────────

    private function authorizeCustomerOrder(Order $order): void
    {
        if ($order->customer_id !== Auth::id() && !Auth::user()->isStaff()) {
            abort(403, 'Anda tidak berhak mengakses order ini.');
        }
    }
}