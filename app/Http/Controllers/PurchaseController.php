<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Services\CartService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Product $product)
    {
        return view('purchase.index', [
            'product' => $product->load('variations.stock')
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1'],
                'variation-select' => ['required', 'exists:product_variations,id'],
            ]);

            $variation = ProductVariation::with('stock')->findOrFail($validated['variation-select']);

            if ($variation->product_id !== $product->id) {
                throw new \Exception('A variação selecionada não pertence ao produto informado.');
            }

            if ($variation->stock->quantity < $validated['quantity']) {
                throw new \Exception('Parece que o estoque para esse produto acabou.');
            }

            app(CartService::class)->add($variation->id, $validated['quantity']);

            return redirect()->route('products.index')
                ->with('alert', 'Produto adicionado ao carrinho.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
