<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\Cashier\OrderNotificationService;


class OrderObserver
{
    public function __construct(protected OrderNotificationService $orderNotificationService) {}

    public function created(Order $order)
    {
        $this->orderNotificationService->sendNewOrderNotifications($order);
    }
    public function updated(Order $order): void {}
    public function deleted(Order $order): void {}
    public function restored(Order $order): void {}
    public function forceDeleted(Order $order): void {}
}
