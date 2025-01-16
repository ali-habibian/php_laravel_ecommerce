<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// ---------------- Admin Routs ----------------
Route::prefix('admin-panel/management')->name('admin.')->group(function () {
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);

    // Get category attributes
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes'])->name('category.attributes');

    // ---------------- Edit product images ----------------
    Route::get('/products/{product}/images/edit', [ProductController::class, 'editProductImages'])->name('products.images.edit');
    // Delete product image
    Route::delete('/products/{product}/images/delete', [ProductController::class, 'destroyProductImage'])->name('products.images.destroy');
    // Set one of other images as primary image
    Route::put('/products/{product}/images/set-primary', [ProductController::class, 'setAsProductPrimaryImage'])->name('products.images.set-primary');
    // Add new images to product
    Route::post('/products/{product}/images/add', [ProductController::class, 'addNewProductImages'])->name('products.images.add');

    // ---------------- Edit product category and attributes ----------------
    Route::get('/products/{product}/edit/category-attributes', [ProductController::class, 'editProductCategoryAndAttributes'])->name('products.edit.category-attributes');
    Route::put('/products/{product}/update/category-attributes', [ProductController::class, 'updateProductCategoryAndAttributes'])->name('products.update.category-attributes');
});
// ---------------- End Admin Routs ----------------

// ---------------- Home Routs ----------------
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/product-modal', [HomeController::class, 'showProductModal'])->name('showProductModal');

Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('home.categories.show');
// ---------------- End Home Routs ----------------
