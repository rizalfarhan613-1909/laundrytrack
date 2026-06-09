<?php

// app/Livewire/Chat/ChatList.php
//
// Komponen daftar percakapan (Inbox).
// Menampilkan semua conversation user yang login,
// lengkap dengan badge unread, preview pesan terakhir,
// dan real-time update saat ada pesan masuk.

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    // ─── Properties ───────────────────────────────────────────────

    /** ID conversation yang sedang dipilih (aktif) */
    public ?int $activeConversationId = null;

    /** Daftar conversation untuk ditampilkan */
    public array $conversations = [];

    /** Total unread semua conversation (untuk badge di navbar) */
    public int $totalUnread = 0;

    // ─── Mount ────────────────────────────────────────────────────

    public function mount(?int $activeConversationId = null): void
    {
        $this->activeConversationId = $activeConversationId;
        $this->loadConversations();
    }

    // ─── Load Data ────────────────────────────────────────────────

    private function loadConversations(): void
    {
        $userId = Auth::id();

        $list = Conversation::forUser($userId)
            ->active()
            ->with([
                'participantOne:id,name,role',
                'participantTwo:id,name,role',
                'order:id,order_code,status',
            ])
            ->orderByDesc('last_message_at')
            ->get();

        $this->conversations = $list->map(function ($conv) use ($userId) {
            $other  = $conv->getOtherParticipant($userId);
            $unread = $conv->unreadCountFor($userId);

            return [
                'id'             => $conv->id,
                'order_id'       => $conv->order_id,
                'order_code'     => $conv->order?->order_code,
                'order_status'   => $conv->order?->status,
                'other_user'     => [
                    'id'   => $other->id,
                    'name' => $other->name,
                    'role' => $other->role,
                ],
                'last_message'    => $conv->last_message ?? 'Mulai percakapan...',
                'last_message_at' => $conv->last_message_at?->toISOString(),
                'last_sender_id'  => $conv->last_sender_id,
                'time_label'      => $this->formatTime($conv->last_message_at),
                'unread_count'    => $unread,
                'is_active'       => $conv->id === $this->activeConversationId,
            ];
        })->toArray();

        // Total unread untuk badge navbar
        $this->totalUnread = array_sum(array_column($this->conversations, 'unread_count'));
    }

    private function formatTime(?\Carbon\Carbon $time): string
    {
        if (!$time) return '';
        if ($time->isToday())     return $time->format('H:i');
        if ($time->isYesterday()) return 'Kemarin';
        return $time->isoFormat('D MMM');
    }

    // ─── Aksi: Pilih Conversation ─────────────────────────────────

    public function selectConversation(int $id): void
    {
        $this->activeConversationId = $id;

        // Update flag is_active di array lokal
        foreach ($this->conversations as &$conv) {
            $conv['is_active'] = $conv['id'] === $id;
            // Reset unread count di UI (optimistic update)
            if ($conv['id'] === $id) {
                $this->totalUnread -= $conv['unread_count'];
                $conv['unread_count'] = 0;
            }
        }

        // Beri tahu komponen parent (ChatPage) untuk menampilkan ChatBox
        $this->dispatch('conversation-selected', conversationId: $id);
    }

    // ─── Aksi: Buat Conversation Baru ────────────────────────────

    /**
     * Admin memulai chat dengan customer terkait sebuah order
     * Dipanggil dari halaman detail order di admin panel
     */
    public function startConversation(int $withUserId, ?int $orderId = null): void
    {
        $conversation = Conversation::findOrCreateBetween(
            Auth::id(),
            $withUserId,
            $orderId
        );

        $this->loadConversations();
        $this->selectConversation($conversation->id);
    }

    // ─── Real-time: Update Inbox dari WebSocket ───────────────────
    //
    // JavaScript di blade mendengarkan channel user-inbox.{userId}
    // dan dispatch event Livewire 'inbox-updated' dengan data conversation.

    #[On('inbox-updated')]
    public function onInboxUpdated(array $data): void
    {
        $convId = $data['conversation_id'];

        // Cari conversation yang di-update
        $found = false;
        foreach ($this->conversations as &$conv) {
            if ($conv['id'] === $convId) {
                $conv['last_message']    = $data['last_message'];
                $conv['last_message_at'] = $data['last_message_at'];
                $conv['time_label']      = $this->formatTime(
                    isset($data['last_message_at'])
                        ? \Carbon\Carbon::parse($data['last_message_at'])
                        : null
                );
                // Tambah unread hanya jika bukan conversation yang sedang aktif
                if ($convId !== $this->activeConversationId) {
                    $conv['unread_count'] = $data['unread_count'];
                    $this->totalUnread    = array_sum(array_column($this->conversations, 'unread_count'));
                }
                $found = true;
                break;
            }
        }

        // Jika conversation baru (belum ada di list), reload semua
        if (!$found) {
            $this->loadConversations();
        } else {
            // Urutkan ulang: conversation paling baru di atas
            usort($this->conversations, fn($a, $b) =>
                strcmp($b['last_message_at'] ?? '', $a['last_message_at'] ?? '')
            );
        }

        // Kirim total unread ke navbar badge (via JavaScript)
        $this->dispatch('update-unread-badge', count: $this->totalUnread);
    }

    // ─── Render ───────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}