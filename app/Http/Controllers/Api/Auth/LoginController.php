<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest) 
    {
        if (!Auth::attempt($loginRequest->validated())) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Credentials.'
            ]);
        }

        $user = User::where('email', $loginRequest['email'])->first();

        $token = $token = $user->createToken($user->username)->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged in.',
            'token' => $token,
        ]);
    }
}
