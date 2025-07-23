<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\RegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware(['auth'])->group(function(){
    Route::post('/checkout', [CheckOutController::class, 'checkout'])->name('checkout.post');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [OrderController::class, 'adminOrders'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminOrderShow'])->name('admin.orders.show');
});