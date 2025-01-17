<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // TODO $attributes and $variation are not only for this category. their relation should be fixed
        $attributes = $category->attributeList()->where('is_filterable', true)->with('values')->get();
        $variation = $category->attributeList()->where('is_variation', true)->with('variationValues')->first();

        return view('home.categories.show', compact('category', 'attributes', 'variation'));
    }
}
