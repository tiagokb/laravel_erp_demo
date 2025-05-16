<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Helpers\DateHelper;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProductVariant;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CartService
{
    private array $cart;

    public function __construct()
    {
        $this->cart = session('cart', [
            'items' => [],
            'coupon' => null,
            'cep' => null,
            'house_number' => null,
            'email' => null,
        ]);
    }

    public function isSomeItemOutOfStockAndRemove(): bool
    {
        $indexesToRemove = [];

        $itemsAreBeenRemoved = false;

        foreach ($this->cart['items'] as $index => $item) {
            $variation = ProductVariation::find($item['variation_id']);
            if ($variation->stock->quantity < $item['quantity']) {
                $indexesToRemove[] = $index;
                $itemsAreBeenRemoved = true;
            }
        }

        foreach ($indexesToRemove as $index) {
            $this->remove($index);
        }

        return $itemsAreBeenRemoved;
    }

    /**
     * @throws \Throwable
     */
    public function createOrder()
    {

        DB::beginTransaction();

        try {
            $order = Order::create([
                'gross_value' => $this->subtotal(),
                'discount' => $this->discount(),
                'shipping_value' => $this->shippingValue(),
                'net_value' => $this->total(),
                'coupon_id' => $this->coupon(),
                'cep' => $this->cep(),
                'house_number' => $this->houseNumber(),
                'email' => $this->email(),
                'status' => OrderStatus::WAITING_PAYMENT
            ]);

            foreach ($this->cart['items'] as $item) {
                OrderProductVariant::create([
                    'order_id' => $order->id,
                    'product_variation_id' => $item['variation_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            // limpa o carrinho se quiser
            $this->clear();
            return $order;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function add(int $variationId, int $quantity): void
    {
        $variation = ProductVariation::find($variationId);

        if ($variation->stock->quantity < $quantity) return;

        // Verifica se já existe essa variação no carrinho
        $existingIndex = collect($this->cart['items'])->search(fn($item) => $item['variation_id'] == $variationId);

        if ($existingIndex !== false) {
            // Atualiza a quantidade existente
            if ($variation->stock->quantity < $this->cart['items'][$existingIndex]['quantity'] + $quantity) return;
            $this->cart['items'][$existingIndex]['quantity'] += $quantity;
        } else {
            // Adiciona novo item
            $this->cart['items'][] = [
                'variation_id' => $variation->id,
                'quantity' => $quantity,
            ];
        }

        $this->persist();
    }

    public function items(): Collection
    {
        $this->cart['items'] = collect($this->cart['items'])->filter(function ($item) {

            $variation = ProductVariation::find($item['variation_id']);

            if ($variation === null) {
                return false;
            }

            $product = $variation->product;

            return $product !== null;
        })->values()->toArray();

        $this->persist();

        return collect($this->cart['items'])->map(function ($item) {
            $variation = ProductVariation::with('product')->find($item['variation_id']);

            $unitPrice = $variation->product->unformattedPrice();
            $total = $unitPrice * $item['quantity'];

            return [
                'product' => $variation->product,
                'variation' => $variation,
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'total' => $total,
            ];
        });
    }

    public function subtotal(): int
    {
        return $this->items()->sum('total');
    }

    public function shippingValue(): int
    {
        $subtotal = $this->subtotal();

        return match (true) {
            $subtotal >= 5200 && $subtotal <= 16659 => 1500,
            $subtotal > 20000 => 0,
            default => 2000,
        };
    }


    public function coupon()
    {
        return $this->cart['coupon'];
    }

    public function couponCode(): ?string
    {
        if (!$this->coupon()) return null;

        $coupon = Coupon::find($this->coupon());
        return $coupon->code;
    }

    public function addCoupon(string $code): bool
    {
        $this->removeCoupon();
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) return false;

        if (!$this->isCouponValid($coupon)) return false;

        $this->cart['coupon'] = $coupon->id;
        $this->persist();
        return true;
    }

    public function removeCoupon(): void
    {
        $this->cart['coupon'] = null;
        $this->persist();
    }

    public function isCouponValid(Coupon $coupon): bool
    {
        if (DateHelper::compareDateString(now()->format('Y-m-d'), $coupon->unformattedExpiresAt())) {
            return false;
        }

        if ($this->subtotal() < $coupon->unformattedMinValue()) {
            return false;
        }

        return true;
    }

    public function addCep(int $cep): void
    {
        $this->cart['cep'] = $cep;
        $this->persist();
    }

    public function cep()
    {
        return $this->cart['cep'];
    }

    public function addHouseNumber(int $houseNumber): void
    {
        $this->cart['house_number'] = $houseNumber;
        $this->persist();
    }

    public function houseNumber()
    {
        return $this->cart['house_number'];
    }

    public function addEmail(string $email): void
    {
        $this->cart['email'] = $email;
        $this->persist();
    }

    public function email()
    {
        return $this->cart['email'];
    }

    public function discount()
    {

        if ($this->cart['coupon'] == null) return 0;

        $coupon = Coupon::find($this->cart['coupon']);

        if (!$this->isCouponValid($coupon)) {
            return 0;
        }

        return $coupon->unformattedDiscount();
    }

    public function total(): int
    {
        return $this->subtotal() + $this->shippingValue() - $this->discount();
    }

    public function remove($index): void
    {
        if (isset($this->cart['items'][$index])) {
            unset($this->cart['items'][$index]);
            $this->cart['items'] = array_values($this->cart['items']);
            $this->persist();
        }
    }

    private function persist(): void
    {
        session(['cart' => $this->cart]);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }
}
