<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', 'getCustomer');
    Route::post('/customers', 'createCustomer');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'getProduct');
    Route::post('/products', 'createProduct');
});

Route::controller(SaleController::class)->group(function () {
    Route::get('/sales', 'getSale');
    Route::post('/sales', 'createSale');
});

Route::controller(StockController::class)->group(function () {
    Route::get('/stock', 'getStock');
    Route::post('/stock', 'createStock');
});
