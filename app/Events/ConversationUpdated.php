<?php

// app/Events/ConversationUpdated.php
//
// Dikirim ke INBOX user (bukan ke dalam chat box) untuk:
// 1. Update badge unread count di notifikasi
// 2. Pindahkan conversation ke posisi teratas inbox
// 3. Update preview last_message di list conversation

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // <-- DIPERBAIKI
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// <-- DIPERBAIKI: Pakai ShouldBroadcastNow
class ConversationUpdated implements ShouldBroadcastNow 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Conversation $conversation,
        public readonly int          $recipientId, // user yang menerima pesan (bukan pengirim)
    ) {}

    /**
     * Channel personal per user untuk update inbox.
     */
    public function broadcastOn(): array
    {
        return [
            // <-- DIPERBAIKI: Disamakan dengan routes/channels.php
            new PrivateChannel("user.{$this->recipientId}.inbox"), 
        ];
    }

    public function broadcastAs(): string
    {
        return 'ConversationUpdated';
    }

    public function broadcastWith(): array
    {
        $other = $this->conversation->getOtherParticipant($this->recipientId);
        $unread = $this->conversation->unreadCountFor($this->recipientId);

        return [
            'conversation_id'  => $this->conversation->id,
            'order_id'         => $this->conversation->order_id,
            'order_code'       => $this->conversation->order?->order_code,
            'other_user'       => [
                'id'   => $other->id,
                'name' => $other->name,
                'role' => $other->role,
            ],
            'last_message'     => $this->conversation->last_message,
            'last_message_at'  => $this->conversation->last_message_at?->toISOString(),
            'unread_count'     => $unread,
        ];
    }
}