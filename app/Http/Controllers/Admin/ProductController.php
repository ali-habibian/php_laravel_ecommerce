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
    public function show(Product $product)
    {
        $productAttributes = $product->productAttributes()->with('attribute')->get();
        $productVariations = $product->productVariations()->with('attribute')->get();
        $productImages = $product->productImages;
        $productTags = $product->tags;

        return view('admin.products.show', compact('product', 'productAttributes', 'productVariations', 'productImages', 'productTags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::whereNotNull('parent_id')->get();
        $productAttributes = $product->productAttributes()->with('attribute')->get();
        $productVariations = $product->productVariations()->with('attribute')->get();
        $productTagIds = $product->tags()->pluck('id')->toArray();

        return view('admin.products.edit', compact(
            'product',
            'brands',
            'tags',
            'categories',
            'productAttributes',
            'productVariations',
            'productTagIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data according to specified rules.
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|integer|exists:brands,id',
            'is_active' => 'required|boolean',
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'required|integer|exists:tags,id',
            'description' => 'required|string',
            'attribute_values' => 'required|array',
            'attribute_values.*' => 'required|string',
            'variation_values' => 'required|array',
            'variation_values.*' => 'required',
            'variation_values.*.price' => 'required|integer|min:0',
            'variation_values.*.quantity' => 'required|integer|min:0',
            'variation_values.*.sku' => 'nullable|string',
            'variation_values.*.sale_price' => 'nullable|integer|min:0',
            'variation_values.*.date_on_sale_from' => 'nullable|date',
            'variation_values.*.date_on_sale_to' => 'nullable|date',
            'delivery_amount' => 'nullable|integer|min:0',
            'delivery_amount_per_product' => 'nullable|integer|min:0'
        ]);

        // Start a database transaction to ensure data integrity.
        try {
            DB::beginTransaction();

            // Update the product and save it to the database.
            $product->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product
            ]);

            // Update product attributes.
            $this->updateProductAttributes($request->attribute_values);

            // Update product variations.
            $result = $this->updateProductVariations($request->variation_values);
            if (!$result) {
                throw new Exception(code: 700);
            }

            // Sync the tags associated with the product.
            $product->tags()->sync($request->tag_ids);

            // Commit the database transaction.
            DB::commit();
        } catch (Exception $e) {
            // Rollback the transaction if an exception occurs and log the error.
            DB::rollBack();
            Log::error('Error creating product: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
            if ($e->getCode() === 700) {
                return redirect()->back()->with('error', 'تاریخ شروع و پایان باید هر دو پر شوند یا هر دو خالی باشند.');
            }
            return redirect()->back()->with('error', 'مشکلی در ایجاد محصول رخ داده است. لطفاً دوباره سعی کنید.');
        }

        // Redirect to the product index page with a success message.
        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ایجاد شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update product attributes.
     *
     * This method receives an array of attribute IDs and their corresponding values,
     * iterates over the array, and updates the value of each product attribute in the database.
     * If a product attribute with the given ID is not found, it throws a ModelNotFoundException.
     *
     * @param array $attributeIds An associative array where keys are attribute IDs and values are the new attribute values.
     */
    private function updateProductAttributes(array $attributeIds)
    {
        foreach ($attributeIds as $key => $value) {
            $productAttribute = ProductAttribute::findOrFail($key);

            $productAttribute->update([
                'value' => $value
            ]);
        }
    }


    /**
     * Update product variations
     *
     * This method updates the price, quantity, SKU, sale price, and sale dates for product variations.
     * It accepts an array of variation information, iterates over each variation, and updates its details.
     * If either the sale start date or the sale end date is null but not both, it returns false indicating invalid sale date settings.
     * The `convertShamsiToGregorian` function is used to convert the sale start and end dates from Shamsi (Iranian) calendar to Gregorian calendar.
     * Returns true if the update is successful, otherwise may return false.
     *
     * @param array $variationValues Array containing variation information, where keys are variation IDs and values are arrays with detailed information
     * @return bool Boolean indicating whether the update operation was successful
     * @throws Exception Throws an exception if the date parsing fails.
     */
    private function updateProductVariations(array $variationValues)
    {
        // Iterate over each variation
        foreach ($variationValues as $key => $value) {
            // Retrieve the specified product variation
            $productVariation = ProductVariation::findOrFail($key);

            // Check if sale date settings are valid
            if (($value['date_on_sale_from'] !== null && $value['date_on_sale_to'] === null) || ($value['date_on_sale_from'] === null && $value['date_on_sale_to'] !== null)) {
                return false;
            }

            // Convert sale start date from Shamsi to Gregorian
            $shamsiStartDate = convertShamsiToGregorian($value['date_on_sale_from']);
            // Convert sale end date from Shamsi to Gregorian
            $shamsEndDate = convertShamsiToGregorian($value['date_on_sale_to']);

            // Update the product variation details
            $productVariation->update([
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'sku' => $value['sku'],
                'sale_price' => $value['sale_price'],
                'date_on_sale_from' => $shamsiStartDate,
                'date_on_sale_to' => $shamsEndDate
            ]);
        }

        // Return true if all updates were successful
        return true;
    }

}
