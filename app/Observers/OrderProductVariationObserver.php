<?php

namespace App\Observers;

use App\Models\OrderProductVariant;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class OrderProductVariationObserver implements ShouldHandleEventsAfterCommit
{
    public function created(OrderProductVariant $orderVariant): void
    {
        $orderVariant->productVariation->takeFromStock($orderVariant->quantity);
    }

    public function deleted(OrderProductVariant $orderVariant): void
    {
        $orderVariant->productVariation->addToStock($orderVariant->quantity);
    }
}
