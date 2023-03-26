<?php

use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WeightController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('consumptions', ConsumptionController::class);
Route::resource('foods', FoodController::class);
Route::resource('settings', SettingsController::class);
Route::resource('weights', WeightController::class);
