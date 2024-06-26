<?php

use App\Http\Controllers\Retailer\AuthController;
use App\Http\Controllers\Retailer\ItemController;
use App\Http\Controllers\Retailer\NotificationController;
use App\Http\Controllers\Retailer\OrderController;
use App\Http\Controllers\Retailer\ProductController;
use App\Http\Controllers\Retailer\RetailerController;
use App\Http\Controllers\Retailer\ShippingController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::post('login', [AuthController::class, 'login']);
//Route::post('logout', [AuthController::class, 'logout']);
//
//Route::post('item', [ItemController::class, 'commit']);
//Route::post('item/sold', [ItemController::class, 'sold']);
//
//Route::get('sync-products', [ProductController::class, 'sync']);
//Route::get('notification', [NotificationController::class, 'index']);
//
//Route::get('order', [OrderController::class, 'index']);
//Route::get('order/{order}', [OrderController::class, 'show']);
//
//Route::post('shipping/{shipping}/sail', [ShippingController::class, 'sail']);
//
//Route::get('retailer', [RetailerController::class, 'index']);
//Route::get('retailer/{retailer}', [RetailerController::class, 'show']);
