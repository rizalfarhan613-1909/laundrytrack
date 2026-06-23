<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bagikan data hitungan unread secara otomatis ke seluruh file Blade (.blade.php)
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                // 1. Hitung total chat yang belum dibaca oleh user ini
                $unreadChats = Conversation::where(function($q) use ($userId) {
                                    $q->where('participant_one_id', $userId)->where('unread_one', '>', 0);
                                })->orWhere(function($q) use ($userId) {
                                    $q->where('participant_two_id', $userId)->where('unread_two', '>', 0);
                                })->count();

                // 2. Hitung notifikasi sistem bawaan laravel (opsional, set 0 jika belum pakai laravel notifications)
                $unreadNotifications = Auth::user()->unreadNotifications ?? collect([]);
                $unreadNotificationsCount = method_exists($unreadNotifications, 'count') ? $unreadNotifications->count() : 0;

                $view->with([
                    'globalUnreadChatsCount' => $unreadChats,
                    'globalUnreadNotificationsCount' => $unreadNotificationsCount,
                ]);
            }
        });
    }
}