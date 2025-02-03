<?php

use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Person\OrderPersonController;

Route::get('locale/{locale}', [MainController::class, 'changeLocale']) -> name('locale');
Route::get('currency/{currencyCode}', [MainController::class, 'changeCurrency']) -> name('currency');
Route::get('/reset', [ResetController::class, 'reset']) ->name('reset');

Route::middleware('set_locale')->group(function () {
    Route::name('user.')->namespace('App\Http\Controllers\Auth')->group(function() {
        Route::get('/login', [LoginController::class, 'login']) -> name('login');
        Route::get('/logout', [LoginController::class, 'logout']) -> name('logout');
        Route::post('/login', [LoginController::class, 'authorization']) -> name('auth');
        Route::get('/register', [RegisterController::class, 'registration']) -> name('register');
        Route::post('/register', [RegisterController::class, 'save']) -> name('save');
    });

    Route::middleware('auth')->group(function() {
        Route::prefix('person')->namespace('App\Http\Controllers\Person')->as('person.')->group(function() {
            Route::get('/orders', [OrderPersonController::class, 'orders']) -> name('orders');
            Route::get('/orders/{order}', [OrderPersonController::class, 'show']) -> name('orders-show');
        });
        Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function() {
            Route::middleware('is_admin')->group(function() {
                Route::get('/orders', [OrderController::class, 'orders']) -> name('orders');
                Route::get('/orders/{order}', [OrderController::class, 'show']) -> name('orders-show');
            });
            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
        });
    });

    Route::post('/basket/add/{product}', [BasketController::class, 'basketAdd']) -> name('basket-add');

    Route::middleware('basket_not_empty')->group(function() {
        Route::get('/basket', [BasketController::class, 'basket']) -> name('basket');
        Route::get('/basket/placeOrder', [BasketController::class, 'placeOrder']) -> name('placeOrder');
        Route::post('/basket/remove/{product}', [BasketController::class, 'basketRemove'])-> name('basket-remove');
        Route::post('/basket/placeOrder', [BasketController::class, 'basketConfirm']) -> name('basket-confirm');
    });

    Route::get('/', [MainController::class, 'index']) -> name('index');
    Route::get('/categories/', [MainController::class, 'categories']) -> name('categories');
    Route::get('/{category}', [MainController::class, 'category']) -> name('category');
    Route::get('/{category}/{product}', [MainController::class, 'product']) -> name('product');
    Route::post('/subscription/{product}', [MainController::class, 'subscribe']) -> name('subscription');
});
