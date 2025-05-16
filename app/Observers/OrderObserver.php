<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Mail\OrderCanceledMail;
use App\Mail\OrderCreatedMail;
use App\Mail\OrderPaidMail;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Mail;

class OrderObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Order $order): void
    {
        Mail::to($order->email)->send(new OrderCreatedMail());
    }

    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            match ($order->status) {
                OrderStatus::PAID => Mail::to($order->email)->send(new OrderPaidMail()),
                OrderStatus::SHIPPED => Mail::to($order->email)->send(new OrderShippedMail()),
                OrderStatus::CANCELED => Mail::to($order->email)->send(new OrderCanceledMail()),
                default => Mail::to($order->email)->send(new OrderStatusChanged()),
            };
        }
    }
}
