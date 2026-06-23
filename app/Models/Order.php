<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'customer_id', 'service_id', 'kurir_id', 'laundry_id',
        'weight_kg', 'price_per_kg', 'service_fee', 'total_price',
        'pickup_type', 'pickup_address', 'pickup_note',
        'status', 'notes', 'special_instructions',
        'pickup_at', 'process_at', 'ready_at', 'finished_at',
        'is_halal', 'is_halal_service', 'has_najis', 'halal_status', // ✨ FIX: Menambahkan kolom fitur syariah laundry
    ];

    protected $casts = [
        'pickup_at'        => 'datetime',
        'process_at'       => 'datetime',
        'ready_at'         => 'datetime',
        'finished_at'      => 'datetime',
        'weight_kg'        => 'decimal:2',
        'price_per_kg'     => 'decimal:2',
        'service_fee'      => 'decimal:2',
        'total_price'      => 'decimal:2',
        'is_halal'         => 'boolean',
        'is_halal_service' => 'boolean',
        'has_najis'        => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────────────
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /** ✨ FIX: Menghubungkan data order ke toko mitra laundry */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class, 'laundry_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function kurir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ─── Business Logic ────────────────────────────────────────────

    /**
     * Hitung total harga otomatis:
     * total = (berat_kg * harga_per_kg) + service_fee
     */
    public function calculateTotal(): float
    {
        $base = ($this->weight_kg ?? 0) * $this->price_per_kg;
        return $base + $this->service_fee;
    }

    /**
     * Convenience fee untuk layanan jemput
     */
    public static function getConvenienceFee(string $pickupType): float
    {
        if ($pickupType === 'jemput') {
            // Ambil dari database. Jika tidak ada, baru gunakan default 5000.
            return (float) \App\Models\Setting::get('pickup_fee', 5000);
        }
        return 0.00;
    }

    /**
     * Generate kode order unik: LT-YYYYMMDD-XXX
     */
    public static function generateCode(): string
    {
        $date   = now()->format('Ymd');
        $prefix = "LT-{$date}-";
        $last   = self::where('order_code', 'like', $prefix . '%')
                      ->orderByDesc('id')
                      ->value('order_code');

        $sequence = $last ? (int) substr($last, -3) + 1 : 1;
        return $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Status badge config untuk UI
     */
    public function getStatusBadge(): array
    {
        return match ($this->status) {
            'pending'    => ['label' => 'Menunggu',   'color' => 'amber',  'icon' => 'clock'],
            'pickup'     => ['label' => 'Dijemput',   'color' => 'blue',   'icon' => 'truck'],
            'in_process' => ['label' => 'Diproses',   'color' => 'purple', 'icon' => 'loader'],
            'ready'      => ['label' => 'Siap',       'color' => 'green',  'icon' => 'check-circle'],
            'finished'   => ['label' => 'Selesai',    'color' => 'gray',   'icon' => 'archive'],
            'cancelled'  => ['label' => 'Dibatalkan', 'color' => 'red',    'icon' => 'x-circle'],
            default      => ['label' => $this->status,'color' => 'gray',   'icon' => 'help-circle'],
        };
    }

    /**
     * Alur status berikutnya
     */
    public function getNextStatus(): ?string
    {
        return match ($this->status) {
            'pending'    => $this->pickup_type === 'jemput' ? 'pickup' : 'in_process',
            'pickup'     => 'in_process',
            'in_process' => 'ready',
            'ready'      => 'finished',
            default      => null,
        };
    }

    /**
     * Update status beserta timestamp terkait
     */
    public function advanceStatus(): bool
    {
        $next = $this->getNextStatus();
        if (!$next) return false;

        $timestamps = [
            'pickup'     => 'pickup_at',
            'in_process' => 'process_at',
            'ready'      => 'ready_at',
            'finished'   => 'finished_at',
        ];

        $this->status = $next;
        if (isset($timestamps[$next])) {
            $this->{$timestamps[$next]} = now();
        }

        return $this->save();
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['finished', 'cancelled']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopePendingPickup($query)
    {
        return $query->where('status', 'pending')
                     ->where('pickup_type', 'jemput');
    }
}