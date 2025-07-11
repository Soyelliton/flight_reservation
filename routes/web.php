<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CurrencyRateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashboard
Route::get('/', function () {
    return view('pages.dashboard');
});

// Airlines
Route::get('/airlines', function () {
    return view('pages.airlines.index');
});
Route::post('/airlines', [AirlineController::class, 'store']);
Route::get('/airlines/{id}', [AirlineController::class, 'show']);
Route::put('/airlines/{id}', [AirlineController::class, 'update']);
Route::delete('/airlines/{id}', [AirlineController::class, 'destroy']);

// Cities
Route::get('/cities', function () {
    return view('pages.cities.index');
});
Route::post('/cities', [CityController::class, 'store']);
Route::get('/cities/{id}', [CityController::class, 'show']);
Route::put('/cities/{id}', [CityController::class, 'update']);
Route::delete('/cities/{id}', [CityController::class, 'destroy']);

// Flights
Route::get('/flights', function () {
    return view('pages.flights.index');
});
Route::post('/flights', [FlightController::class, 'store']);
Route::get('/flights/{id}', [FlightController::class, 'show']);
Route::put('/flights/{id}', [FlightController::class, 'update']);
Route::delete('/flights/{id}', [FlightController::class, 'destroy']);
Route::get('/flights/{id}/availability', [FlightController::class, 'availability']);

// Customers
Route::get('/customers', function () {
    return view('pages.customers.index');
});
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

// Bookings
Route::get('/bookings', function () {
    return view('pages.bookings.index');
});
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

// Currency Rates
Route::get('/currency-rates', function () {
    return view('pages.currency-rates.index');
});
Route::post('/currency-rates', [CurrencyRateController::class, 'store']);
Route::get('/currency-rates/{id}', [CurrencyRateController::class, 'show']);
Route::put('/currency-rates/{id}', [CurrencyRateController::class, 'update']);
Route::delete('/currency-rates/{id}', [CurrencyRateController::class, 'destroy']);

