<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::get('/products', ProductController::class);

Route::middleware([StartSession::class])->group(function () {
    Route::apiresource('/cart', CartController::class)->only(['index', 'store', 'destroy']);
});
