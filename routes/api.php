<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\PassportAuthController;
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
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/search/{id}/{search}', [CategoryController::class, 'searchProduct']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/cart-count', [CartController::class, 'checkCartCount']);
    Route::post('/cart/{product_id}', [CartController::class, 'addToCart']);
    Route::get('/view-cart', [CartController::class, 'cartShow']);
    Route::delete('/cart/{cart_id}', [CartController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
