<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use SoftDeletes;

    protected $table = 'product_variations';
    protected $guarded = [];
    protected $appends = ['is_sale'];

    /**
     * Determine if the product variation is on sale.
     *
     * This method checks if the product variation has a sale price and if the current date
     * falls between the sale start and end dates.
     *
     * @return bool Returns true if the product variation is on sale, false otherwise.
     */
    public function getIsSaleAttribute(): bool
    {
        return ($this->sale_price !== null && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now());
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
