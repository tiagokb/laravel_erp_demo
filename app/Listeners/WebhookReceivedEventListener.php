<?php

namespace App\Listeners;

use App\Events\WebhookReceivedEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;

class WebhookReceivedEventListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(WebhookReceivedEvent $event): void
    {
        $id = $event->id;
        $status = $event->status;

        $order = Order::find($id);
        $order->update([
            'status' => $status
        ]);
    }
}
