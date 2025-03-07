<?php

namespace App\Models;

use App\Constants\PaymentMethods;
use App\Constants\PaymentTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];

    public function getStatusAttribute($status): string
    {
        switch ($status) {
            case 0:
                $status = 'در انتظار پرداخت';
                break;
            case 1:
                $status = 'پرداخت شده';
                break;
        }

        return $status;
    }

    public function getPaymentStatusAttribute($payment_status): string
    {
        switch ($payment_status) {
            case 0:
                $payment_status = 'پرداخت ناموفق';
                break;
            case 1:
                $payment_status = 'پرداخت شده';
                break;
        }

        return $payment_status;
    }

    public function getPaymentMethodAttribute($payment_method): string
    {
        switch ($payment_method) {
            case PaymentMethods::POS->value:
                $payment_method = 'دستگاه پوز';
                break;
            case PaymentMethods::ONLINE->value:
                $payment_method = 'آنلاین';
                break;
            case PaymentMethods::CASH->value:
                $payment_method = 'نقدی';
                break;
            case PaymentMethods::CARD_TO_CARD->value:
                $payment_method = 'کارت به کارت';
                break;
            case PaymentMethods::SHABA_NUMBER->value:
                $payment_method = 'شبا';
                break;
        }

        return $payment_method;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
