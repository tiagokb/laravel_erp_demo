<?php

namespace App\Models;

use App\Observers\OrderProductVariationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([OrderProductVariationObserver::class])]
class OrderProductVariant extends Model
{
    use SoftDeletes;

    protected $table = 'order_product_variation';

    protected $fillable = [
        'order_id',
        'product_variation_id',
        'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
