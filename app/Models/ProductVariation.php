<?php

namespace App\Models;

use App\Observers\ProductVariationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([ProductVariationObserver::class])]
class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'name',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function Orders(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function takeFromStock(int $quantity)
    {
        $this->stock->quantity -= $quantity;
        $this->stock->save();
    }

    public function addToStock(int $quantity)
    {
        $this->stock->quantity += $quantity;
        $this->stock->save();
    }
}
