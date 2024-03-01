<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', 'App\Http\Controllers\ProductController@index');

Route::apiResource('sales', SaleController::class)->only(['index', 'show', 'store']);
Route::put('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
Route::put('/sales/{sale}/add-product', [SaleController::class, 'addProductToSale'])->name('sales.add-product');


