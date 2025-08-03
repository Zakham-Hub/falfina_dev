<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials, string $guard)
    {
        if (!Auth::guard($guard.'-api')->attempt($credentials)) {
            return ['error' => true];
        }

        $user = Auth::guard($guard.'-api')->user();
        $token = JWTAuth::fromUser($user);

        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
