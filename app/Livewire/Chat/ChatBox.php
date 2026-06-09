<?php

namespace App\Livewire\Chat;

// Komponen utama chat. Mengelola:
// - Memuat pesan dalam sebuah conversation
// - Mengirim pesan baru
// - Real-time update via Laravel Echo (JavaScript) + Livewire dispatch

use App\Events\ConversationUpdated;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;

    // ─── Properties (state komponen) ──────────────────────────────

    /** ID conversation yang sedang aktif */
    public int $conversationId;

    /** Objek conversation lengkap (lazy load) */
    public ?Conversation $conversation = null;

    /** Koleksi pesan */
    public array $messages = [];

    /** Input teks dari user */
    public string $newMessage = '';

    /** File attachment (opsional) */
    public $attachment = null;

    /** User lawan bicara */
    public ?array $otherUser = null;

    /** Loading state */
    public bool $isLoading = false;

    /** Menyimpan ID pesan yang sedang berada dalam mode pengeditan */
    public $editingMessageId = null;

    // ─── Mount ────────────────────────────────────────────────────

    public function mount(int $conversationId): void
    {
        $this->conversationId = $conversationId;
        $this->loadConversation();
    }

    // ─── Load Data ────────────────────────────────────────────────

    private function loadConversation(): void
    {
        $userId = Auth::id();

        $this->conversation = Conversation::with([
            'participantOne',
            'participantTwo',
            'order:id,order_code,status',
        ])->findOrFail($this->conversationId);

        // Pastikan user ini adalah peserta conversation
        abort_unless(
            in_array($userId, [
                $this->conversation->participant_one_id,
                $this->conversation->participant_two_id,
            ]),
            403,
            'Kamu tidak memiliki akses ke percakapan ini.'
        );

        // Info lawan bicara
        $other = $this->conversation->getOtherParticipant($userId);
        $this->otherUser = [
            'id'   => $other->id,
            'name' => $other->name,
            'role' => $other->role,
        ];

        // Tandai semua pesan sebagai dibaca
        $this->conversation->markAsReadFor($userId);

        // Muat pesan (50 terbaru, bisa di-paginate nanti)
        $this->loadMessages();
    }

    private function loadMessages(): void
    {
        $userId = Auth::id();

        $this->messages = Message::with('sender:id,name,role')
            ->where('conversation_id', $this->conversationId)
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->map(fn($msg) => $this->formatMessage($msg, $userId))
            ->values()
            ->toArray();
    }

    private function formatMessage(Message $msg, int $userId): array
    {
        return [
            'id'              => $msg->id,
            'body'            => $msg->body,
            'type'            => $msg->type,
            'attachment_path' => $msg->attachment_path,
            'sender_id'       => $msg->sender_id,
            'sender_name'     => $msg->sender->name,
            'sender_role'     => $msg->sender->role,
            'is_mine'         => $msg->sender_id === $userId,
            'is_system'       => $msg->type === 'system',
            'read_at'         => $msg->read_at?->toISOString(),
            'time_label'      => $msg->getTimeLabel(),
            'created_at'      => $msg->created_at->toISOString(),
        ];
    }

    // ─── Fitur Tambahan: Edit & Hapus Pesan ───────────────────────

    /** Pemicu mode pengeditan pesan */
    public function startEdit(int $messageId): void
    {
        $message = Message::find($messageId);
        
        // Validasi kepemilikan pesan dan pastikan bukan bertipe image
        if ($message && $message->sender_id === Auth::id() && $message->type !== 'image') {
            $this->editingMessageId = $messageId;
            $this->newMessage = $message->body;
        }
    }

    /** Membatalkan mode pengeditan */
    public function cancelEdit(): void
    {
        $this->editingMessageId = null;
        $this->newMessage = '';
    }

    /** Menghapus pesan secara permanen beserta file fisiknya jika ada */
    public function deleteMessage(int $messageId): void
    {
        $message = Message::find($messageId);

        if ($message && $message->sender_id === Auth::id()) {
            // Jika pesan berupa gambar, hapus file dari direktori storage
            if ($message->type === 'image' && $message->attachment_path) {
                Storage::disk('public')->delete($message->attachment_path);
            }

            $message->delete();

            // Batalkan mode edit jika pesan yang dihapus kebetulan sedang aktif diedit
            if ($this->editingMessageId === $messageId) {
                $this->cancelEdit();
            }

            // Segarkan data array lokal pesan
            $this->loadMessages();
        }
    }

    // ─── Kirim & Update Pesan ─────────────────────────────────────

    public function sendMessage(): void
    {
        // Validasi awal: pesan tidak boleh kosong
        if (empty(trim($this->newMessage)) && !$this->attachment) {
            return;
        }

        // Jalankan logika UPDATE jika komponen sedang berada dalam mode edit
        if ($this->editingMessageId) {
            $this->validate([
                'newMessage' => 'required|string|max:2000',
            ]);

            $message = Message::find($this->editingMessageId);
            if ($message && $message->sender_id === Auth::id()) {
                $message->update([
                    'body' => trim($this->newMessage)
                ]);

                // Segarkan data chat lokal
                $this->loadMessages();
            }

            $this->cancelEdit();
            return;
        }

        // Jalankan logika INSERT biasa (Kirim pesan baru) jika tidak sedang mengedit
        $this->validate([
            'newMessage'  => 'nullable|string|max:2000',
            'attachment'  => 'nullable|image|max:2048', // maks 2MB
        ]);

        $userId = Auth::id();
        $body   = trim($this->newMessage);

        // Simpan attachment jika ada
        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('chat-attachments', 'public');
            if (empty($body)) {
                $body = '📷 Gambar';
            }
        }

        // Buat pesan baru
        $message = Message::create([
            'conversation_id' => $this->conversationId,
            'sender_id'       => $userId,
            'body'            => $body ?: '📷',
            'type'            => $this->attachment ? 'image' : 'text',
            'attachment_path' => $attachmentPath,
        ]);

        $message->load('sender:id,name,role');
        $conversation = $this->conversation->fresh();

        // Tambahkan ke array lokal (optimistic update — tidak perlu reload)
        $this->messages[] = $this->formatMessage($message, $userId);

        // Reset input
        $this->newMessage = '';
        $this->attachment = null;

        // ── Broadcast via Reverb ───────────────────────────────────
        // Event ini dikirim ke WebSocket → semua browser yang listen
        // di channel conversation.{id} akan menerima pesan baru
        // broadcast(new MessageSent($message, $conversation))->toOthers();

        // Update inbox penerima
        $recipientId = $conversation->participant_one_id === $userId
            ? $conversation->participant_two_id
            : $conversation->participant_one_id;

        // broadcast(new ConversationUpdated($conversation, $recipientId));

        // Scroll ke bawah setelah kirim (JavaScript)
        $this->dispatch('message-sent');
    }

    // ─── Event Listener: Pesan Masuk dari WebSocket ───────────────
    //
    // Ketika Reverb mengirim event MessageSent, JavaScript di blade
    // akan dispatch event Livewire 'echo-received' dengan data pesan.
    // Method ini menangani pesan yang datang dari user lain.

    #[On('new-message-received')]
    public function onNewMessageReceived(array $data): void
    {
        // Pastikan pesan ini untuk conversation yang sedang dibuka
        if (($data['conversation_id'] ?? null) !== $this->conversationId) {
            return;
        }

        $userId = Auth::id();

        // Tambahkan pesan ke array (real-time update tanpa reload)
        $this->messages[] = [
            'id'              => $data['id'],
            'body'            => $data['body'],
            'type'            => $data['type'],
            'attachment_path' => $data['attachment_path'] ?? null,
            'sender_id'       => $data['sender_id'],
            'sender_name'     => $data['sender_name'],
            'sender_role'     => $data['sender_role'],
            'is_mine'         => false, // pesan dari orang lain
            'is_system'       => $data['type'] === 'system',
            'read_at'         => null,
            'time_label'      => $data['time_label'],
            'created_at'      => $data['created_at'],
        ];

        // Tandai sebagai dibaca karena chat sedang terbuka
        $this->conversation->markAsReadFor($userId);

        // Scroll ke bawah
        $this->dispatch('message-received');
    }

    // ─── Render ───────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}