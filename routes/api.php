<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserController;

#Auth
Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login', [LoginController::class, 'login']);

#Guest blogs route 
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{slug}', [BlogController::class, 'show']);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    #Blogs
    Route::post('blogs', [BlogController::class, 'store']);
    Route::patch('blogs/{slug}', [BlogController::class, 'update']);
    Route::delete('blogs/{slug}', [BlogController::class, 'destroy']);

    #User Profile
    Route::get('{username}', [UserController::class, 'index']);
    Route::patch('{username}/update', [UserController::class, 'profileUpdate']);
});