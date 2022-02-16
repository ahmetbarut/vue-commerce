<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProductController::class)->prefix('products')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
    });

Route::controller(LoginController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::controller(OrderController::class)
    ->middleware('auth:sanctum')
    ->prefix('orders')
    ->group(function () {
        Route::post('/', 'index');
        Route::post('/checkout', 'store');
    });
