<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CafeteriaController;
use App\Http\Controllers\OrderController;

Route::get('/cafeteria/menu', [CafeteriaController::class, 'index']);
Route::get('/cafeteria/item/{type}/{id}', [CafeteriaController::class, 'showItem']);
Route::post('/cafeteria/orders', [OrderController::class, 'store']);