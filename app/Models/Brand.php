<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Sluggable;
    protected $table = 'brands';
    protected $guarded = [];


    /**
     * Accessor for the "is_active" attribute.
     *
     * Converts the boolean value of the "is_active" attribute
     * into a human-readable Persian string.
     *
     * @param bool $is_active The boolean value of the "is_active" attribute.
     * @return string Returns 'فعال' if true, otherwise 'غیرفعال'.
     */
    public function getIsActiveAttribute(bool $is_active): string
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }
}
