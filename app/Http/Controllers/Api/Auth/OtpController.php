<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppOtpService;
use App\Traits\ApiTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class OtpController extends Controller
{
    use ApiTrait;

    protected WhatsAppOtpService $otpService;

    public function __construct(WhatsAppOtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP to user's phone via WhatsApp
     */
    public function sendOtp(Request $request)
    {
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.exists' => 'رقم الهاتف غير مسجل في النظام.',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone'
        ], $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->notFoundResponse('المستخدم غير موجود');
        }

        $result = $this->otpService->sendOtp($user);

        if ($result['success']) {
            return $this->successResponse([
                'expires_at' => $result['expires_at'],
                'phone' => $this->maskPhoneNumber($user->phone)
            ], $result['message']);
        }

        return $this->errorResponse($result['message'], 400);
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.exists' => 'رقم الهاتف غير مسجل في النظام.',
            'otp_code.required' => 'رمز التحقق مطلوب.',
            'otp_code.string' => 'رمز التحقق يجب أن يكون نصًا.',
            'otp_code.size' => 'رمز التحقق يجب أن يكون 6 أرقام.',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone',
            'otp_code' => 'required|string|size:6'
        ], $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->notFoundResponse('المستخدم غير موجود');
        }

        $result = $this->otpService->verifyOtp($user, $request->otp_code);

        if ($result['success']) {
            // Generate JWT token after successful verification
            $token = JWTAuth::fromUser($user);
            $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);
            
            $user->load('profile');

            return $this->successResponse([
                'token' => $token,
                'refresh_token' => $refreshToken,
                'user' => new \App\Http\Resources\Auth\UserResource($user),
                'phone_verified' => true
            ], $result['message']);
        }

        return $this->errorResponse($result['message'], 400);
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.exists' => 'رقم الهاتف غير مسجل في النظام.',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone'
        ], $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->notFoundResponse('المستخدم غير موجود');
        }

        $result = $this->otpService->resendOtp($user);

        if ($result['success']) {
            return $this->successResponse([
                'expires_at' => $result['expires_at'],
                'phone' => $this->maskPhoneNumber($user->phone)
            ], $result['message']);
        }

        return $this->errorResponse($result['message'], 400);
    }

    /**
     * Login with phone and password, then send OTP
     */
    public function loginWithOtp(Request $request)
    {
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string'
        ], $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // Find user by phone
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->errorResponse('رقم الهاتف أو كلمة المرور غير صحيحة', 401);
        }

        // Verify password
        if (!\Hash::check($request->password, $user->password)) {
            return $this->errorResponse('رقم الهاتف أو كلمة المرور غير صحيحة', 401);
        }

        // Send OTP for verification
        $result = $this->otpService->sendOtp($user);

        if ($result['success']) {
            return $this->successResponse([
                'user_id' => $user->id,
                'phone' => $this->maskPhoneNumber($user->phone),
                'expires_at' => $result['expires_at'],
                'requires_otp' => true
            ], 'تم إرسال رمز التحقق. يرجى إدخال الرمز للمتابعة.');
        }

        return $this->errorResponse($result['message'], 400);
    }

    /**
     * Mask phone number for security
     */
    private function maskPhoneNumber(string $phone): string
    {
        if (strlen($phone) > 4) {
            return substr($phone, 0, 3) . str_repeat('*', strlen($phone) - 6) . substr($phone, -3);
        }
        return $phone;
    }
}
