<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppOtpService
{
    private string $accessToken;
    private string $phoneNumberId;
    private string $apiVersion;
    private string $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->apiVersion = config('services.whatsapp.api_version', 'v18.0');
        $this->baseUrl = "https://graph.facebook.com/{$this->apiVersion}";
    }

    /**
     * Send OTP via WhatsApp
     */
    public function sendOtp(User $user): array
    {
        try {
            // Clean up old OTPs for this user
            $this->cleanupOldOtps($user);
            // Generate new OTP
            $otpCode = UserOtp::generateOtpCode();
            $expiresAt = Carbon::now()->addMinutes(5); // 5 minutes expiry
            
            // Save OTP to database
            $userOtp = UserOtp::create([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'otp_code' => $otpCode,
                'expires_at' => $expiresAt,
                'attempts' => 0,
                'is_verified' => false
            ]);
            
            // Format phone number (remove + and ensure it starts with country code)
            $phoneNumber = $this->formatPhoneNumber($user->phone);
            
            // Send WhatsApp message
            $response = $this->sendWhatsAppMessage($phoneNumber, $otpCode, $user->first_name);
            
            if ($response['success']) {
                Log::info("OTP sent successfully to {$phoneNumber}", [
                    'user_id' => $user->id,
                    'otp_id' => $userOtp->id
                ]);

                return [
                    'success' => true,
                    'message' => 'تم إرسال رمز التحقق عبر الواتساب',
                    'expires_at' => $expiresAt->toISOString(),
                    'otp_id' => $userOtp->id
                ];
            } else {
                // Delete the OTP if sending failed
                $userOtp->delete();
                
                return [
                    'success' => false,
                    'message' => 'فشل في إرسال رمز التحقق. يرجى المحاولة مرة أخرى.',
                    'error' => $response['error']
                ];
            }

        } catch (Exception $e) {
            Log::error('Failed to send OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء إرسال رمز التحقق',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(User $user, string $otpCode): array
    {
        try {
            // Find active OTP for user
            $userOtp = UserOtp::where('user_id', $user->id)
                             ->active()
                             ->latest()
                             ->first();

            if (!$userOtp) {
                return [
                    'success' => false,
                    'message' => 'لا يوجد رمز تحقق صالح. يرجى طلب رمز جديد.'
                ];
            }

            // Check if OTP is expired
            if ($userOtp->isExpired()) {
                return [
                    'success' => false,
                    'message' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.'
                ];
            }

            // Check attempts limit
            if ($userOtp->attempts >= 3) {
                return [
                    'success' => false,
                    'message' => 'تم تجاوز الحد الأقصى للمحاولات. يرجى طلب رمز جديد.'
                ];
            }

            // Verify OTP code
            if ($userOtp->otp_code !== $otpCode) {
                $userOtp->incrementAttempts();
                
                $remainingAttempts = 3 - $userOtp->attempts;
                return [
                    'success' => false,
                    'message' => "رمز التحقق غير صحيح. المحاولات المتبقية: {$remainingAttempts}"
                ];
            }

            // Mark OTP as verified
            $userOtp->markAsVerified();

            // Mark user phone as verified
            $user->update(['phone_verified_at' => Carbon::now()]);

            Log::info("OTP verified successfully", [
                'user_id' => $user->id,
                'otp_id' => $userOtp->id
            ]);

            return [
                'success' => true,
                'message' => 'تم التحقق من رقم الهاتف بنجاح'
            ];

        } catch (Exception $e) {
            Log::error('Failed to verify OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء التحقق من الرمز',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send WhatsApp message using Meta API
     */
    private function sendWhatsAppMessage(string $phoneNumber, string $otpCode, string $firstName): array
    {
        try {
            $url = "{$this->baseUrl}/{$this->phoneNumberId}/messages";

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'template',
                'template' => [
                    'name' => 'otp_verification', // You need to create this template in Meta Business
                    'language' => [
                        'code' => 'ar' // Arabic
                    ],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $otpCode
                                ]
                            ]
                        ],
                        [
                            'type' => 'button',
                            'sub_type' => 'url',
                            'index' => 0,
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $otpCode // Or replace with another value if your button expects something else
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => 'application/json'
            ])->post($url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'response' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $response->json(),
                    'status' => $response->status()
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number for WhatsApp API
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);
        
        // If phone starts with 01 (Egyptian mobile), add country code
        if (str_starts_with($phone, '01')) {
            $phone = '2' . $phone; // Egypt country code is 20, but API expects 2
        }
        
        // If phone doesn't start with country code, assume Egyptian
        if (!str_starts_with($phone, '2') && strlen($phone) === 11) {
            $phone = '2' . $phone;
        }
        
        return $phone;
    }

    /**
     * Clean up old OTPs for user
     */
    private function cleanupOldOtps(User $user): void
    {
        UserOtp::where('user_id', $user->id)
               ->where('is_verified', false)
               ->delete();
    }

    /**
     * Resend OTP (with rate limiting)
     */
    public function resendOtp(User $user): array
    {
        // Check if user has requested OTP recently (rate limiting)
        $recentOtp = UserOtp::where('user_id', $user->id)
                           ->where('created_at', '>', Carbon::now()->subMinutes(5))
                           ->first();

        if ($recentOtp) {
            return [
                'success' => false,
                'message' => 'يرجى الانتظار خمس دقائق قبل طلب رمز جديد'
            ];
        }

        return $this->sendOtp($user);
    }
}
