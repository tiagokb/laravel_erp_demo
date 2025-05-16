<?php

namespace App\Observers;

use App\Models\ProductVariation;

class ProductVariationObserver
{
    public function deleting(ProductVariation $productVariation): void
    {
        $productVariation->stock()->delete();
    }
}
