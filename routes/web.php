<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\RetailerItemController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserVehicleController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleVariationController;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index']);

Route::post('/map/search', [MapController::class, 'search']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::delete('/cart', [CartController::class, 'destroy']);

Route::resource('order', OrderController::class)->only(['show', 'index', 'store']);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'analyze']);

Route::get('/invoice/{invoice}', [InvoiceController::class, 'show']);
Route::post('/invoice', [InvoiceController::class, 'store']);

Route::get('/address', [AddressController::class, 'index']);

Route::get('/product/{product}', [ProductController::class, 'show']);

Route::get('/category/{category}', [CategoryController::class, 'show']);

Route::any('/payment/{payment}', [PaymentController::class, 'update']);

Route::post('/item/{variation}/retailer', [ItemController::class, 'retailers']);

Route::post('/address', [AddressController::class, 'store']);

Route::get('/profile', [ProfileController::class, 'index']);

Route::post('/comment', [CommentController::class, 'store']);

Route::post('search', [SearchController::class, 'index']);

Route::get('vehicle', [UserVehicleController::class, 'index']);
Route::post('vehicle', [UserVehicleController::class, 'store']);
Route::delete('vehicle', [UserVehicleController::class, 'destroy']);

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'overview']);

    Route::resource('product', ProductController::class)->except(['show', 'destroy']);
    Route::resource('option', OptionController::class)->except(['show', 'destroy']);
    Route::resource('value', ValueController::class)->only(['store', 'update', 'destroy']);
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::resource('widget', WidgetController::class)->except(['show', 'index']);
    Route::resource('vehicle', VehicleController::class)->except(['show']);
    Route::resource('variation', VariationController::class)->only(['index', 'update', 'destroy']);
    Route::resource('slider', SliderController::class);
    Route::resource('retailer', RetailerController::class)->except(['show', 'destroy']);
    Route::resource('page', PageController::class)->except(['show']);

    Route::get('widget/all', [WidgetController::class, 'all']);
    Route::post('widget/{widget}/purge', [WidgetController::class, 'purge']);

    Route::get('/discount', [DiscountController::class, 'create']);
    Route::post('/discount', [DiscountController::class, 'store']);
    Route::get('order', [OrderController::class, 'all']);
    Route::get('order/{order}/edit', [OrderController::class, 'edit']);

    Route::post('/product/{product}/option', [ProductOptionsController::class, 'store']);
    Route::delete('/product/{product}/option', [ProductOptionsController::class, 'destroy']);

    Route::post('/product/{product}/variation', [VariationController::class, 'store']);

    Route::post('/product/{product}/category', [ProductCategoryController::class, 'store']);
    Route::delete('/product/{product}/category', [ProductCategoryController::class, 'destroy']);

    Route::post('/vehicle/{vehicle}/variation', [VehicleVariationController::class, 'store']);
    Route::delete('/vehicle/{vehicle}/variation', [VehicleVariationController::class, 'destroy']);

    Route::get('/variation/{variation}/item', [ItemController::class, 'index']);
    Route::post('/variation/{variation}/item', [ItemController::class, 'store']);

    Route::get('/comment', [CommentController::class, 'index']);
    Route::patch('/comment/{comment}', [CommentController::class, 'approve']);

    Route::get('retailer/item', [RetailerItemController::class, 'create']);
    Route::post('retailer/item', [RetailerItemController::class, 'send']);
    Route::post('retailer/search', [RetailerController::class, 'search']);
    Route::post('item/find', [ItemController::class, 'find']);

    Route::resource('user', UserController::class)->except('show', 'destroy');
    Route::get('user/search', [UserController::class, 'search']);

    Route::post('/picture', [PictureController::class, 'store']);
});

Route::get('{page}', [PageController::class, 'show']);