<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Services\CartService;
use App\Services\ViaCepService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = app(CartService::class);
        $cartItems = $cart->items();
        return view('cart.index', compact('cartItems'));
    }

    public function buy()
    {
        $cart = app(CartService::class);

        if ($cart->isSomeItemOutOfStockAndRemove()) return redirect()->route('cart.index');

        $coupon = Coupon::find($cart->coupon());

        if ($coupon) {
            if (!$cart->isCouponValid($coupon)) {
                $cart->removeCoupon();
                return redirect()->route('cart.index')->withErrors(['code' => 'Cupom não disponivel/inválido']);
            }
        }

        if (!$cart->email()) {
            return redirect()->route('cart.index')->withErrors(['email' => 'Email do comprador ainda não foi cadastrado']);
        }

        if (!$cart->cep()) {
            return redirect()->route('cart.index')->withErrors(['cep' => 'CEP do comprador ainda não foi cadastrado']);
        }

        if (!$cart->houseNumber()) {
            return redirect()->route('cart.index')->withErrors(['house_number' => 'Numero da casa do comprador ainda não foi cadastrado']);
        }

        try {
            $cart->createOrder();
            return redirect()->route('products.index');
        } catch (\Throwable $e) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Opss, Ocorreu um erro ao criar o pedido']);
        }
    }

    public function addBuyer(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'cep' => ['required', 'integer', 'min_digits:8', 'max_digits:8'],
            'house_number' => ['required', 'string', 'max:14'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $cepService = app(ViaCepService::class);
        $cart = app(CartService::class);

        $errors = [];

        if (!$cepService->validate($validated['cep'])) {
            $errors['cep'] = "Cep Inválido";
        }

        if ($validated['code'] !== null) {
            if (!$cart->addCoupon($validated['code'])) {
                $errors['code'] = 'Cupom inválido';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('cart.index')->withErrors($errors);
        }

        $cart->addEmail($validated['email']);
        $cart->addCep($validated['cep']);
        $cart->addHouseNumber($validated['house_number']);

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        app(CartService::class)->remove($request->index);
        return redirect()->route('cart.index')->with('alert', 'Item removido do carrinho.');
    }
}
