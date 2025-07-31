<?php
namespace App\Services\Services\Auth;
use App\Models\{Admin,User};
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class MultiAuthService {
    public function login($credentials, $type = null) {
        $guard = $type === 'admin' ? 'admin-api' : 'user-api';

        // If using phone for authentication
        if (isset($credentials['phone'])) {
            $model = $type === 'admin' ? Admin::class : User::class;
            $user = $model::where('phone', $credentials['phone'])->first();

            if ($user) {
                // Attempt authentication with the found user's email
                $authCredentials = [
                    'phone' => $credentials['phone'],
                    'password' => $credentials['password']
                ];

                if ($token = Auth::guard($guard)->attempt($authCredentials)) {
                    return [
                        'token' => $token,
                        'user' => Auth::guard($guard)->user(),
                    ];
                }
            }

            return ['error' => 'Unauthorized'];
        }

        // Fall back to default email authentication if no phone provided
        if ($token = Auth::guard($guard)->attempt($credentials)) {
            return [
                'token' => $token,
                'user' => Auth::guard($guard)->user(),
            ];
        }

        return ['error' => 'Unauthorized'];
    }
}
