<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyTransaction extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'loyalty_transactions';

    // Kolom yang diizinkan untuk pengisian massal (Mass Assignment)
    protected $fillable = [
        'user_id',
        'laundry_id',
        'order_id',
        'amount',
        'type',
        'description',
    ];

    // Konversi tipe data otomatis saat diakses di PHP
    protected $casts = [
        'amount' => 'integer',
        'user_id' => 'integer',
        'laundry_id' => 'integer',
        'order_id' => 'integer',
    ];

    /**
     * Relasi ke Pelanggan/User (Transaksi poin ini milik siapa).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Toko Laundry (Transaksi poin ini terjadi di toko mana).
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    /**
     * Relasi ke Order/Pesanan (Poin ini didapat dari order yang mana).
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Query Scope: Memudahkan pencarian transaksi yang sifatnya menambah poin.
     * Contoh penggunaan di Controller: LoyaltyTransaction::earning()->get();
     */
    public function scopeEarning($query)
    {
        return $query->where('type', 'earning');
    }

    /**
     * Query Scope: Memudahkan pencarian transaksi yang sifatnya menukar/memakai poin.
     * Contoh penggunaan di Controller: LoyaltyTransaction::redemption()->get();
     */
    public function scopeRedemption($query)
    {
        return $query->where('type', 'redemption');
    }
}