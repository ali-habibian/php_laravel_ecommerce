<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $guarded = [];

    /**
     * Get Type Attribute
     *
     * This function converts a given type code into its corresponding Persian description.
     * It is primarily used to translate type codes (e.g., 'fixed') into their Persian equivalents ('مبلغی').
     * If the type code is not 'fixed', it defaults to returning 'درصدی'.
     *
     * @param string $type The type code.
     * @return string The corresponding Persian description, 'مبلغی' for fixed fee and 'درصدی' for percentage fee.
     */
    function getTypeAttribute(string $type): string
    {
        return $type == 'fixed' ? 'مبلغی' : 'درصدی';
    }
}
