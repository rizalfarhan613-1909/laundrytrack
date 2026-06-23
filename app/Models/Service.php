<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
// ─── Service ──────────────────────────────────────────────────────────
class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'price_per_kg',
        'estimated_days', 'is_active', 'icon','laundry_id',
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