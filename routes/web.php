<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionsController;
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
//    \App\Models\Option::factory()->hasValues(3)->count(10)->create();
});

Route::get('/dashboard', [DashboardController::class, 'overview']);

Route::get('/dashboard/product', [ProductController::class, 'index']);
Route::get('/dashboard/product/create', [ProductController::class, 'create']);
Route::post('/dashboard/product', [ProductController::class, 'store']);
Route::get('/dashboard/product/{product}/edit', [ProductController::class, 'edit']);
Route::patch('/dashboard/product/{product}', [ProductController::class, 'update']);
Route::post('/dashboard/product', [ProductController::class, 'store']);

Route::get('/dashboard/option', [OptionController::class, 'index']);

Route::post('/dashboard/product/{product}/option', [ProductOptionsController::class, 'store']);
Route::delete('/dashboard/product/{product}/option', [ProductOptionsController::class, 'destroy']);

Route::post('/dashboard/product/{product}/variation', function (\Illuminate\Http\Request $request) {
    dd($request->all());
});

Route::post('/dashboard/picture', [PictureController::class, 'store']);