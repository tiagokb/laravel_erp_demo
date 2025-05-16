<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariation;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('coupon')->orderByDesc('id')->withTrashed()->get();
        return view('orders.index', compact('orders'));
    }

    public function pay($id)
    {

        $order = Order::find($id);
        $order->pay();

        return response()->json([
            'redirect' => route('orders.index'),
        ]);
    }

    public function cancel($id)
    {
        $order = Order::with('productVariations')->find($id);

        $order->cancel();

        return response()->json([
            'redirect' => route('orders.index'),
        ]);
    }
}
