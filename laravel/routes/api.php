<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/userdata', [OrderController::class,'login']);
Route::get('/getMenu', [OrderController::class,'getMenu']);

Route::post('/create-transaction', [CheckoutController::class, 'createTransaction']);
Route::post('/makeOrder', [CheckoutController::class, 'store']);
