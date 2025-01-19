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

    public function scopeFilter($query)
    {
        if (request()->has('attribute')) {
            foreach (request()->attribute as $attribute) {
                $query->whereHas('productAttributes', function ($query) use ($attribute) {
                    foreach (explode('_', $attribute) as $index => $attributeValue) {
                        if ($index == 0) {
                            $query->where('value', $attributeValue);
                        } else {
                            $query->orWhere('value', $attributeValue);
                        }
                    }
                });
            }
        }

        if (request()->has('variation')) {
            $query->whereHas('productVariations', function ($query) {
                foreach (explode('_', request()->variation) as $index => $variationValue) {
                    if ($index == 0) {
                        $query->where('value', $variationValue);
                    } else {
                        $query->orWhere('value', $variationValue);
                    }
                }
            });
        }

        if (request()->has('sortBy')) {
            $sortBy = request()->sortBy;
            switch ($sortBy) {
                case 'maxPrice':
                    $query->orderByDesc(
                        ProductVariation::select('price')
                            ->whereColumn('product_variations.product_id', 'products.id')
                            ->orderBy('sale_price', 'desc')
                            ->limit(1)
                    );
                    break;
                case 'minPrice':
                    $query->orderBy(
                        ProductVariation::select('price')
                            ->whereColumn('product_variations.product_id', 'products.id')
                            ->orderBy('sale_price')
                            ->limit(1)
                    );
                    break;
                case 'rate':
                    $query->orderByDesc(
                        ProductRate::selectRaw('AVG(rate)')
                            ->whereColumn('product_rates.product_id', 'products.id')
                    );
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'mostViewed':
                    // Implement logic for most viewed if needed
                    break;
                case 'mostSold':
                    // Implement logic for most sold if needed
                    break;
                default:
                    break;
            }
        }

        return $query;
    }

    public function scopeSearch($query)
    {
        $keyword = trim(request()->search);

        if (request()->has('search') && $keyword != null){
            // Normalize spaces and split the keyword into individual words
            $keyword = preg_replace('/\s+/', ' ', trim($keyword));

            // Split the keyword into individual words
            $words = explode(' ', $keyword);

            // Add a WHERE clause for each word
            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->where('name', 'like', '%' . $word . '%');
                }
            });
        }

        return $query;
    }
}
