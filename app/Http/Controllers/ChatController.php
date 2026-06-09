<?php

// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Halaman inbox chat utama
     * GET /chat
     */
    public function index(): \Illuminate\View\View
    {
        return view('chat.index', [
            'activeConversationId' => null,
        ]);
    }

    /**
     * Buka conversation tertentu
     * GET /chat/{conversation}
     */
    public function show(Conversation $conversation): \Illuminate\View\View
    {
        $userId = Auth::id();

        // Pastikan user ini peserta conversation
        abort_unless(
            in_array($userId, [
                $conversation->participant_one_id,
                $conversation->participant_two_id,
            ]),
            403,
            'Anda tidak memiliki akses ke percakapan ini.'
        );

        return view('chat.index', [
            'activeConversationId' => $conversation->id,
        ]);
    }

    /**
     * Mulai conversation baru (atau buka yang sudah ada)
     * POST /chat/start
     *
     * Dipakai oleh:
     * - Tombol "Chat" di halaman detail order (admin/kasir)
     * - Tombol "Hubungi Admin" di halaman customer
     * - Tombol "Chat Customer" di dashboard kurir
     */
    public function start(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'with_user_id' => 'required|exists:users,id',
            'order_id'     => 'nullable|exists:orders,id',
        ]);

        $userId     = Auth::id();
        $withUserId = (int) $request->with_user_id;
        $orderId    = $request->order_id ? (int) $request->order_id : null;

        // Cek tidak boleh chat dengan diri sendiri
        if ($userId === $withUserId) {
            return back()->withErrors(['error' => 'Tidak bisa chat dengan diri sendiri.']);
        }

        // Temukan atau buat conversation
        $conversation = Conversation::findOrCreateBetween($userId, $withUserId, $orderId);

        return redirect()->route('chat.show', $conversation);
    }
}