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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function lastSender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_sender_id');
    }

    // ─── Helper Methods ───────────────────────────────────────────

    /**
     * Dapatkan peserta "lawan" dari user yang sedang login
     * Berguna untuk menampilkan nama lawan bicara di inbox
     */
    public function getOtherParticipant(?int $userId = null): User
    {
        $userId ??= Auth::id();
        return $this->participant_one_id === $userId
            ? $this->participantTwo
            : $this->participantOne;
    }

    /**
     * Jumlah pesan belum dibaca untuk user tertentu
     */
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
    /**
     * Tandai semua pesan sebagai sudah dibaca untuk user tertentu
     */
    public function markAsReadFor(int $userId): void
    {
        // Update timestamp read_at di tabel messages
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Reset counter unread di tabel conversations
        if ($this->participant_one_id === $userId) {
            $this->update(['unread_one' => 0]);
        } else {
            $this->update(['unread_two' => 0]);
        }
    }

    /**
     * Update cache last_message setelah pesan baru dikirim
     */
    public function updateLastMessage(Message $message): void
    {
        $isParticipantOne = $message->sender_id === $this->participant_one_id;

        $this->update([
            'last_message'    => $message->type === 'text'
                ? $message->body
                : ($message->type === 'image' ? '📷 Gambar' : '🔔 ' . $message->body),
            'last_message_at' => $message->created_at,
            'last_sender_id'  => $message->sender_id,
            // Increment unread untuk penerima, bukan pengirim
            'unread_one'      => $isParticipantOne ? $this->unread_one : $this->unread_one + 1,
            'unread_two'      => $isParticipantOne ? $this->unread_two + 1 : $this->unread_two,
        ]);
    }

    /**
     * Cari atau buat conversation antara dua user (+ optional order)
     *
     * Aturan: participant_one selalu user dengan ID lebih kecil
     * untuk mencegah duplikasi (conv A-B dan conv B-A)
     */
    public static function findOrCreateBetween(int $userA, int $userB, ?int $orderId = null): self
    {
        // Urutkan ID agar konsisten
        [$one, $two] = $userA < $userB ? [$userA, $userB] : [$userB, $userA];

        return static::firstOrCreate(
            [
                'participant_one_id' => $one,
                'participant_two_id' => $two,
                'order_id'           => $orderId,
            ],
            [
                'status' => 'active',
            ]
        );
    }

    // ─── Scope ────────────────────────────────────────────────────

    /**
     * Ambil semua conversation yang melibatkan user tertentu
     */
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
