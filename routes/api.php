<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\ProfileController;
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

Route::controller(PassportAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:api')->group(function () {

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart-count','checkCartCount');
        Route::post('/cart/{product_id}','addToCart');
        Route::get('/view-cart','cartShow');
        Route::delete('/cart/{cart_id}','destroy');
    });


    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'index');
        Route::post('/checkout', 'store');
    });

    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('view', 'show');
        Route::put('update', [ProfileController::class, 'update']);
        Route::get('logout', 'logout');
    });

    Route::prefix('favorites')->controller(FavoriteController::class)->group(function () {
        Route::post('/', 'index');
        Route::post('/add-to-favorite', 'store');
        Route::delete('/remove/{product}', 'destroy');

    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
