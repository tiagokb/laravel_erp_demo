<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class WebhookReceivedEvent
{
    use Dispatchable;

    public function __construct(
        public int    $id,
        public string $status
    )
    {
    }
}
