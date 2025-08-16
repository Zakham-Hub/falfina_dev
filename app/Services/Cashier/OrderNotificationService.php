<?php

namespace App\Services\Cashier;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Manager;
use App\Models\AdminDevice;
use App\Models\ManagerDevice;
use App\Models\CashierNotification;
use Illuminate\Support\Facades\Log;
use App\Services\Cashier\FirebaseNotificationService;

class OrderNotificationService
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Send notifications for new order to all admins and branch managers
     *
     * @param Order $order
     * @return void
     */
    public function sendNewOrderNotifications(Order $order): void
    {
        try {
            // Send notification to all admins
             $this->notifyAdmins($order);

            // Send notification to branch managers
             $this->notifyBranchManagers($order);

            // Store notification in database
             $this->storeNotification($order);

        } catch (\Exception $e) {
            Log::error('Failed to send order notifications: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification to all admin devices
     */
    private function notifyAdmins(Order $order): void
    {
        $tokens = AdminDevice::pluck('fcm_token')->filter()->unique()->toArray();

        if (!empty($tokens)) {
            $this->firebaseService->sendMultipleNotifications(
                $tokens,
                'طلب جديد',
                "تم إنشاء طلب جديد برقم #{$order->order_number}"
            );
        }
    }

    /**
     * Send notification to branch managers
     */
    private function notifyBranchManagers(Order $order): void
    {
        if (!$order->branch_id) {
            return;
        }

        $tokens = ManagerDevice::whereHas('manager', function ($query) use ($order) {
            $query->where('branch_id', $order->branch_id);
        })
            ->pluck('fcm_token')
            ->filter()
            ->unique()
            ->toArray();

        if (!empty($tokens)) {
            $this->firebaseService->sendMultipleNotifications(
                $tokens,
                'طلب جديد في الفرع',
                "تم إنشاء طلب جديد برقم #{$order->order_number} في فرعك"
            );
        }
    }
    /**
     * Store notification in database
     */
    private function storeNotification(Order $order): void
    {
        // Store for admins
        $admins = Admin::get()->unique('id');

        foreach ($admins as $admin) {
            $exists = CashierNotification::where('type', 'admin')
                ->where('notifiable_type', Admin::class)
                ->where('notifiable_id', $admin->id)
                ->where('data->order_id', $order->id) // التحقق من وجود نفس الطلب
                ->exists();

            if (!$exists) {
                CashierNotification::create([
                    'type'            => 'admin',
                    'notifiable_type' => Admin::class,
                    'notifiable_id'   => $admin->id,
                    'data'            => [
                        'order_id'     => $order->id,
                        'order_number' => $order->order_number,
                        'title'        => 'تم إنشاء طلب جديد',
                        'body'         => "رقم الطلب الجديد: {$order->order_number}",
                    ]
                ]);
            }
        }

        // Store for branch managers if branch exists
        $managers = $order?->branch?->managers()->get()->unique('id') ?? collect();

        foreach ($managers as $manager) {
            $exists = CashierNotification::where('type', 'manager')
                ->where('notifiable_type', Manager::class)
                ->where('notifiable_id', $manager->id)
                ->where('data->order_id', $order->id) // التحقق من وجود نفس الطلب
                ->exists();

            if (!$exists) {
                CashierNotification::create([
                    'type'            => 'manager',
                    'notifiable_type' => Manager::class,
                    'notifiable_id'   => $manager->id,
                    'data'            => [
                        'order_id'     => $order->id,
                        'order_number' => $order->order_number,
                        'title'        => 'تم إنشاء طلب جديد',
                        'body'         => "رقم الطلب الجديد: {$order->order_number}",
                    ]
                ]);
            }
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(string $notificationId): bool
    {
        $notification = CashierNotification::find($notificationId);

        if (!$notification) {
            return false;
        }

        $notification->update(attributes: ['read_at' => now()]);
        return true;
    }

    /**
     * Get unread notifications for user type
     */
    public function getUnreadNotifications(string $userType, $userId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = CashierNotification::where('type', 'like', "%{$userType}%")
            ->whereNull('read_at');

        if ($userId) {
            $query->where('notifiable_id', $userId);
        }

        return $query->orderBy('created_at', 'desc')->orderByDesc('id')->take(5)->get();
    }
}
