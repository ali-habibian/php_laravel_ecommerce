<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishListController;
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
    Route::resource('comments', CommentController::class);

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

    Route::get('comments/{comment}/change-approval-status', [CommentController::class, 'changeApprovalStatus'])->name('comments.change-approval-status');
});
// ---------------- End Admin Routs ----------------

// ---------------- Home Routs ----------------
Route::prefix('/')->name('home.')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('index');

    Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('categories.show');

    Route::get('/products/{product:slug}', [HomeProductController::class, 'show'])->name('products.show');

    Route::post('/comments/{product}', [HomeCommentController::class, 'store'])->name('comments.store');

    Route::get('/wishlist/toggle/{product}', [WishListController::class, 'toggle'])->name('wishlist.toggle');
});
//Route::get('/product-modal', [HomeController::class, 'showProductModal'])->name('showProductModal');
// ---------------- End Home Routs ----------------

// ---------------- User Profile Routs ----------------
Route::prefix('profile')->name('home.profile.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('index');
    Route::get('/comments', [HomeCommentController::class, 'userCommentsIndex'])->name('comments.index');
    Route::get('/wishlist', [WishListController::class, 'userWishListIndex'])->name('wishlist.index');
    Route::delete('/wishlist/remove/{product}', [WishListController::class, 'removeProductFromUserWishList'])->name('wishlist.remove');
});
// ---------------- End User Profile Routs ----------------

// Social auth routs
Route::get('/auth/redirect/{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.redirect');
// callback url
Route::get('/auth/callback/{provider}', [AuthController::class, 'handleProviderCallback'])->name('auth.callback') ;