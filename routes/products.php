<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/foods', [ProductController::class, 'foodsAjax'])->name('foods.ajax');
Route::get('/drinks', [ProductController::class, 'drinksAjax'])->name('drinks.ajax');

// Cart routes
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // Đổi thành POST
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::post('products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/orders/{order}', [OrderController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});