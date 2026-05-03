<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthConnectionController;
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
Route::post('consumptions/{consumption}/copy-to-today', [ConsumptionController::class, 'copyToToday'])->name('consumptions.copyToToday');
Route::post('consumptions/copy-date', [ConsumptionController::class, 'copyDate'])->name('consumptions.copyDate');
Route::resource('foods', FoodController::class);
Route::resource('settings', SettingsController::class);
Route::resource('weights', WeightController::class);

Route::middleware('auth')->group(function () {
    Route::post('api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
    Route::post('api-tokens/{id}/refresh', [ApiTokenController::class, 'refresh'])->name('api-tokens.refresh');
    Route::delete('api-tokens/{id}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');

    Route::delete('oauth-connections/{client}', [OAuthConnectionController::class, 'destroy'])->name('oauth-connections.destroy');
});
