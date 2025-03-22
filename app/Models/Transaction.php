<?php

namespace App\Models;

use App\Constants\PaymentTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = [];

    public function getGateWayNameAttribute(string $gateway_name): string
    {
        return match ($gateway_name) {
            PaymentTypes::ZARINPAL->value => 'زرین پال',
            PaymentTypes::PAY->value => 'پی',
            default => 'نامشخص',
        };
    }

    public function getStatusAttribute(bool $status): string
    {
        return $status ? 'موفق' : 'ناموفق';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
