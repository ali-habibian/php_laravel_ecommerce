<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $guarded = [];

/**
 * Establishes a many-to-many relationship with the Category model.
 *
 * This method defines that the current model (e.g., Attribute) can belong to multiple categories,
 * and each category can contain multiple instances of the current model.
 * The 'attribute_category' table is used as the pivot table to store the relationship.
 *
 * @return BelongsToMany Returns a BelongsToMany relationship object, which can be used to query, add, or remove associated categories.
 */
public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class, 'attribute_category');
}

}
