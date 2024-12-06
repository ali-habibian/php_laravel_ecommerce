<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use DB;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        $attributes = Attribute::all();
        return view('admin.categories.create', compact('parentCategories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'required|boolean',
            'attribute_ids' => 'array|required',
            'attribute_ids.*' => 'exists:attributes,id',
            'attribute_is_filter_ids' => 'nullable|array',
            'attribute_is_filter_ids.*' => 'exists:attributes,id',
            'variation_id' => 'nullable|exists:attributes,id',
            'icon' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $category = Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'is_active' => $request->is_active,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            foreach ($request->attribute_ids as $attributeId) {
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id, [
                    'is_filterable' => in_array($attributeId, $request->attribute_is_filter_ids ?? []),
                    'is_variation' => $attributeId === $request->variation_id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            report($e);

            DB::rollBack();

            return redirect()->back()->with('error', 'مشکلی در ایجاد دسته بندی به وجود آمده است');
        }

        return redirect()->route('admin.categories.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
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
