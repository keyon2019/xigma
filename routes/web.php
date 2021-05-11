<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionsController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleVariationController;
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

Route::get('test', function () {
    dd(\App\Models\Product::first()->toJson());
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'overview']);

    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/create', [ProductController::class, 'create']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/product/{product}/edit', [ProductController::class, 'edit']);
    Route::patch('/product/{product}', [ProductController::class, 'update']);
    Route::post('/product', [ProductController::class, 'store']);

    Route::get('/option', [OptionController::class, 'index']);
    Route::get('/option/create', [OptionController::class, 'create']);
    Route::post('/option', [OptionController::class, 'store']);
    Route::get('/option/{option}/edit', [OptionController::class, 'edit']);
    Route::patch('/option/{option}', [OptionController::class, 'update']);

    Route::post('/value', [ValueController::class, 'store']);
    Route::patch('/value/{value}', [ValueController::class, 'update']);
    Route::delete('/value/{value}', [ValueController::class, 'destroy']);

    Route::post('/product/{product}/option', [ProductOptionsController::class, 'store']);
    Route::delete('/product/{product}/option', [ProductOptionsController::class, 'destroy']);

    Route::post('/product/{product}/variation', [VariationController::class, 'store']);
    Route::get('/variation', [VariationController::class, 'index']);
    Route::patch('/variation/{variation}', [VariationController::class, 'update']);
    Route::delete('/variation/{variation}', [VariationController::class, 'destroy']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/create', [CategoryController::class, 'create']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit']);
    Route::patch('/category/{category}', [CategoryController::class, 'update']);

    Route::post('/product/{product}/category', [ProductCategoryController::class, 'store']);
    Route::delete('/product/{product}/category', [ProductCategoryController::class, 'destroy']);

    Route::get('/vehicle', [VehicleController::class, 'index']);
    Route::post('/vehicle', [VehicleController::class, 'store']);
    Route::get('/vehicle/create', [VehicleController::class, 'create']);
    Route::get('/vehicle/{vehicle}/edit', [VehicleController::class, 'edit']);
    Route::patch('/vehicle/{vehicle}', [VehicleController::class, 'update']);

    Route::post('/vehicle/{vehicle}/variation', [VehicleVariationController::class, 'store']);
    Route::delete('/vehicle/{vehicle}/variation', [VehicleVariationController::class, 'destroy']);

    Route::post('/picture', [PictureController::class, 'store']);
});