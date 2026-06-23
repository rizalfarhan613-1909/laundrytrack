<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ◄ TAMBAHAN: Import class BelongsTo
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role',
        'is_active',
        'avatar',
        'laundry_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ─── Role Helpers ──────────────────────────────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    } // 👈 ✨ TAMBAHAN UNTUK CEO
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }
    public function isKurir(): bool
    {
        return $this->role === 'kurir';
    }
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'kasir', 'kurir']);
    }

    // ─── Relationships ─────────────────────────────────────────────
    
    /**
     * Relasi ke Toko / Outlet Laundry (SaaS Tenant)
     * Menghubungkan pegawai ke outlet laundry tempat mereka bertugas
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class, 'laundry_id');
    } // ◄ TAMBAHAN: Mengatasi eror Call to undefined relationship [laundry]

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Order::class, 'kurir_id');
    }

    /**
     * Relasi ke Riwayat Transaksi Poin.
     */
    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    /**
     * Fitur Tambahan: Menghitung total saldo poin user saat ini secara dinamis.
     * Contoh panggil di Blade: {{ auth()->user()->totalPoints() }}
     */
    public function totalPoints(): int
    {
        return $this->loyaltyTransactions()->sum('amount');
    }


    // ─── Redirect after login by role ─────────────────────────────
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'super_admin' => 'ceo.dashboard', // 👈 ✨ TAMBAHAN: Diarahkan ke dashboard khusus CEO
            'admin'    => 'admin.dashboard',
            'kasir'    => 'kasir.dashboard',
            'kurir'    => 'kurir.dashboard',
            'customer' => 'customer.dashboard',
            default    => 'home',
        };
    }
}