<?php

namespace App\Enums\Order;

enum OrderStatus: string {
    case PENDING = 'pending';
    case PREPARING = 'preparing';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case DELIVERED = 'delivered';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'قيد الانتظار',
            self::PREPARING => 'جاري التجهيز',
            self::COMPLETED => 'تم التجهيز',
            self::CANCELED => 'تم الإلغاء',
            self::DELIVERED => 'تم التسليم',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PREPARING => 'primary',
            self::COMPLETED => 'success',
            self::CANCELED => 'danger',
            self::DELIVERED => 'info',
        };
    }
}
