<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Inventory extends Model
{
    protected $fillable = [
        'name', 'category', 'stock', 'unit',
        'min_stock', 'price_per_unit', 'notes', 'is_halal_certified',
    ];
 
    protected $casts = [
        'stock'          => 'decimal:2',
        'min_stock'      => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'is_halal_certified' => 'boolean',
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