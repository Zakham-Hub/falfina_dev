<?php

namespace App\Enums\Order;

enum OrderPaymentType: string {
    case PAYMENT = 'payment';
    case LOYALITY_POINT = 'loyality_point';
    case LOYALITY_POINT_WITH_PAYMENT = 'loyalty_point_with_payment';

    public function label(): string {
        return match ($this) {
            self::PAYMENT => 'بوابه الدفع',
            self::LOYALITY_POINT => 'نقاط الولاء',
            self::LOYALITY_POINT_WITH_PAYMENT => 'نقاط الولاء مع بوابه الدفع',
        };
    }

    public function badgeColor(): string {
        return match ($this) {
            self::PAYMENT => 'success',
            self::LOYALITY_POINT => 'danger',
            self::LOYALITY_POINT_WITH_PAYMENT => 'info',
        };
    }
}
