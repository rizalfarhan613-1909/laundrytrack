<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltySetting extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'loyalty_settings';

    // Kolom yang diizinkan untuk pengisian massal (Mass Assignment)
    protected $fillable = [
        'laundry_id',
        'is_active',
        'threshold_amount',
        'points_earned',
    ];

    // Konversi tipe data otomatis saat diakses di PHP
    protected $casts = [
        'is_active' => 'boolean',
        'threshold_amount' => 'integer',
        'points_earned' => 'integer',
    ];

    /**
     * Relasi ke Toko Laundry (Setiap pengaturan poin dimiliki oleh satu toko).
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }
}