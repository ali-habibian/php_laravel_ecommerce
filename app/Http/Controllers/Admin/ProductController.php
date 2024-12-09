<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Tag;
use App\Services\UploadService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        // Inject the UploadService into the controller
        $this->uploadService = $uploadService;
    }

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
            'attribute_ids.*' => 'required|string',
            'variation_values' => 'required|array',
            'variation_values.*.*' => 'required',
            'variation_values.value.*' => 'string',
            'variation_values.price.*' => 'integer|min:0',
            'variation_values.quantity.*' => 'integer|min:0',
            'variation_values.sku.*' => 'integer',
            'delivery_amount' => 'nullable|integer|min:0',
            'delivery_amount_per_product' => 'nullable|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $primaryImageFile = $request->file('primary_image');
            $imageFiles = $request->file('images');

            $primaryImageUploadedPath = $this->uploadService->uploadFile($primaryImageFile, config('uploads.product_images_path'), 'img_');
            $imagesUploadedPaths = $this->uploadService->uploadFiles($imageFiles, config('uploads.product_images_path'), 'img_');

            $product = Product::create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'primary_image' => $primaryImageUploadedPath,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product
            ]);

            foreach ($imagesUploadedPaths as $imageUploadedPath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageUploadedPath
                ]);
            }

            foreach ($request->attribute_ids as $key => $value) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $key,
                    'value' => $value,
                ]);
            }

            $counter = count($request->variation_values['value']);
            $category = Category::findOrFail($request->category_id);
            $variationAttributeId = $category->attributeList()->where('is_variation', true)->first()->id;

            for ($i = 0; $i < $counter; $i++) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'attribute_id' => $variationAttributeId,
                    'value' => $request->variation_values['value'][$i],
                    'price' => $request->variation_values['price'][$i],
                    'quantity' => $request->variation_values['quantity'][$i],
                    'sku' => $request->variation_values['sku'][$i]
                ]);
            }

            $product->tags()->sync($request->tag_ids);

            DB::commit();
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'مشکلی در ایجاد محصول رخ داده است');
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        echo $product->brand->name . '<br>';
        echo $product->category->name . '<br>';
        echo $product->productImages;
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
