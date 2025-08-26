<?php

namespace App\Services\Cashier;

use Kreait\Firebase\Factory as FirebaseFactory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\ApnsPayload;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = public_path(
            'firebase/' . env('FIREBASE_CREDENTIALS')
        );

        $this->messaging = (new FirebaseFactory())
            ->withServiceAccount($serviceAccountPath)
            ->createMessaging();
    }

    /**
     * إرسال إشعار إلى جهاز معين عبر FCM Device Token
     *
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @return void
     * @throws \Exception
     */
    public function sendNotification(string $deviceToken, string $title, string $body): void
    {
        // نجهز الـ notification
        $notification = Notification::create($title, $body);

        // إعدادات خاصة بالـ iOS (APNs)
        $apnsConfig = ApnsConfig::new()
            ->withPayload(
                ApnsPayload::new()->withAps([
                    'sound' => 'default', // صوت الإشعار
                ])
            );

        // بناء الرسالة
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withApnsConfig($apnsConfig);

        // إرسال الرسالة
        $this->messaging->send($message);
    }

    public function sendMultipleNotifications(array $deviceTokens, string $title, string $body): void
        {
        foreach ($deviceTokens as $token) {
            try {
                $this->sendNotification($token, $title, $body);
            } catch (\Throwable $e) {
                \Log::error("FCM send error for token {$token}: " . $e->getMessage());
            }
        }
    }
}
