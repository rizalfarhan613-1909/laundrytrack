<?php
// routes/channels.php
//
// File ini mendefinisikan siapa yang DIIZINKAN masuk ke channel tertentu.
// Laravel Reverb akan memanggil callback ini saat user subscribe ke private channel.

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

// ──────────────────────────────────────────────────────────────────────────────
// Channel: conversation.{id}
// Digunakan oleh: ChatBox untuk terima pesan real-time
// Otorisasi: user harus peserta conversation tersebut
// ──────────────────────────────────────────────────────────────────────────────
Broadcast::channel('conversation.{conversationId}', function ($user, int $conversationId) {
    $conv = Conversation::find($conversationId);

    if (!$conv) return false;

    // Hanya participant_one atau participant_two yang diizinkan
    return in_array($user->id, [
        $conv->participant_one_id,
        $conv->participant_two_id,
    ]);
});

// ──────────────────────────────────────────────────────────────────────────────
// Channel: user.{userId}.inbox
// Digunakan oleh: ChatList untuk update badge + preview pesan di inbox
// Otorisasi: user hanya boleh subscribe ke channel miliknya sendiri
// ──────────────────────────────────────────────────────────────────────────────
Broadcast::channel('user.{userId}.inbox', function ($user, int $userId) {
    // User hanya boleh listen ke channel inboxnya sendiri
    return $user->id === $userId;
});