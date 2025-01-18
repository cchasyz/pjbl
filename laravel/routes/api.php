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

Route::post('/payments', [CheckoutController::class, 'createPayment']);
Route::post('/webhook', [CheckoutController::class, 'handleWebhook'])->name('payment.callback');
