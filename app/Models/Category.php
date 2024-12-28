<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Sluggable;

    protected $table = 'categories';
    protected $guarded = [];

    /**
     * Returns the configuration for generating slugs in the model.
     *
     * This method defines which field(s) in the model can be used to generate slugs.
     * In this case, it specifies that the 'slug' field should be generated based on the 'name' field.
     *
     * @return array An array containing the slug configuration, with the key as the slug field name and the value as the source field name.
     */
    public function sluggable(): array
    {
        // Configure slug generation, specifying that the 'slug' field is based on the 'name' field.
        return [
            'slug' => ['source' => 'name']
        ];
    }


    /**
     * Get the string representation of the active status.
     *
     * This method converts a boolean value representing the active status into a human-readable string.
     * It returns 'Active' if the status is true, otherwise it returns 'Inactive'.
     *
     * @param bool $is_active The boolean value indicating the active status
     * @return string The string representation of the active status
     */
    public function getIsActiveAttribute(bool $is_active): string
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }

    /**
     * Get the parent category of the current category.
     *
     * This method defines a belongs-to relationship using Eloquent ORM,
     * associating the current category with its parent category.
     * It uses the belongsTo method to establish an inverse one-to-many relationship.
     *
     * @return BelongsTo Returns a BelongsTo instance representing the relationship between the current model and its parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories associated with this category.
     *
     * This method establishes a relationship with the Category model,
     * indicating that a category can have multiple subcategories.
     * It uses Laravel's Eloquent ORM hasMany method to define a one-to-many relationship.
     *
     * @return HasMany Returns a HasMany object representing all subcategories of this category.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    /**
     * Gets the name of the parent category.
     *
     * This method is used to get the name of the parent category of the current category.
     * It first attempts to retrieve the parent category through the belongsTo relationship with the Category model,
     * using the 'parent_id' foreign key. If the parent category exists, it returns the name of the parent category;
     * otherwise, it returns null.
     */
    public function parentName()
    {
        // Get the parent category relationship
        $parentCategory = $this->belongsTo(Category::class, 'parent_id')->first();

        // Return the name of the parent category if it exists
        return $parentCategory ? $parentCategory->name : null;
    }

    /**
     * Define a many-to-many relationship with the Attribute model.
     *
     * This method establishes a many-to-many relationship between the current model (Category)
     * and the Attribute model. The relationship is managed through an intermediate table named 'attribute_category'.
     *
     * @return BelongsToMany A BelongsToMany relationship object representing the many-to-many relationship.
     */
    public function attributeList(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
