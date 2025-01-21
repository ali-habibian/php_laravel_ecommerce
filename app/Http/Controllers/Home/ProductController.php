<?php

namespace App\Http\Controllers\Home;

use App\Constants\BannerTypes;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $productDetailPageBanner = Banner::where('type', BannerTypes::PRODUCT_DETAIL_PAGE)
            ->where('is_active', true)
            ->orderBy('priority')
            ->first();

        $sameProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
//            ->orderBy() TODO - orderBy by rating
            ->take(8)->get();

        return view('home.product.show', compact('product', 'productDetailPageBanner', 'sameProducts'));
    }
}
