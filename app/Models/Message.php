<?php

// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id', 'sender_id',
        'body', 'type', 'attachment_path', 'read_at', 'laundry_id',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'laundry_id' => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────────────

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function isMine(?int $userId = null): bool
    {
        return $this->sender_id === ($userId ?? auth()->id());
    }

    public function isSystem(): bool
    {
        return $this->type === 'system';
    }

    /**
     * Format waktu: tampilkan jam:menit jika hari ini,
     * atau tanggal jika hari lain
     */
    public function getTimeLabel(): string
    {
        if ($this->created_at->isToday()) {
            return $this->created_at->format('H:i');
        }
        if ($this->created_at->isYesterday()) {
            return 'Kemarin ' . $this->created_at->format('H:i');
        }
        return $this->created_at->isoFormat('D MMM, H:mm');
    }

    // ─── Boot: Eloquent Model Events ──────────────────────────────

    protected static function booted(): void
    {
        // ✨ AMAN & OTOMATIS: Wariskan laundry_id dari percakapan induk sebelum data pesan di-insert
        static::creating(function (Message $message) {
            if ($message->conversation_id && !$message->laundry_id) {
                if ($message->conversation) {
                    $message->laundry_id = $message->conversation->laundry_id;
                }
            }
        });

        // 🔄 BAWAAN AWAL: Mengupdate cache info pesan terakhir pada tabel conversations setelah sukses create
        static::created(function (Message $message) {
            // Setelah pesan disimpan, update cache di tabel conversations
            $message->conversation->updateLastMessage($message);
        });
    }
}