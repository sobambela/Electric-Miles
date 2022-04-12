<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\DelayedOrdersController;
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

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::apiResource('/orders', OrderController::class);
    Route::get('/delayed', [DelayedOrdersController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
