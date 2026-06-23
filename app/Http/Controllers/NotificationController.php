<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mengambil data notifikasi untuk komponen Alpine.js di layout
     */
    public function fetch()
    {
        $user = Auth::user();
        
        $notifications = [];
        $unreadCount = 0;

        if ($user) {
            // 1. Hitung total notifikasi yang BELUM dibaca untuk angka di icon lonceng
            $unreadCount = $user->unreadNotifications()->count();
            
            // 2. Ambil 5 notifikasi terbaru (gabungan sudah & belum dibaca) 
            // agar riwayat/history tidak langsung kosong saat ditandai telah dibaca
            $notifications = $user->notifications()->limit(5)->get()->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'data' => [
                        'title' => $notification->data['title'] ?? 'Notifikasi Baru',
                        'message' => $notification->data['message'] ?? '',
                    ],
                    'read_at' => $notification->read_at, // ✨ Diperlukan Alpine untuk mendeteksi warna bg
                    'time_ago' => $notification->created_at->diffForHumans(), // ✨ Diperlukan untuk x-text="notif.time_ago"
                ];
            });
        }

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Menandai semua notifikasi milik user sebagai sudah terbaca
     */
    public function markAsRead()
    {
        $user = Auth::user();
        
        if ($user) {
            // Mengubah status semua notifikasi yang unread menjadi read
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['success' => true]);
    }
}