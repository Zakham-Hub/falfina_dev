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
use App\Models\UserOtp;

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
    public function registerVerifyOtp(Request $request)
    {
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'otp_code.required' => 'رمز التحقق مطلوب.',
            'token.digits' => 'رمز التحقق يجب أن يكون 6 أرقام.',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone',
            'otp_code' => 'required|string|digits:6'
        ], $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // Find user by phone
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->errorResponse('رقم الهاتف غير صحيح', 401);
        }

        // Verify OTP code
        $userOtp = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->orderByDesc('created_at')
            ->first();

        if (!$userOtp) {
            return $this->errorResponse('رمز التحقق غير صحيح', 401);
        }

        if ($userOtp->created_at->lt(now()->subMinutes(5))) {
            // Delete OTP and user if expired
            $userOtp->delete();
            $user->delete();
            return $this->errorResponse('انتهت صلاحية رمز التحقق. يرجى التسجيل مرة أخرى.', 410);
        }

        // Mark OTP as verified
        $userOtp->is_verified = true;
        $userOtp->save();

        // Generate new JWT token
        $token = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser($user);
        return $this->successResponse([
            'user_id' => $user->id,
            'phone' => $this->maskPhoneNumber($user->phone),
            'token' => $token,
            'refresh_token' => $refreshToken,
            'verified' => true
        ], 'تم التحقق من رقم الهاتف بنجاح');
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
