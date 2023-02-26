<?php

use App\Http\Controllers\Admin\SizeController;
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

Route::get('/', [FrontendController::class, 'index']);
Route::get('/collections', [FrontendController::class, 'categories'])->name('collections');
Route::get('/collections/{category_slug}', [FrontendController::class, 'products'])->name('products');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('category', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('sliders', SliderController::class);

    Route::get('/product/{product_image_id}/delete', [ProductController::class, 'destroyImage'])->name('products.removeImage');
    Route::post('/products/product-color/{prod_color_id}', [ProductController::class, 'updateProdColorQty'])->name('products.updateProdColorQty');
    Route::get('/products/product-color/{prod_color_id}/delete', [ProductController::class, 'deleteProdColorQty'])->name('products.deleteProdColorQty');

    Route::post('/products/product-size/{prod_size_id}', [ProductController::class, 'updateProdSizeQty'])->name('products.updateProdSizeQty');
    Route::get('/products/product-size/{prod_size_id}/delete', [ProductController::class, 'deleteProdSizeQty'])->name('products.deleteProdSizeQty');

    //Route::get('/brands', App\Http\Livewire\Admin\Brand\Index::class);
    Route::get('/brand', Index::class)->name('brand.index');
    // Route::get('/category', [CategoryController::class, 'index'])->name('category');
    // Route::get('/category/create', [CategoryController::class, 'create'])->name('create-category');
});
