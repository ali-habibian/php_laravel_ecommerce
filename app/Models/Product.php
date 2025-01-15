<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use Sluggable;

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['quantity_check', 'sale_check', 'min_price'];

    /**
     * Get the string representation of the active status.
     *
     * This method converts a boolean value representing the active status into a human-readable string.
     * It returns 'فعال' if the status is true, otherwise it returns 'غیرفعال'.
     *
     * @param bool $is_active The boolean value of the active status.
     * @return string The string representation of the active status.
     */
    public function getIsActiveAttribute(bool $is_active): string
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }

    public function getQuantityCheckAttribute()
    {
        return $this->productVariations()->where('quantity', '>', 0)->first() ?? false;
    }

    public function getSaleCheckAttribute()
    {
        return $this->productVariations()
            ->where('quantity', '>', 0)
            ->where('sale_price', '!=', null)
            ->where('date_on_sale_from', '<=', Carbon::now())
            ->where('date_on_sale_to', '>', Carbon::now())
            ->orderBy('sale_price')
            ->first() ?? false;
    }

    public function getMinPriceAttribute()
    {
        return $this->productVariations()
            ->orderBy('price')
            ->first() ?? false;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function productVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productRates(): HasMany
    {
        return $this->hasMany(ProductRate::class);
    }
}
