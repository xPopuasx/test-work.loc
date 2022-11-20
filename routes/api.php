<?php

use App\Http\Controllers\Api\Admin\Car\CarController;
use App\Http\Controllers\Api\Admin\User\UserController;
use App\Http\Controllers\Api\Public\AuthController;
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

/** Авторизация (получение у адаление api токена) */
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'users' => UserController::class,
        'cars' => CarController::class,
    ]);
});
