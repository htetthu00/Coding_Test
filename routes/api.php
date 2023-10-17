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
Route::get('blogs/{blog:slug}', [BlogController::class, 'show']);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    #Blogs
    Route::post('blogs', [BlogController::class, 'store']);
    Route::patch('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'destroy']);

    #User Profile
    Route::get('{user:slug}', [UserController::class, 'index']);
    Route::patch('profile/{user:slug}/update', [UserController::class, 'profileUpdate']);
});