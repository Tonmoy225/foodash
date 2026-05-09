<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderManageController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ClientController;

// ─────────────────────────────────────────
//  AUTH ROUTES
// ─────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────
//  CLIENT ROUTES
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
    Route::get('/product/{id}', [HomeController::class, 'product'])->name('product.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/voucher', [CartController::class, 'applyVoucher'])->name('cart.voucher');

    // Checkout & Payment
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment/{order}/process', [CheckoutController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/{order}/success', [CheckoutController::class, 'success'])->name('payment.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/location', [OrderController::class, 'getLocation'])->name('orders.location');
});

// ─────────────────────────────────────────
//  ADMIN ROUTES
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');

    // Orders Management
    Route::get('orders', [OrderManageController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderManageController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [OrderManageController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/location', [OrderManageController::class, 'updateLocation'])->name('orders.location');

    // Vouchers
    Route::resource('vouchers', VoucherController::class);
    Route::post('vouchers/{voucher}/toggle', [VoucherController::class, 'toggle'])->name('vouchers.toggle');

    // Clients
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{user}', [ClientController::class, 'show'])->name('clients.show');
});
