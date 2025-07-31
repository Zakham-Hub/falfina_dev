<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\WhatsAppOtpService;
use App\Models\UserOtp;

class PasswordResetController extends Controller
{
    public function __construct(protected WhatsAppOtpService $otpService)
    {
    $this->otpService = $otpService;
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        $otpResponse = $this->otpService->sendOtp($user);

        if (!$otpResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset code',
                'errors' => $otpResponse['message'] ?? null
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reset code has been sent to your WhatsApp'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'otp_code' => 'required',
            'password' => 'required|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        // Find the latest non-expired OTP for this user
        $userOtp = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$userOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP code'
            ], 400);
        }

        // Mark OTP as verified
        $userOtp->update([
            'is_verified' => true,
            'verified_at' => now()
        ]);

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ], 200);
    }
}
