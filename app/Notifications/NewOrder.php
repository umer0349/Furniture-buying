<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New order placed by: '.$this->order->user->name,
            'order_id' => $this->order->id,
            'user_id' => $this->order->user_id, // Assuming order has user_id
            'total_amount' => $this->order->total, // Assuming order has total amount
        ];
    }
}
