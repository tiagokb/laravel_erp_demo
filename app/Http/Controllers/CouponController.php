<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'discount' => ['required'],
            'code' => ['required', 'unique:coupons'],
            'min_value' => ['required'],
            'expires_at' => ['required'],
        ]);

        $validated['discount'] = preg_replace('/\D/', '', $validated['discount']);
        $validated['min_value'] = preg_replace('/\D/', '', $validated['min_value']);
        Coupon::create($validated);

        return redirect()->route('coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'discount' => ['required'],
            'min_value' => ['required'],
            'expires_at' => ['required'],
        ]);

        $validated['discount'] = preg_replace('/\D/', '', $validated['discount']);
        $validated['min_value'] = preg_replace('/\D/', '', $validated['min_value']);

        $coupon->update($validated);
        return redirect()->route('coupons.index');
    }
}
