<?php

namespace App\Constants;

enum PaymentTypes: string
{
    case PAY = 'pay';
    case ZARINPAL = 'zarinpal';

    public static function getPaymentTypeValues(): array
    {
        return array_column(self::cases(), 'value');
    }

}
