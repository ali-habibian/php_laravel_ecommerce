<?php

namespace App\Constants;

enum PaymentMethods: string
{
    case POS = 'pos';
    case CASH = 'cash';
    case SHABA_NUMBER = 'shabaNumber';
    case CARD_TO_CARD = 'cardToCard';
    case ONLINE = 'online';

    public static function getPaymentMethodsValues(): array
    {
        return array_column(self::cases(), 'value');
    }

}
