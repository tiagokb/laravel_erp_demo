<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->get();

        return view('product.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => ['required'],
                'price' => ['required'],
                'variations' => ['required', 'array']
            ]);

            $validated['price'] = preg_replace('/\D/', '', $validated['price']);
            $product = Product::create($validated);

            foreach ($validated['variations'] as $variationData) {
                $variation = $product->variations()->create($variationData);
                $variation->stock()->create($variationData);
            }

            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->withErrors(['error' => 'opss']);
        }
    }

    public function edit($id)
    {

        $product = Product::with('variations.stock')->find($id);

        return view('product.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'price' => ['required'],
        ]);

        $product = Product::find($id);
        $validated['price'] = preg_replace('/\D/', '', $validated['price']);
        $product->update($validated);
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('products.index');
    }
}
