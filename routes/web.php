<?php

use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Livewire\Admin\Brand\Index;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/thanks', 'thanks')->name('thank-you');
    Route::prefix('collections')->group(function () {
        Route::get('/', 'categories')->name('collections');
        Route::get('/{category_slug}', 'products')->name('products');
        Route::get('/{category_slug}/{product_slug}', 'productView')->name('productView');
    });
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('wishlist')->controller(WishlistController::class)->group(function () {
        Route::get('/', 'index')->name('wishlist');
    });

    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('cart');
    });

    Route::prefix('checkout')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('checkout');
    });

    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('orders.index');
        Route::get('/{id}', 'show')->name('orders.show');
    });

    /*Route::get('/payment-cancel',function (){
        dd('cancel');
    })->name('payment.cancel');

    Route::get('/payment-success',function (){
        dd('success');
    })->name('payment.success');*/
});




Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('category', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('sliders', SliderController::class);

    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/{product_image_id}/delete', 'destroyImage')->name('products.removeImage');
        Route::post('/product-color/{prod_color_id}', 'updateProdColorQty')->name('products.updateProdColorQty');
        Route::get('/product-color/{prod_color_id}/delete', 'deleteProdColorQty')->name('products.deleteProdColorQty');

        Route::post('/product-size/{prod_size_id}', 'updateProdSizeQty')->name('products.updateProdSizeQty');
        Route::get('/product-size/{prod_size_id}/delete', 'deleteProdSizeQty')->name('products.deleteProdSizeQty');
    });

    //Route::get('/brands', App\Http\Livewire\Admin\Brand\Index::class);
    Route::get('/brand', Index::class)->name('brand.index');
    // Route::get('/category', [CategoryController::class, 'index'])->name('category');
    // Route::get('/category/create', [CategoryController::class, 'create'])->name('create-category');


    Route::prefix('orders')->controller(\App\Http\Controllers\Admin\OrderController::class)->group(function () {
        Route::get('/', 'index')->name('admin.orders.index');
        Route::get('/{order_id}', 'show')->name('admin.orders.show');
        Route::put('/{order_id}', 'updateOrderStatus')->name('admin.orders.updateOrderStatus');
    });
});
