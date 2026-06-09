<?php
// app/Events/InboxUpdated.php
// Dikirim ke channel pribadi penerima untuk update badge + list inbox.

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InboxUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Conversation $conversation,
        public readonly int          $recipientId,
    ) {}

    public function broadcastOn(): array
    {
        // Channel personal per user: user.{id}.inbox
        return [new PrivateChannel("user.{$this->recipientId}.inbox")];
    }

    public function broadcastAs(): string { return 'InboxUpdated'; }

    public function broadcastWith(): array
    {
        $other  = $this->conversation->getOtherParticipant($this->recipientId);
        $unread = $this->conversation->unreadFor($this->recipientId);

        return [
            'conversation_id' => $this->conversation->id,
            'order_id'        => $this->conversation->order_id,
            'order_code'      => $this->conversation->order?->order_code,
            'last_message'    => $this->conversation->last_message,
            'last_message_at' => $this->conversation->last_message_at?->toISOString(),
            'unread_count'    => $unread,
            'other_user'      => [
                'id'   => $other->id,
                'name' => $other->name,
                'role' => $other->role,
            ],
        ];
    }
}