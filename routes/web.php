<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook', [WebhookController::class, 'handle']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/email', function () {
    return view('emails.order-status-changed');
});

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('stock/{id}', [StockController::class, 'show'])->name('stock.show');
Route::put('stock/{id}', [StockController::class, 'update'])->name('stock.update');

Route::get('purchase/{product}', [PurchaseController::class, 'index'])->name('purchase.index');
Route::post('purchase/{product}', [PurchaseController::class, 'addToCart'])->name('purchase.cart');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/buyer', [CartController::class, 'addBuyer'])->name('cart.buyer');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/buy', [CartController::class, 'buy'])->name('cart.buy');

Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
Route::get('/coupons/edit/{coupon}', [CouponController::class, 'edit'])->name('coupons.edit');
Route::patch('/coupons/update/{coupon}', [CouponController::class, 'update'])->name('coupons.update');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::post('/pay/{id}', [OrderController::class, 'pay'])->name('orders.pay');
Route::post('/cancel/{id}', [OrderController::class, 'cancel'])->name('orders.cancel');

Route::post('/validate-cep', [CepController::class, 'validate'])->name('cep.validate');
