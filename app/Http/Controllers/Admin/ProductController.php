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
use Illuminate\Http\RedirectResponse;
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
        $products = Product::with('brand', 'category', 'tags', 'productAttributes', 'productVariations')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
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
     * Store a newly created product in storage.
     *
     * @param Request $request The request instance containing user input data.
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data according to specified rules.
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

        // Start a database transaction to ensure data integrity.
        try {
            DB::beginTransaction();

            // Handle primary image and additional images upload.
            $primaryImageFile = $request->file('primary_image');
            $imageFiles = $request->file('images');

            $primaryImageUploadedPath = $this->uploadService->uploadFile($primaryImageFile, config('uploads.product_images_path'), 'img_');
            $imagesUploadedPaths = $this->uploadService->uploadFiles($imageFiles, config('uploads.product_images_path'), 'img_');

            // Create a new product instance and save it to the database.
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

            // Create entries for additional images associated with the product.
            foreach ($imagesUploadedPaths as $imageUploadedPath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageUploadedPath
                ]);
            }

            // Create product attributes.
            foreach ($request->attribute_ids as $key => $value) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $key,
                    'value' => $value,
                ]);
            }

            // Create product variations.
            $counter = count($request->variation_values['value']);
            $category = Category::with('attributeList')->findOrFail($request->category_id);
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

            // Sync the tags associated with the product.
            $product->tags()->sync($request->tag_ids);

            // Commit the database transaction.
            DB::commit();
        } catch (Exception $e) {
            // Rollback the transaction if an exception occurs and log the error.
            DB::rollBack();
            Log::error('Error creating product: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
            return redirect()->back()->with('error', 'مشکلی در ایجاد محصول رخ داده است. لطفاً دوباره سعی کنید.');
        }

        // Redirect to the product index page with a success message.
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
