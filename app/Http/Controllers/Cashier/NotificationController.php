<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Services\Cashier\OrderNotificationService;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;
class NotificationController extends Controller
{
    use ApiTrait;

    protected $notificationService;

    public function __construct(OrderNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get notifications for admin
     */
    public function getAdminNotifications(Request $request)
    {
        $admin = auth('admin-api')->user();
        if (!$admin) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $notifications = $this->notificationService->getUnreadNotifications('admin');

        return $this->successResponse([
            'notifications' => NotificationResource::collection($notifications)
        ], 'Notifications retrieved successfully');
    }

    /**
     * Get notifications for manager
     */
    public function getManagerNotifications(Request $request)
    {
        $manager = auth('manager-api')->user();
        if (!$manager) {
            return $this->errorResponse('Unauthorized', 401);
        }

        // Get notifications for the manager's branch
        $notifications = $this->notificationService->getUnreadNotifications('manager', $manager->id);

        return $this->successResponse([
            'notifications' => NotificationResource::collection($notifications)
        ], 'Notifications retrieved successfully');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $user = auth('admin-api')->user() ?? auth('manager-api')->user();
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $success = $this->notificationService->markAsRead($id);

        if (!$success) {
            return $this->errorResponse('Notification not found', 404);
        }

        return $this->successResponse([], 'Notification marked as read');
    }
}
