<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ─── Service ──────────────────────────────────────────────────────────
class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'price_per_kg',
        'estimated_days', 'is_active', 'icon',
    ];

    protected $casts = [
        'price_per_kg'    => 'decimal:2',
        'estimated_days'  => 'integer',
        'is_active'       => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}


// ─── Payment ──────────────────────────────────────────────────────────
class Payment extends Model
{
    protected $fillable = [
        'order_id', 'payment_code', 'amount',
        'method', 'status', 'proof_image',
        'notes', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateCode(): string
    {
        $date   = now()->format('Ymd');
        $prefix = "PAY-{$date}-";
        $last   = self::where('payment_code', 'like', $prefix . '%')
                      ->orderByDesc('id')
                      ->value('payment_code');
        $seq = $last ? (int) substr($last, -3) + 1 : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }

    public function isVerified(): bool { return $this->status === 'verified'; }
    public function isPending(): bool  { return $this->status === 'pending'; }
}


// ─── Inventory ────────────────────────────────────────────────────────
class Inventory extends Model
{
    protected $fillable = [
        'name', 'category', 'stock', 'unit',
        'min_stock', 'price_per_unit', 'notes',
    ];

    protected $casts = [
        'stock'          => 'decimal:2',
        'min_stock'      => 'decimal:2',
        'price_per_unit' => 'decimal:2',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function isLow(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    public function adjustStock(float $qty, string $type, string $desc, int $userId): void
    {
        $before = $this->stock;
        $this->stock = $type === 'in' ? $before + $qty : max(0, $before - $qty);
        $this->save();

        InventoryLog::create([
            'inventory_id'  => $this->id,
            'user_id'       => $userId,
            'type'          => $type,
            'quantity'      => $qty,
            'stock_before'  => $before,
            'stock_after'   => $this->stock,
            'description'   => $desc,
        ]);
    }
}


// ─── InventoryLog ─────────────────────────────────────────────────────
class InventoryLog extends Model
{
    protected $fillable = [
        'inventory_id', 'user_id', 'type',
        'quantity', 'stock_before', 'stock_after', 'description',
    ];

    protected $casts = [
        'quantity'    => 'decimal:2',
        'stock_before'=> 'decimal:2',
        'stock_after' => 'decimal:2',
    ];

    public function inventory() { return $this->belongsTo(Inventory::class); }
    public function user()      { return $this->belongsTo(User::class); }
}


// ─── Setting ──────────────────────────────────────────────────────────
class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'description'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );
    }
}