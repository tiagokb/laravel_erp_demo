<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show($id)
    {
        $product = Product::with('variations.stock')->find($id);

        return view('stock.show', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'variations' => 'required|array',
            'variations.*.id' => 'nullable|exists:product_variations,id',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $variationIds = [];

        foreach ($validated['variations'] as $data) {
            $variation = isset($data['id'])
                ? $this->updateVariation($data)
                : $this->createVariation($product, $data);

            $variationIds[] = $variation->id;
        }

        // Deleta variações que não estão mais presentes
        $product->variations()->whereNotIn('id', $variationIds)->delete();

        return redirect()->route('products.index')->with('success', 'Estoque atualizado com sucesso!');
    }

    private function updateVariation(array $data): ProductVariation
    {
        $variation = ProductVariation::findOrFail($data['id']);
        $variation->update(['name' => $data['name']]);

        $variation->stock->update(['quantity' => $data['quantity']]);

        return $variation;
    }

    private function createVariation(Product $product, array $data): ProductVariation
    {
        $variation = $product->variations()->create(['name' => $data['name']]);
        $variation->stock()->create(['quantity' => $data['quantity']]);

        return $variation;
    }

}
