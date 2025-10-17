<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Product management
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    
    // Order management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::put('/orders/{id}/confirm', [AdminController::class, 'confirmOrder'])->name('orders.confirm');
    
    // Comment management
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::put('/comments/{comment}/approve', [AdminController::class, 'approveComment'])->name('comments.approve');
    Route::put('/comments/{comment}/reject', [AdminController::class, 'rejectComment'])->name('comments.reject');
    Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}/toggle-admin', [AdminController::class, 'toggleUserAdmin'])->name('users.toggle-admin');
});