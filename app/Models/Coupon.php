<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discount',
        'code',
        'min_value',
        'expires_at',
    ];

    protected function casts()
    {
        return [
            'expires_at' => 'date',
        ];
    }

    /**
     * Get the coupon's expires_at.
     */
    protected function expiresAt(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    /**
     * Get the coupon's discount.
     */
    protected function discount(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => number_format($value / 100, 2, ',', '.'),
        );
    }

    /**
     * Get the coupon's min_value.
     */
    protected function minValue(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => number_format($value / 100, 2, ',', '.'),
        );
    }

    public function unformattedDiscount(): int
    {
        return (int)preg_replace("/\D/", "", $this->discount);
    }

    public function unformattedMinValue(): int
    {
        return (int)preg_replace("/\D/", "", $this->min_value);
    }

    public function unformattedExpiresAt(): string
    {
        return Carbon::createFromFormat('d/m/Y', $this->expires_at)->format('Y-m-d');
    }
}
