<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\NotifResult;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct(private WhatsAppService $wa) {}

    // ──────────────────────────────────────────────────────────────
    // KASIR: Halaman daftar semua pembayaran
    // ──────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $search = $request->get('search', '');

        $query = Payment::with(['order.customer', 'order.service', 'verifier'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                  ->orWhereHas('order', fn($q) =>
                      $q->where('order_code', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn($q) =>
                            $q->where('name', 'like', "%{$search}%")));
            });
        }

        $payments = $query->paginate(15);

        $counts = [
            'pending'  => Payment::where('status', 'pending')->count(),
            'verified' => Payment::where('status', 'verified')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
        ];

        return view('kasir.payments.index', compact('payments', 'counts', 'status', 'search'));
    }

    // ──────────────────────────────────────────────────────────────
    // KASIR: Detail satu pembayaran (lihat bukti foto dll)
    // ──────────────────────────────────────────────────────────────

    public function show(Payment $payment)
    {
        $payment->load(['order.customer', 'order.service', 'verifier']);
        $waLink = $this->wa->deepLink(
            $payment->order->customer->phone ?? '',
            "Halo *{$payment->order->customer->name}*, ada pertanyaan mengenai pembayaran order *{$payment->order->order_code}*."
        );
        return view('kasir.payments.show', compact('payment', 'waLink'));
    }

    // ──────────────────────────────────────────────────────────────
    // KASIR: Verifikasi / Tolak pembayaran (POST)
    // ──────────────────────────────────────────────────────────────

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => 'required|in:verify,reject',
            'notes'  => 'nullable|string|max:255',
        ]);

        if (!$payment->isPending()) {
            return back()->withErrors(['error' => 'Pembayaran ini sudah diproses sebelumnya.']);
        }

        $order = $payment->order->load('customer', 'service');

        if ($request->action === 'verify') {
            $payment->update([
                'status'      => 'verified',
                'notes'       => $request->notes,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Jika cash → langsung tandai order finished (opsional, sesuaikan alur)
            // Jika transfer/qris → order tetap lanjut proses normal

            $result = $this->wa->notifyPaymentVerified($order);
            $msg    = "✅ Pembayaran *{$payment->payment_code}* berhasil diverifikasi.";

        } else {
            $payment->update([
                'status' => 'rejected',
                'notes'  => $request->notes,
            ]);

            $result = $this->wa->notifyPaymentRejected($order);
            $msg    = "❌ Pembayaran *{$payment->payment_code}* ditolak.";
        }

        // Tambahkan info WA ke flash message
        if ($result->wasDelivered()) {
            $msg .= ' Notifikasi WA terkirim ke customer.';
        } elseif ($result->hasDeepLink()) {
            $msg .= ' Notifikasi WA tidak aktif — kirim manual via deep-link.';
        }

        return back()->with('success', $msg);
    }

    // ──────────────────────────────────────────────────────────────
    // KASIR: Verifikasi cepat via AJAX (dari tabel kasir)
    // ──────────────────────────────────────────────────────────────

    public function quickVerify(Request $request, Payment $payment)
    {
        $request->validate(['action' => 'required|in:verify,reject']);

        if (!$payment->isPending()) {
            return response()->json(['success' => false, 'message' => 'Pembayaran sudah diproses.'], 422);
        }

        $order = $payment->order->load('customer', 'service');

        if ($request->action === 'verify') {
            $payment->update([
                'status'      => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);
            $this->wa->notifyPaymentVerified($order);
            $status = 'verified';
            $label  = 'Lunas ✓';
        } else {
            $payment->update(['status' => 'rejected']);
            $this->wa->notifyPaymentRejected($order);
            $status = 'rejected';
            $label  = 'Ditolak';
        }

        return response()->json([
            'success' => true,
            'status'  => $status,
            'label'   => $label,
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    // KASIR: Lihat gambar bukti pembayaran (secure)
    // ──────────────────────────────────────────────────────────────

    public function viewProof(Payment $payment)
    {
        if (!$payment->proof_image) abort(404);

        $path = storage_path('app/public/' . $payment->proof_image);
        if (!file_exists($path)) abort(404);

        return response()->file($path);
    }
}