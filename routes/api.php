<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for DataTables
Route::get('/airlines', [App\Http\Controllers\AirlineController::class, 'index']);
Route::get('/cities', [App\Http\Controllers\CityController::class, 'index']);
Route::get('/flights', [App\Http\Controllers\FlightController::class, 'index']);
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index']);
Route::get('/currency-rates', [App\Http\Controllers\CurrencyRateController::class, 'index']);

// API Routes for CRUD operations
Route::apiResource('cities', App\Http\Controllers\CityController::class);
Route::apiResource('airlines', App\Http\Controllers\AirlineController::class);
Route::apiResource('flights', App\Http\Controllers\FlightController::class);
Route::apiResource('customers', App\Http\Controllers\CustomerController::class);
Route::apiResource('bookings', App\Http\Controllers\BookingController::class);
Route::apiResource('currency-rates', App\Http\Controllers\CurrencyRateController::class);
