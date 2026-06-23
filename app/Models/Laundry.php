<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laundry extends Model
{
    use HasFactory;

    /**
     * Nama tabel penampung data (opsional, jika mengikuti standar jamak Laravel)
     */
    protected $table = 'laundries';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'image',             // ◄ BARU: Izinkan pengisian nama file foto real laundry
        'latitude',          // ◄ BARU: Izinkan pengisian koordinat Lintang GPS
        'longitude',
        'subscription_type',
        'subscription_until',
        'unpaid_commission',
        'status',
        'subscription_plan_id', // ◄ TAMBAHAN BARU: Menghubungkan ke paket SaaS
        'is_active',            // ◄ TAMBAHAN BARU: Untuk kontrol blokir/aktifkan toko
    ];

    /**
     * Konversi tipe data otomatis (Casting).
     */
    protected $casts = [
        'subscription_until' => 'datetime',
        'unpaid_commission'  => 'decimal:2',
        'latitude'           => 'float', // ◄ BARU: Otomatis konversi ke float untuk akurasi JavaScript
        'longitude'          => 'float', // ◄ BARU: Otomatis konversi ke float untuk akurasi JavaScript
        'is_active'          => 'boolean', // ◄ TAMBAHAN BARU: Cast ke true/false
    ];

    /**
     * Relasi: Satu tempat laundry memiliki banyak pengguna (Owner, Kasir, Kurir).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'laundry_id');
    }

    // Tambahkan ini di dalam class Laundry di file app/Models/Laundry.php
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}