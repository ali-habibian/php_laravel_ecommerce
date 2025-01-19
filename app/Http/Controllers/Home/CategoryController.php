<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        // TODO $attributes and $variation are not only for this category. their relation should be fixed
        $attributes = $category->attributeList()->where('is_filterable', true)->with('values')->get();
        $variation = $category->attributeList()->where('is_variation', true)->with('variationValues')->first();


        // TODO number for pagination should be dynamic
        $products = $category->products()->filter()->search()->paginate(3);

        return view('home.categories.show', compact('category', 'attributes', 'variation', 'products'));
    }
}
