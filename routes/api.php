<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CountMeterController;

Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('api.login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});
