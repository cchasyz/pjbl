<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;

Route::post('/userdata', [OrderController::class,'login']);
Route::get('/getMenu', [OrderController::class,'getMenu']);
Route::post('/createMenu', [OrderController::class,'create']);
Route::delete('/deleteMenu/{name}', [OrderController::class,'delete']);
Route::put('/updateMenu/{name}', [OrderController::class,'update']);
Route::get('/getOrders', [OrderController::class,'getOrders']);

Route::post('/create-transaction', [CheckoutController::class, 'createTransaction']);
Route::post('/makeOrder', [CheckoutController::class, 'store']);

