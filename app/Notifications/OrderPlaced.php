<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database']; // ولا mail إلا بغيتي
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Order placed successfully',
            'order_id' => $this->order->id,
            'total' => $this->order->total
        ];
    }
}
