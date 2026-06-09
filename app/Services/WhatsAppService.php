<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * ═══════════════════════════════════════════════════════
     *  STRATEGI NOTIFIKASI
     * ═══════════════════════════════════════════════════════
     *  1. WA_API_URL + WA_API_TOKEN tersedia → kirim via API (Fonnte)
     *  2. Kosong                             → fallback deep-link wa.me
     *
     *  Provider API yang didukung (format Fonnte):
     *    Fonnte    → https://api.fonnte.com/send
     *    WA Gateway → sesuaikan endpoint & payload
     */

    private string $apiUrl;
    private string $apiToken;
    private string $adminPhone;
    public  bool   $useApi;

    public function __construct()
    {
        $this->apiUrl     = config('services.whatsapp.url', '');
        $this->apiToken   = config('services.whatsapp.token', '');
        $this->adminPhone = config('services.whatsapp.admin_phone', '');
        $this->useApi     = !empty($this->apiUrl) && !empty($this->apiToken);
    }

    // ─── Public: Trigger per event ────────────────────────────────

    public function notifyOrderCreated(Order $order): NotifResult
    {
        return $this->dispatch(
            $order->customer->phone,
            $this->tplOrderCreated($order),
            "order_created:{$order->order_code}"
        );
    }

    public function notifyStatusChanged(Order $order): NotifResult
    {
        return $this->dispatch(
            $order->customer->phone,
            $this->tplStatusChanged($order),
            "status_changed:{$order->order_code}:{$order->status}"
        );
    }

    public function notifyKurir(Order $order): NotifResult
    {
        if (!$order->kurir?->phone) {
            return NotifResult::skipped('Kurir tidak punya nomor HP');
        }
        return $this->dispatch(
            $order->kurir->phone,
            $this->tplKurirPickup($order),
            "kurir_assigned:{$order->order_code}"
        );
    }

    public function notifyPaymentVerified(Order $order): NotifResult
    {
        return $this->dispatch(
            $order->customer->phone,
            $this->tplPaymentVerified($order),
            "payment_verified:{$order->order_code}"
        );
    }

    public function notifyPaymentRejected(Order $order): NotifResult
    {
        return $this->dispatch(
            $order->customer->phone,
            $this->tplPaymentRejected($order),
            "payment_rejected:{$order->order_code}"
        );
    }

    // ─── Public: Generate deep-link manual ───────────────────────

    public function deepLink(string $phone, string $message): string
    {
        return 'https://wa.me/' . $this->normalizePhone($phone)
             . '?text=' . urlencode($message);
    }

    /** Link konfirmasi transfer → admin */
    public function confirmPaymentLink(Order $order): string
    {
        $total = number_format($order->total_price, 0, ',', '.');
        $msg = "Halo Admin LaundryTrack 👋\n\n"
             . "Saya sudah transfer untuk:\n"
             . "📋 Order: *{$order->order_code}*\n"
             . "💰 Nominal: Rp {$total}\n\n"
             . "Mohon segera dikonfirmasi. Terima kasih 🙏";
        return $this->deepLink($this->adminPhone ?: '081234567890', $msg);
    }

    /** Link kurir → customer */
    public function kurirToCustomerLink(Order $order): string
    {
        if (!$order->customer->phone) return '#';
        $msg = "Halo *{$order->customer->name}* 👋\n\n"
             . "Saya kurir LaundryTrack, sedang dalam perjalanan menjemput cucian kamu.\n"
             . "📋 Order: *{$order->order_code}*\n\n"
             . "Apakah kamu sudah siap di lokasi? 🛵";
        return $this->deepLink($order->customer->phone, $msg);
    }

    // ─── Private: Core dispatcher ─────────────────────────────────

    private function dispatch(string $phone, string $message, string $ctx = ''): NotifResult
    {
        if (empty(trim($phone))) {
            Log::warning("WA [{$ctx}]: nomor HP kosong");
            return NotifResult::skipped('Nomor HP tidak ada');
        }

        $normalized = $this->normalizePhone($phone);
        $link       = 'https://wa.me/' . $normalized . '?text=' . urlencode($message);

        Log::info("WA [{$ctx}] → {$normalized}");

        if (!$this->useApi) {
            return NotifResult::deepLinkOnly($link);
        }

        return $this->sendViaFonnte($normalized, $message, $link, $ctx);
    }

    /**
     * Kirim via Fonnte
     *
     * Endpoint : POST https://api.fonnte.com/send
     * Header   : Authorization: {token}   (BUKAN Bearer, langsung tokennya)
     * Body     : target, message
     *
     * Response sukses: { "status": true, "target": "628xxx", ... }
     * Response gagal : { "status": false, "reason": "..." }
     */
    private function sendViaFonnte(string $phone, string $message, string $fallback, string $ctx): NotifResult
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => $this->apiToken])
                ->post($this->apiUrl, [
                    'target'  => $phone,
                    'message' => $message,
                    'typing'  => true,
                    'delay'   => 1,
                ]);

            $body = $response->json() ?? [];

            if ($response->successful() && ($body['status'] ?? false)) {
                Log::info("WA sent [{$ctx}] → {$phone}");
                return NotifResult::sent($phone, $message);
            }

            $err = $body['reason'] ?? $response->body();
            Log::error("WA API error [{$ctx}]: {$err}");
            return NotifResult::failed($err, $fallback);

        } catch (\Exception $e) {
            Log::error("WA exception [{$ctx}]: " . $e->getMessage());
            return NotifResult::failed($e->getMessage(), $fallback);
        }
    }

    // ─── Private: Normalisasi nomor HP ────────────────────────────

    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0'))  return '62' . substr($phone, 1);
        if (!str_starts_with($phone, '62')) return '62' . $phone;
        return $phone;
    }

    // ─── Private: Template pesan ──────────────────────────────────

    private function tplOrderCreated(Order $order): string
    {
        $fee  = $order->pickup_type === 'jemput' ? "\n⚡ Biaya Jemput   : +Rp 1.000" : '';
        $type = $order->pickup_type === 'jemput' ? '🛵 Jemput ke Alamat' : '🏠 Antar Sendiri';
        return
"🧺 *LaundryTrack — Order Diterima!*

Halo *{$order->customer->name}*, pesananmu berhasil! 🎉

━━━━━━━━━━━━━━━━━━━
No. Order  : *{$order->order_code}*
Layanan    : {$order->service->name}
Jenis      : {$type}{$fee}
Est. Selesai: {$order->service->estimated_days} hari kerja
Status     : ⏳ Menunggu proses
━━━━━━━━━━━━━━━━━━━

Pantau: " . config('app.url') . "/track/{$order->order_code}

_Terima kasih sudah mempercayakan cucianmu ke kami_ 💙";
    }

    private function tplStatusChanged(Order $order): string
    {
        $msg = match ($order->status) {
            'pickup'     => "🛵 Kurir kami sedang dalam perjalanan menjemput cucianmu!",
            'in_process' => "🫧 Cucianmu sedang kami cuci & setrika dengan telaten.",
            'ready'      => "✅ *Cucianmu sudah SELESAI!* Siap diambil atau segera diantar.",
            'finished'   => "🎊 Transaksi selesai. Terima kasih telah menggunakan LaundryTrack!",
            default      => "Status ordermu telah diperbarui.",
        };
        $total = number_format($order->total_price, 0, ',', '.');
        return
"🧺 *LaundryTrack — Update Status*

Halo *{$order->customer->name}*! 👋

{$msg}

📋 No. Order : *{$order->order_code}*
💰 Total     : Rp {$total}

Pantau: " . config('app.url') . "/track/{$order->order_code}";
    }

    private function tplKurirPickup(Order $order): string
    {
        $note = $order->pickup_note ? "\n📝 Catatan   : {$order->pickup_note}" : '';
        return
"🛵 *LaundryTrack — Tugas Jemputan Baru!*

Halo *{$order->kurir->name}*! Ada order jemput untukmu 📦

━━━━━━━━━━━━━━━━━━━
No. Order  : *{$order->order_code}*
Customer   : {$order->customer->name}
📱 HP      : {$order->customer->phone}
📍 Alamat  : {$order->pickup_address}{$note}
Layanan    : {$order->service->name}
━━━━━━━━━━━━━━━━━━━

Segera konfirmasi di aplikasi! 🚀";
    }

    private function tplPaymentVerified(Order $order): string
    {
        $total  = number_format($order->total_price, 0, ',', '.');
        $method = strtoupper($order->payment->method ?? 'cash');
        return
"✅ *LaundryTrack — Pembayaran Dikonfirmasi*

Halo *{$order->customer->name}*! 🎉

Pembayaranmu sebesar *Rp {$total}* telah kami terima.

📋 No. Order : *{$order->order_code}*
💰 Nominal   : Rp {$total}
💳 Metode    : {$method}

Terima kasih sudah menggunakan *LaundryTrack*! 💙";
    }

    private function tplPaymentRejected(Order $order): string
    {
        $admin = $this->normalizePhone($this->adminPhone ?: '081234567890');
        return
"❌ *LaundryTrack — Bukti Bayar Ditolak*

Halo *{$order->customer->name}*, maaf ada kendala 😔

Bukti pembayaran order *{$order->order_code}* tidak dapat kami verifikasi.

*Kemungkinan penyebab:*
• Foto tidak jelas / buram
• Nominal tidak sesuai
• Rekening tujuan salah

Silakan upload ulang atau hubungi kami:
📱 wa.me/{$admin}

Mohon maaf atas ketidaknyamanannya 🙏";
    }
}

// ─────────────────────────────────────────────────────────────────
// Value Object — hasil pengiriman notifikasi
// ─────────────────────────────────────────────────────────────────

class NotifResult
{
    public function __construct(
        public readonly string  $status,
        public readonly ?string $phone    = null,
        public readonly ?string $message  = null,
        public readonly ?string $deepLink = null,
        public readonly ?string $error    = null,
    ) {}

    public static function sent(string $phone, string $msg): self
    {
        return new self('sent', $phone, $msg);
    }

    public static function deepLinkOnly(string $link): self
    {
        return new self('deep_link', deepLink: $link);
    }

    public static function failed(string $err, string $link): self
    {
        return new self('failed', error: $err, deepLink: $link);
    }

    public static function skipped(string $reason): self
    {
        return new self('skipped', error: $reason);
    }

    public function wasDelivered(): bool { return $this->status === 'sent'; }
    public function hasDeepLink(): bool  { return !empty($this->deepLink); }
}