<?php
namespace App\Services\Services\Auth;
use App\Models\{Admin,User};
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class MultiAuthService {
    public function login($credentials, $type = null) {
        $guard = $type === 'admin' ? 'admin-api' : 'user-api';
        if ($token = Auth::guard($guard)->attempt($credentials)) {
            return [
                'token' => $token,
                'user' => Auth::guard($guard)->user(),
            ];
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
