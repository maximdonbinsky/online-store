<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;


Route::get('/', [MainController::class, 'index']) -> name('index');
Route::get('/categories/', [MainController::class, 'categories']) -> name('categories');
Route::get('/basket', [BasketController::class, 'basket']) -> name('basket');
Route::get('/basket/placeOrder', [BasketController::class, 'placeOrder']) -> name('placeOrder');
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])-> name('basket-add');
Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])-> name('basket-remove');
Route::get('/{category}', [MainController::class, 'category']) -> name('category');
Route::get('/{category}/{product}', [MainController::class, 'product']) -> name('product');
