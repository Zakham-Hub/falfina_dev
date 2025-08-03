<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\Auth;
use App\Services\AuthService;

class AuthController extends Controller
{
    use ApiTrait;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);
        $response = $this->authService->login($credentials, 'admin');

        if (isset($response['error'])) {
            return $this->errorResponse('Invalid email or password', 401);
        }

        $user = auth('admin-api')->user();
        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        $user->load('profile');
        $resource = new Auth\AdminResource($user);
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);

        return $this->successResponse([
            'token' => $response['token'],
            'refresh_token' => $refreshToken,
            'user' => $resource
        ], 'Login successful');
    }

    public function managerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:managers,email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);
        $response = $this->authService->login($credentials, 'manager');

        if (isset($response['error'])) {
            return $this->errorResponse('Invalid email or password', 401);
        }

        $user = auth('manager-api')->user();
        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        // $user->load('profile');
        $resource = new Auth\ManagerResource($user);
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);

        return $this->successResponse([
            'token' => $response['token'],
            'refresh_token' => $refreshToken,
            'user' => $resource
        ], 'Login successful');
    }
}
