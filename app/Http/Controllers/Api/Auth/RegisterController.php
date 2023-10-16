<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $registerRequest)  
    {
        $user = User::create($registerRequest->validated());

        return response()->json([
            'status' => 200, 
            'message' => 'User successfully registered.',
            'token' => $user->createToken($user->name)->plainTextToken
        ]);
    }
}
