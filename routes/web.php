<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\OrderController as HomeOrderController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\SitemapController;
use App\Http\Controllers\Home\UserAddressController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishListController;
use App\Models\City;
use Illuminate\Support\Facades\Route;

// ---------------- Admin Routs ----------------
Route::prefix('admin-panel')->name('admin.')->middleware(['role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('management')->group(function () {
        Route::resource('brands', BrandController::class);
        Route::resource('attributes', AttributeController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('products', ProductController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('comments', CommentController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('settings', SettingsController::class);
        Route::resource('users', UserController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);

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
});

// ---------------- Home Routs ----------------
Route::prefix('/')->name('home.')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('index');
    Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
    Route::post('contact-us-form', [HomeController::class, 'contactUsForm'])->name('contact-us-form');

    // Sitemap routes
    Route::get('sitemap', [SitemapController::class, 'index'])->name('sitemap.index');
    Route::get('sitemap-tags', [SitemapController::class, 'tags'])->name('sitemap.tags');
    Route::get('sitemap-products', [SitemapController::class, 'products'])->name('sitemap.products');

    Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('categories.show');

    Route::get('/products/{product:slug}', [HomeProductController::class, 'show'])->name('products.show');

    Route::post('/comments/{product}', [HomeCommentController::class, 'store'])->name('comments.store');

    Route::get('/wishlist/toggle/{product}', [WishListController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
    Route::get('/compare/add/{product}', [CompareController::class, 'addProductToCompare'])->name('compare.add.product');
    Route::get('/compare/remove/{productId}', [CompareController::class, 'removeProductFromCompare'])->name('compare.remove.product');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/product', [CartController::class, 'addProductToCart'])->name('cart.add.product');
    Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::get('/cart/remove/{rowId}', [CartController::class, 'removeCartItem'])->name('cart.remove.product');
    Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');

    // Order routes
    Route::get('/orders/checkout', [HomeOrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders/payment', [HomeOrderController::class, 'payment'])->name('orders.payment');
    Route::get('/orders/payment/callback/{gateway}', [HomeOrderController::class, 'paymentVerify'])->name('orders.payment.callback');
});
//Route::get('/product-modal', [HomeController::class, 'showProductModal'])->name('showProductModal');
// ---------------- End Home Routs ----------------

// ---------------- User Profile Routs ----------------
Route::prefix('profile')->name('home.profile.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('index');
    Route::get('/comments', [HomeCommentController::class, 'userCommentsIndex'])->name('comments.index');
    Route::get('/wishlist', [WishListController::class, 'userWishListIndex'])->name('wishlist.index');
    Route::delete('/wishlist/remove/{product}', [WishListController::class, 'removeProductFromUserWishList'])->name('wishlist.remove');
    Route::resource('addresses', UserAddressController::class);
    Route::get('/orders', [HomeOrderController::class, 'userOrdersIndex'])->name('orders.index');
});
// ---------------- End User Profile Routs ----------------

Route::get('/get-cities/{provinceId}', function ($provinceId) {
    return response()->json(City::where('province_id', $provinceId)->get());
})->name('get.cities');

// Social auth routs
Route::get('/auth/redirect/{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.redirect');
// callback url
Route::get('/auth/callback/{provider}', [AuthController::class, 'handleProviderCallback'])->name('auth.callback');

Route::get('/test', function () {
    \Cart::clear();
//    dd(\Cart::getContent());
});