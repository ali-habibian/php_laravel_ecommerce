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
use App\Services\FileService;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        // Inject the FileService into the controller
        $this->fileService = $fileService;
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

            $primaryImageUploadedPath = $this->fileService->uploadFile($primaryImageFile, config('uploads.product_images_path'), 'img_');
            $imagesUploadedPaths = $this->fileService->uploadFiles($imageFiles, config('uploads.product_images_path'), 'img_');

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
     * Edit product images
     *
     * This function receives a Product object as a parameter and returns a view for editing the product's images.
     * It is primarily used in the admin backend to provide an interface for users to upload, delete, or modify images related to the product.
     *
     * @param Product $product The product object whose images are to be edited
     * @return View Returns the view for editing product images
     */
    public function editProductImages(Product $product)
    {
        return view('admin.products.edit-images', compact('product'));
    }

    /**
     * Delete a product image
     *
     * This function is used to delete a specific image from a product. The image in question must be associated with the product passed via the $product parameter.
     *
     * @param Request $request HTTP request containing image_id
     * @param Product $product The product to which the image to be deleted is associated
     * @return RedirectResponse
     */
    public function destroyProductImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);

        if ($productImage->product_id === $product->id) {
            $productImage->delete();
            $result = $this->fileService->deleteFile($productImage->image);

            if ($result) {
                return redirect()->back()->with('success', 'تصویر با موفقیت حذف شد');
            } else {
                return redirect()->back()->with('error', 'مشکلی در حذف تصویر رخ داده است');
            }
        }

        return redirect()->back()->with('error', 'تصویر متعلق به این محصول نیست');
    }

    /**
     * Set one of product other image as new primary image for a product.
     *
     * This method sets a specified image as the primary image for a given product. It first validates the request to ensure
     * that the provided image ID exists in the database and belongs to the specified product. If validation passes, it attempts
     * to delete the current primary image, updates the product's primary image, and deletes the selected image from the database.
     * The changes are committed to the database within a transaction to ensure data integrity.
     *
     * @param Request $request The HTTP request object containing the image ID.
     * @param Product $product The product object for which the primary image is being set.
     * @return RedirectResponse Redirects back with a success or error message.
     */
    public function setAsProductPrimaryImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);

        if ($productImage->product_id === $product->id) {
            try {
                DB::beginTransaction();
                $result = $this->fileService->deleteFile($product->primary_image);

                if (!$result) {
                    throw new Exception('delete failed');
                }

                $product->update(['primary_image' => $productImage->image]);
                $productImage->delete();

                DB::commit();
                return redirect()->back()->with('success', 'تصویر اصلی با موفقیت تغییر کرد');
            } catch (Exception $e) {
                DB::rollBack();
                if ($e->getMessage() === 'delete failed') {
                    return redirect()->back()->with('error', 'مشکلی در حذف تصویر اصلی رخ داده است');
                }
            }
        }

        return redirect()->back()->with('error', 'تصویر متعلق به این محصول نیست');
    }

    /**
     * Add new images to a product.
     *
     * This method handles the addition of new images to a specified product. It validates the incoming request,
     * checks if any files have been uploaded, and processes both primary and additional images accordingly.
     * If there are no files uploaded, it returns an error message. If there are issues during the upload or handling
     * of images, it also returns an appropriate error message. On successful completion, it redirects back with a success message.
     *
     * @param Request $request The HTTP request object containing the uploaded images.
     * @param Product $product The product object to which the images are being added.
     * @return RedirectResponse Redirects back with a success or error message.
     */
    public function addNewProductImages(Request $request, Product $product)
    {
        $this->validateNewProductImagesRequest($request);

        // Check if any files have been uploaded
        if (!$request->hasFile('primary_image') && !$request->hasFile('images')) {
            return redirect()->back()->with('error', 'تصویری انتخاب نکرده اید.');
        }

        // Handle the primary image if it has been uploaded
        if ($request->hasFile('primary_image')) {
            $primaryImageFile = $request->file('primary_image');
            if (!$this->handlePrimaryImage($primaryImageFile, $product)) {
                return redirect()->back()->with('error', 'مشکلی در آپلود یا حذف تصویر اصلی رخ داده است، لطفا دوباره سعی کنید.');
            }
        }

        // Handle additional images if they have been uploaded
        if ($request->hasFile('images')) {
            $imageFiles = $request->file('images');
            if (!$this->handleAdditionalImages($imageFiles, $product)) {
                return redirect()->back()->with('error', 'مشکلی در آپلود تصاویر رخ داده است، لطفا دوباره سعی کنید.');
            }
        }

        return redirect()->back()->with('success', 'تصاویر با موفقیت اضافه شدند.');
    }

    /**
     * Validate the request for new product images.
     *
     * This private method validates the incoming request to ensure that the uploaded images meet the specified criteria.
     * It checks that the primary image, if provided, is a valid image file with specific MIME types and a maximum size.
     * It also validates that any additional images are provided as an array and that each image in the array meets the same criteria.
     *
     * @param Request $request The HTTP request object containing the uploaded images.
     * @return void Throws validation exceptions if the request does not meet the criteria.
     */
    private function validateNewProductImagesRequest(Request $request)
    {
        $request->validate([
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    /**
     * Handle new primary image upload and update for a product.
     *
     * This private method manages the process of uploading a new primary image for a product and updating the product's record.
     * It first attempts to upload the new image using the file service. If the upload is successful, it updates the product's
     * primary image path in the database. After a successful update, it attempts to delete the previous primary image.
     * If any step fails, it returns false; otherwise, it returns true upon successful completion.
     *
     * @param UploadedFile $primaryImageFile The uploaded primary image file.
     * @param Product $product The product object whose primary image is being updated.
     * @return bool Returns true if the primary image is successfully uploaded and updated, false otherwise.
     */
    private function handlePrimaryImage(UploadedFile $primaryImageFile, Product $product)
    {
        $previousPrimaryImagePath = $product->primary_image;
        $primaryImageUploadedPath = $this->fileService->uploadFile($primaryImageFile, config('uploads.product_images_path'), 'img_');

        if ($primaryImageUploadedPath) {
            $isUpdated = $product->update(['primary_image' => $primaryImageUploadedPath]);

            if ($isUpdated) {
                if (!$this->fileService->deleteFile($previousPrimaryImagePath)) {
                    return false; // Failed to delete the previous image
                }
            }
            return true;
        }

        return false; // Failed to upload the new image
    }

    /**
     * Handle the upload and storage of additional images for a product.
     *
     * This private method processes the upload of multiple additional images for a given product.
     * It uses the file service to upload the images and stores their paths in the database.
     * The method ensures that all operations are performed within a database transaction to maintain data integrity.
     * If any step fails, it rolls back the transaction and returns false; otherwise, it commits the transaction and returns true.
     *
     * @param array $imageFiles An array of uploaded image files.
     * @param Product $product The product object for which the images are being uploaded.
     * @return bool Returns true if all images are successfully uploaded and stored, false otherwise.
     */
    private function handleAdditionalImages(array $imageFiles, Product $product)
    {
        $imagesUploadedPaths = $this->fileService->uploadFiles($imageFiles, config('uploads.product_images_path'), 'img_');

        if ($imagesUploadedPaths) {
            try {
                DB::beginTransaction();
                foreach ($imagesUploadedPaths as $imageUploadedPath) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageUploadedPath,
                    ]);
                }
                DB::commit();
                return true;
            } catch (Exception $e) {
                DB::rollBack();
                return false; // Exception occurred during image processing
            }
        }

        return false; // Failed to upload images
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
