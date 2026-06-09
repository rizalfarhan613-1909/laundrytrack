<?php

// app/Events/MessageSent.php
//
// Event ini di-broadcast via WebSocket (Laravel Reverb) setiap kali
// ada pesan baru. Laravel Echo di browser akan mendengarkan event ini
// dan memperbarui UI chat secara real-time tanpa refresh halaman.

namespace App\Events;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Message      $message,
        public readonly Conversation $conversation,
    ) {}

    /**
     * Channel yang dipakai untuk broadcast.
     *
     * PrivateChannel → hanya user yang authenticated dan
     * diizinkan di routes/channels.php yang bisa mendengarkan.
     *
     * Format channel: conversation.{id}
     * Contoh: conversation.42
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("conversation.{$this->conversation->id}"),
        ];
    }

    /**
     * Nama event yang dikirim ke browser.
     * Laravel Echo akan listen: .MessageSent
     * (titik di depan = event dari server, bukan client)
     */
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    /**
     * Data yang dikirim bersama event ke browser.
     * Hanya kirim data yang dibutuhkan UI, jangan kirim seluruh model.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id'              => $this->message->id,
                'conversation_id' => $this->message->conversation_id,
                'sender_id'       => $this->message->sender_id,
                'sender_name'     => $this->message->sender->name,
                'sender_role'     => $this->message->sender->role,
                'body'            => $this->message->body,
                'type'            => $this->message->type,
                'attachment_path' => $this->message->attachment_path,
                'read_at'         => $this->message->read_at,
                'created_at'      => $this->message->created_at->toISOString(),
                'time_label'      => $this->message->getTimeLabel(),
                'is_mine'         => false, // akan di-override di frontend berdasarkan user
            ],
            'conversation' => [
                'id'              => $this->conversation->id,
                'order_id'        => $this->conversation->order_id,
                'order_code'      => $this->conversation->order?->order_code,
                'last_message'    => $this->conversation->last_message,
                'last_message_at' => $this->conversation->last_message_at?->toISOString(),
                'unread_one'      => $this->conversation->unread_one,
                'unread_two'      => $this->conversation->unread_two,
            ],
        ];
    }

    /**
     * ShouldBroadcastNow → kirim synchronous (tanpa queue)
     * Untuk chat, kita mau instan → tidak pakai queue delay
     */
    // Uncomment baris di bawah jika tidak pakai queue (lebih sederhana untuk development):
    // implements ShouldBroadcastNow
}