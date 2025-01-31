<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function toggle(Product $product)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($product->existsInUserWishList($user)) {
                // remove product from wishlist
                $user->wishlist()->where('product_id', $product->id)->delete();
                return redirect()->back()->with('success', 'محصول با موفقیت از لیست علاقه‌مندی ها حذف شد');
            } else {
                $user->wishlist()->create([
                    'product_id' => $product->id,
                ]);
            }
        } else {
            return redirect()->back()->with('warning', 'برای افزودن به لیست علاقه‌مندی ‌ها شما باید ابتدا وارد سایت شوید');
        }

        return redirect()->back()->with('success', 'محصول با موفقیت به لیست علاقه‌مندی ها اضافه شد');
    }
}
