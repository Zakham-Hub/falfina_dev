<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\Auth;
use App\Services\AuthService;
use App\Models\AdminDevice;
use App\Models\ManagerDevice;
use App\Services\Cashier\FirebaseNotificationService;

class AuthController extends Controller
{
    use ApiTrait;

    protected $authService;

    public function __construct(
        AuthService $authService,
        protected FirebaseNotificationService $firebaseService,
    ) {
        $this->authService = $authService;
        $this->firebaseService = $firebaseService;
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:admins,email",
            "password" => "required|string|min:6",
            "fcm_token" => "required|string",
            "device_name" => "nullable|string",
        ]);

        $this->firebaseService->sendNotification(
            $request->fcm_token,
            "تسجيل دخول جديد",
            "تم تسجيل دخول جديد إلى حسابك كمسؤول من جهاز أخر",
        );

        $credentials = $request->only(["email", "password"]);
        $response = $this->authService->login($credentials, "admin");

        if (isset($response["error"])) {
            return $this->errorResponse("Invalid email or password", 401);
        }

        $user = auth("admin-api")->user();
        if (!$user) {
            return $this->notFoundResponse("User not found");
        }

        // Store or update FCM token
        $this->storeAdminDevice(
            $user->id,
            $request->fcm_token,
            $request->device_name ?? "Unknown Device",
        );

        $user->load("profile");
        $resource = new Auth\AdminResource($user);
        $refreshToken = JWTAuth::claims(["refresh" => true])->fromUser($user);

        return $this->successResponse(
            [
                "token" => $response["token"],
                "refresh_token" => $refreshToken,
                "user" => $resource,
            ],
            "Login successful",
        );
    }

    public function managerLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:managers,email",
            "password" => "required|string|min:6",
            "fcm_token" => "required|string",
            "device_name" => "nullable|string",
        ]);

        $credentials = $request->only(["email", "password"]);
        $response = $this->authService->login($credentials, "manager");

        if (isset($response["error"])) {
            return $this->errorResponse("Invalid email or password", 401);
        }

        $user = auth("manager-api")->user();
        if (!$user) {
            return $this->notFoundResponse("User not found");
        }

        // Store or update FCM token
        $this->storeManagerDevice(
            $user->id,
            $request->fcm_token,
            $request->device_name ?? "Unknown Device",
        );

        $resource = new Auth\ManagerResource($user);
        $refreshToken = JWTAuth::claims(["refresh" => true])->fromUser($user);

        return $this->successResponse(
            [
                "token" => $response["token"],
                "refresh_token" => $refreshToken,
                "user" => $resource,
            ],
            "Login successful",
        );
    }

    /**
     * Update FCM token for admin
     */
    public function updateAdminFcmToken(Request $request)
    {
        $request->validate([
            "fcm_token" => "required|string",
            "device_name" => "nullable|string",
        ]);

        $admin = auth("admin-api")->user();
        if (!$admin) {
            return $this->errorResponse("Unauthorized", 401);
        }

        $this->storeAdminDevice(
            $admin->id,
            $request->fcm_token,
            $request->device_name ?? "Unknown Device",
        );

        return $this->successResponse([], "FCM token updated successfully");
    }

    /**
     * Update FCM token for manager
     */
    public function updateManagerFcmToken(Request $request)
    {
        $request->validate([
            "fcm_token" => "required|string",
            "device_name" => "nullable|string",
        ]);

        $manager = auth("manager-api")->user();
        if (!$manager) {
            return $this->errorResponse("Unauthorized", 401);
        }

        $this->storeManagerDevice(
            $manager->id,
            $request->fcm_token,
            $request->device_name ?? "Unknown Device",
        );

        return $this->successResponse([], "FCM token updated successfully");
    }

    /**
     * Store or update admin device FCM token
     */
    private function storeAdminDevice($adminId, $fcmToken, $deviceName)
    {
        AdminDevice::updateOrCreate(
            ["fcm_token" => $fcmToken],
            [
                "admin_id" => $adminId,
                "device_name" => $deviceName,
            ],
        );
    }

    /**
     * Store or update manager device FCM token
     */
    private function storeManagerDevice($managerId, $fcmToken, $deviceName)
    {
        ManagerDevice::updateOrCreate(
            ["fcm_token" => $fcmToken],
            [
                "manager_id" => $managerId,
                "device_name" => $deviceName,
            ],
        );
    }

    /**
     * Logout the authenticated user (admin or manager) based on token.
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $fcmToken = $request->input("fcm_token"); // استقبل الـ fcm_token من الطلب

        if (!$token) {
            return $this->errorResponse("Token not provided", 400);
        }

        if (!$fcmToken) {
            return $this->errorResponse(
                "FCM token is required for logout",
                400,
            );
        }

        try {
            $user = JWTAuth::setToken($token)->toUser();

            if (!$user) {
                return $this->errorResponse("User not found", 404);
            }

            // بناءً على نوع المستخدم احذف الجهاز
            if ($user instanceof \App\Models\Admin) {
                AdminDevice::where("admin_id", $user->id)
                    ->where("fcm_token", $fcmToken)
                    ->delete();
            } elseif ($user instanceof \App\Models\Manager) {
                ManagerDevice::where("manager_id", $user->id)
                    ->where("fcm_token", $fcmToken)
                    ->delete();
            } else {
                return $this->errorResponse("Invalid user type", 401);
            }

            // إبطال توكن JWT
            JWTAuth::setToken($token)->invalidate();

            $userType =
                $user instanceof \App\Models\Admin ? "Admin" : "Manager";
            return $this->successResponse(
                [],
                "$userType logged out successfully",
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                "Invalid token or error during logout",
                401,
            );
        }
    }
}
