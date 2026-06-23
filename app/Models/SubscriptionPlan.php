<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'monthly_price', 'fee_percentage'];

    // Relasi: Satu paket bisa dipakai oleh banyak toko laundry
    public function laundries(): HasMany
    {
        return $this->hasMany(Laundry::class, 'subscription_plan_id');
    }
}