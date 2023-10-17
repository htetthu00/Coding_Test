<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BlogController;

Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('blogs', [BlogController::class, 'index']);
    Route::post('blogs', [BlogController::class, 'store']);
    Route::get('blogs/{id}', [BlogController::class, 'show']);
    Route::patch('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'destroy']);
});

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login', [LoginController::class, 'login']);
