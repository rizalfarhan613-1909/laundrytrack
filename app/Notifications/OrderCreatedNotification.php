<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Aktifkan saluran database
    public function via($notifiable): array
    {
        return ['database'];
    }

    // Format data JSON yang akan dibaca oleh Alpine.js di layout lencana lonceng
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Pesanan Baru Masuk! 🧺',
            'message' => 'Orderan baru dengan kode #' . $this->order->order_code . ' menunggu untuk diproses.',
            'order_id' => $this->order->id
        ];
    }
}