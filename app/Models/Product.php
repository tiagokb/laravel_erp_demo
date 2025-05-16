<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    /**
     * Get the product's price.
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => number_format($value / 100, 2, ',', '.'),
        );
    }

    public function unformattedPrice(): int
    {
        return (int)preg_replace('/\D/', '', $this->price);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function totalStock()
    {
        return $this->variations->sum(function ($variation) {
            return optional($variation->stock)->quantity ?? 0;
        });
    }
}
