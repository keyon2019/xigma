<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
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
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\RetailerItemController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPointController;
use App\Http\Controllers\UserVehicleController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleVariationController;
use App\Http\Controllers\WidgetController;
use App\Models\Order;
use App\Models\Product;
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

Route::group(['middleware' => ['throttle:2,2']], function () {
    Route::post('otp', [\App\Http\Controllers\Auth\RegisterController::class, 'otp']);
});
Route::post('verify_otp', [\App\Http\Controllers\Auth\RegisterController::class, 'verifyOtp']);

Route::get('/', [HomeController::class, 'index']);

Route::post('/map/search', [MapController::class, 'search']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::post('/cart/from_invoice/{invoice}', [CartController::class, 'fromInvoice']);
Route::delete('/cart', [CartController::class, 'destroy']);

Route::resource('order', OrderController::class)->only(['show', 'index', 'store']);
Route::get('order/{order}/invoice', [OrderController::class, 'invoice']);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'analyze']);

Route::get('invoice', [InvoiceController::class, 'index']);
Route::get('/invoice/{invoice}', [InvoiceController::class, 'show']);
Route::post('/invoice', [InvoiceController::class, 'store']);
Route::get('/invoice/{invoice}/invoice', [InvoiceController::class, 'print']);

Route::get('/address', [AddressController::class, 'index']);
Route::patch('/address/{address}', [AddressController::class, 'update']);
Route::delete('address/{address}', [AddressController::class, 'destroy']);

Route::get('/product/{product}', [ProductController::class, 'show']);

Route::get('/category/{category}', [CategoryController::class, 'show']);

Route::any('/payment/{payment}', [PaymentController::class, 'update']);

Route::post('/item/{variation}/retailer', [ItemController::class, 'retailers']);

Route::post('/address', [AddressController::class, 'store']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/profile/edit', [ProfileController::class, 'edit']);
Route::patch('profile', [ProfileController::class, 'update']);
Route::patch('password', [ProfileController::class, 'changePassword']);

Route::post('/comment', [CommentController::class, 'store']);
Route::get('comment', [CommentController::class, 'userComments']);

Route::post('search', [SearchController::class, 'index']);

Route::get('vehicle', [UserVehicleController::class, 'index']);
Route::post('vehicle', [UserVehicleController::class, 'store']);
Route::delete('vehicle', [UserVehicleController::class, 'destroy']);

Route::get('return_request', [ReturnRequestController::class, 'index']);
Route::get('return_request/{return_request}', [ReturnRequestController::class, 'show']);
Route::post('return_request', [ReturnRequestController::class, 'store']);
Route::post('return_request/{return_request}/set_address', [ReturnRequestController::class, 'setAddress']);

Route::get('stock', [StockController::class, 'supply']);
Route::get('point/overview', [PointController::class, 'overview']);
Route::get('point', [PointController::class, 'index']);

Route::get('coupon', [CouponController::class, 'index']);
Route::post('coupon', [CouponController::class, 'store']);
Route::post('coupon/validate', [CouponController::class, 'validateCoupon']);

Route::post('province', [ProvinceController::class, 'index']);

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'overview']);

    Route::resource('product', ProductController::class)->except(['show', 'destroy']);
    Route::resource('option', OptionController::class)->except(['show']);
    Route::resource('value', ValueController::class)->only(['store', 'update', 'destroy']);
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::resource('widget', WidgetController::class)->except(['show', 'index']);
    Route::resource('vehicle', VehicleController::class)->except(['show']);
    Route::resource('variation', VariationController::class)->only(['index', 'update', 'destroy']);
    Route::resource('slider', SliderController::class);
    Route::resource('retailer', RetailerController::class)->except(['show']);
    Route::resource('page', PageController::class)->except(['show']);

    Route::patch('shipping/{shipping}', [\App\Http\Controllers\ShippingController::class, 'update']);

    Route::get('widget/all', [WidgetController::class, 'all']);
    Route::post('widget/{widget}/purge', [WidgetController::class, 'purge']);

    Route::get('/discount', [DiscountController::class, 'create']);
    Route::post('/discount', [DiscountController::class, 'store']);
    Route::get('order', [OrderController::class, 'all']);
    Route::get('order/{order}/edit', [OrderController::class, 'edit']);
    Route::patch('order/{order}', [OrderController::class, 'update']);
    Route::get('order/user/{user}', [OrderController::class, 'userOrders']);

    Route::get('invoice', [InvoiceController::class, 'all']);
    Route::get('invoice/{invoice}/edit', [InvoiceController::class, 'edit']);

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
    Route::patch('/comment/{comment}', [CommentController::class, 'update']);
    Route::post('/comment/{comment}/approve', [CommentController::class, 'approve']);
    Route::delete('/comment/{comment}', [CommentController::class, 'disapprove']);

    Route::get('retailer/item', [RetailerItemController::class, 'create']);
    Route::post('retailer/item', [RetailerItemController::class, 'send']);
    Route::post('retailer/search', [RetailerController::class, 'search']);
    Route::post('item/find', [ItemController::class, 'find']);

    Route::resource('user', UserController::class)->except('show', 'destroy');
    Route::get('user/search', [UserController::class, 'search']);

    Route::post('/picture', [PictureController::class, 'store']);
    Route::delete('picture/{picture}', [PictureController::class, 'destroy']);

    Route::post('stock/{variation}', [StockController::class, 'update']);

    Route::get('return_request', [ReturnRequestController::class, 'all']);
    Route::get('return_request/{return_request}/edit', [ReturnRequestController::class, 'edit']);
    Route::patch('return_request/{return_request}', [ReturnRequestController::class, 'update']);

    Route::get('user/{user}/point', [UserPointController::class, 'index']);
    Route::post('user/{user}/point', [UserPointController::class, 'store']);

    Route::get('address/user/{user}', [AddressController::class, 'userAddresses']);

    Route::get('report/order', [ReportController::class, 'order']);
    Route::get('report/point', [ReportController::class, 'point']);
    Route::get('report/product', [ReportController::class, 'product']);
    Route::get('report/category', [ReportController::class, 'category']);
    Route::get('report/return_request', [ReportController::class, 'returnRequest']);
    Route::get('report/shipping', [ReportController::class, 'shipping']);
    Route::get('report/shipping_average', [ReportController::class, 'shippingAverageTime']);
    Route::get('report/reminder', [ReportController::class, 'reminder']);
    Route::get('report/product_exit_average', [ReportController::class, 'productExitAverage']);

    Route::get('contact', [\App\Http\Controllers\ContactController::class, 'index']);
});

Route::get('reminder', [\App\Http\Controllers\ReminderController::class, 'index']);
Route::post('reminder', [\App\Http\Controllers\ReminderController::class, 'store']);
Route::delete('reminder/{reminder}', [\App\Http\Controllers\ReminderController::class, 'destroy']);
Route::get('contact', [\App\Http\Controllers\ContactController::class, 'show']);
Route::group(['middleware' => ['throttle:2,2']], function () {
    Route::post('contact', [\App\Http\Controllers\ContactController::class, 'store']);
});
Route::get('{page}', [PageController::class, 'show']);