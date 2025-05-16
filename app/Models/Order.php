<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'gross_value',
        'discount',
        'shipping_value',
        'net_value',
        'coupon_id',
        'cep',
        'house_number',
        'email',
        'status',
    ];

    protected function netValue(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => number_format($value / 100, 2, ',', '.'),
        );
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function productVariations(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariation::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function pay()
    {
        $this->update([
            'status' => OrderStatus::PAID
        ]);
    }

    public function cancel()
    {

        foreach ($this->productVariations as $variation) {
            // Acessa o modelo pivot associado a essa variação
            $pivot = OrderProductVariant::where('product_variation_id', $variation->id)->where('order_id', $this->id)->first();
            $pivot->delete();
        }

        $this->update([
            'status' => OrderStatus::CANCELED
        ]);
        $this->delete();
    }

    public function shipped()
    {
        $this->update([
            'status' => OrderStatus::SHIPPED
        ]);
    }
}
