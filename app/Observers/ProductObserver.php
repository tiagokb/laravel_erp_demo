<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductVariation;

class ProductObserver
{
    public function deleting(Product $product): void
    {
        $variations = $product->variations();

        foreach ($variations as $variation) {
            $variation->delete();
        }
    }
}
