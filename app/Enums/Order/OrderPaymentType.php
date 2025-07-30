<?php

namespace App\Enums\Order;

enum OrderPaymentType: string {
    case PAYMENT = 'payment';
    case LOYALITY_POINT = 'loyality_point';
    case LOYALITY_POINT_WITH_PAYMENT = 'loyalty_point_with_payment';
    case CASH_ON_HAND = 'cash on hand';
    case TABBY = 'tabby';
    case MYFATOORAH = 'myfatoorah';

    public function label(): string {
        return match ($this) {
            self::PAYMENT => 'بوابه الدفع',
            self::LOYALITY_POINT => 'نقاط الولاء',
            self::LOYALITY_POINT_WITH_PAYMENT => 'نقاط الولاء مع بوابه الدفع',
            self::CASH_ON_HAND => 'دفع عند الاستلام',
            self::TABBY => 'تابى',
            self::MYFATOORAH => 'MYFATOORAH',
            
        };
    }

    public function badgeColor(): string {
        return match ($this) {
            self::PAYMENT => 'success',
            self::LOYALITY_POINT => 'danger',
            self::LOYALITY_POINT_WITH_PAYMENT => 'info',
            self::CASH_ON_HAND => 'warning',
            self::TABBY => 'primary',
            self::MYFATOORAH => 'primary',
        };
    }
}
