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
        /**
     * Logout the authenticated user (admin or manager) based on token.
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return $this->errorResponse('Token not provided', 400);
        }

        // Try to authenticate as admin
        try {
            $admin = \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->toUser();
            if ($admin && get_class($admin) === 'App\\Models\\Admin') {
                \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->invalidate();
                return $this->successResponse([], 'Admin logged out successfully');
            }
        } catch (\Exception $e) {
            // Ignore and try manager
        }

        // Try to authenticate as manager
        try {
            $manager = \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->toUser();
            if ($manager && get_class($manager) === 'App\\Models\\Manager') {
                \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->invalidate();
                return $this->successResponse([], 'Manager logged out successfully');
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return $this->errorResponse('Invalid token or user not found', 401);
    }

}
