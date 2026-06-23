<?php

// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('chat.index', [
            'activeConversationId' => null,
        ]);
    }

    public function show(Conversation $conversation): \Illuminate\View\View
    {
        $userId = Auth::id();

        abort_unless(
            in_array($userId, [
                $conversation->participant_one_id,
                $conversation->participant_two_id,
            ]),
            403,
            'Anda tidak memiliki akses ke percakapan ini.'
        );

        // Tandai pesan sudah dibaca saat membuka room chat
        $conversation->markAsReadFor($userId);

        return view('chat.index', [
            'activeConversationId' => $conversation->id,
        ]);
    }

    public function start(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'with_user_id' => 'required|exists:users,id',
            'order_id'     => 'nullable|exists:orders,id',
            'laundry_id'   => 'nullable|exists:laundries,id', // Tambahan validasi laundry_id
        ]);

        $userId     = Auth::id();
        $withUserId = (int) $request->with_user_id;
        $orderId    = $request->order_id ? (int) $request->order_id : null;
        $laundryId  = $request->laundry_id ? (int) $request->laundry_id : null;

        if ($userId === $withUserId) {
            return back()->withErrors(['error' => 'Tidak bisa chat dengan diri sendiri.']);
        }

        $conversation = Conversation::findOrCreateBetween($userId, $withUserId, $orderId, $laundryId);

        return redirect()->route('chat.show', $conversation);
    }

    /** ✨ FUNGSI BARU: Menyimpan pesan teks baru dari form chat */
    public function store(Request $request, Conversation $conversation): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $userId = Auth::id();

        // Otomatis ambil laundry_id dari data conversation/order pembungkusnya
        $laundryId = $conversation->laundry_id;
        if (!$laundryId && $conversation->order) {
            $laundryId = $conversation->order->laundry_id;
        }

        // Simpan pesan baru ke database
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $userId,
            'body'            => $request->body,
            'type'            => 'text',
            'laundry_id'      => $laundryId, // Selesai! laundry_id terisi otomatis di sini
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}