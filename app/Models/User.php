<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens; // 👈 TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'password', 'role', 'is_active', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ─── Role Helpers ──────────────────────────────────────────────
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isKasir(): bool    { return $this->role === 'kasir'; }
    public function isKurir(): bool    { return $this->role === 'kurir'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'kasir', 'kurir']);
    }

    // ─── Relationships ─────────────────────────────────────────────
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Order::class, 'kurir_id');
    }

    // ─── Redirect after login by role ─────────────────────────────
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin'    => 'admin.dashboard',
            'kasir'    => 'kasir.dashboard',
            'kurir'    => 'kurir.dashboard',
            'customer' => 'customer.dashboard',
            default    => 'home',
        };
    }
}