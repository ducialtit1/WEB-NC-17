<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // === DASHBOARD ===
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // === USER MANAGEMENT ===
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/toggle-admin', [AdminController::class, 'toggleUserAdmin'])->name('users.toggle-admin');

        // === PRODUCT MANAGEMENT ===
        Route::resource('products', ProductController::class)->except(['show']);

        // === COMMENT MANAGEMENT ===
        Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
        Route::put('/comments/{id}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::put('/comments/{id}/reject', [CommentController::class, 'reject'])->name('comments.reject');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // === ORDER MANAGEMENT ===
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::get('/orders/{id}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });
