<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
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