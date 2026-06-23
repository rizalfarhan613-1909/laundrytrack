<?php

// app/Models/Conversation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    protected $fillable = [
        'participant_one_id',
        'participant_two_id',
        'order_id',
        'laundry_id', // ✨ Tambahkan ini agar percakapan tahu ini milik outlet mana
        'last_message',
        'last_message_at',
        'last_sender_id',
        'unread_one',
        'unread_two',
        'status',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // ─── Relasi ───────────────────────────────────────────────────

    public function participantOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_one_id');
    }

    public function participantTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_two_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** ✨ Relasi ke Toko Laundry */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class, 'laundry_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function lastSender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_sender_id');
    }

    // ─── Helper Methods ───────────────────────────────────────────

    public function getOtherParticipant(?int $userId = null): User
    {
        $userId ??= Auth::id();
        return $this->participant_one_id === $userId
            ? $this->participantTwo
            : $this->participantOne;
    }

    public function unreadCountFor(int $userId): int
    {
        if ($this->participant_one_id === $userId) {
            return $this->unread_one;
        }
        return $this->unread_two;
    }

    public function unreadFor(int $userId): int
    {
        return $this->unreadCountFor($userId);
    }

    public function markAsReadFor(int $userId): void
    {
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($this->participant_one_id === $userId) {
            $this->update(['unread_one' => 0]);
        } else {
            $this->update(['unread_two' => 0]);
        }
    }

    public function updateLastMessage(Message $message): void
    {
        $isParticipantOne = $message->sender_id === $this->participant_one_id;

        $this->update([
            'last_message'    => $message->type === 'text'
                ? $message->body
                : ($message->type === 'image' ? '📷 Gambar' : '🔔 ' . $message->body),
            'last_message_at' => $message->created_at,
            'last_sender_id'  => $message->sender_id,
            'unread_one'      => $isParticipantOne ? $this->unread_one : $this->unread_one + 1,
            'unread_two'      => $isParticipantOne ? $this->unread_two + 1 : $this->unread_two,
        ]);
    }

    /** ✨ Modifikasi findOrCreate untuk mengikat laundry_id */
    public static function findOrCreateBetween(int $userA, int $userB, ?int $orderId = null, ?int $laundryId = null): self
    {
        [$one, $two] = $userA < $userB ? [$userA, $userB] : [$userB, $userA];

        // Jika ada order_id, coba cari tahu laundry_id dari data order tersebut
        if ($orderId && !$laundryId) {
            $order = Order::find($orderId);
            $laundryId = $order ? $order->laundry_id : null;
        }

        return static::firstOrCreate(
            [
                'participant_one_id' => $one,
                'participant_two_id' => $two,
                'order_id'           => $orderId,
            ],
            [
                'laundry_id' => $laundryId,
                'status'     => 'active',
            ]
        );
    }

    // ─── Scope ────────────────────────────────────────────────────

    public function scopeForUser($query, int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('participant_one_id', $userId)
                ->orWhere('participant_two_id', $userId);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}