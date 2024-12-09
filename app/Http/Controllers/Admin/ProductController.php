<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::whereNotNull('parent_id')->get();

        return view('admin.products.create', compact('brands', 'tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|integer|exists:brands,id',
            'is_active' => 'required|boolean',
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'required|integer|exists:tags,id',
            'description' => 'required|string',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'category_id' => 'required|integer|exists:categories,id',
            'attribute_ids' => 'required|array',
            'attribute_ids.*' => 'required|integer|exists:attributes,id',
            'variation_values' => 'required|array',
            'variation_values.*.*' => 'required',
            'variation_values.value.*' => 'string',
            'variation_values.price.*' => 'integer|min:0',
            'variation_values.quantity.*' => 'integer|min:0',
            'variation_values.sku.*' => 'integer',
            'delivery_amount' => 'nullable|integer|min:0',
            'delivery_amount_per_product' => 'nullable|integer|min:0'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
