<?php

namespace App\Http\Controllers\Home;

use App\Constants\BannerTypes;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type', BannerTypes::SLIDER)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        $indexTopBanners = Banner::where('type', BannerTypes::INDEX_TOP)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        $indexBottomBanners = Banner::where('type', BannerTypes::INDEX_BOTTOM)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        $parentCategories = Category::with([
            'children.products' => function ($query) {
                $query->where('is_active', true)
                    ->take(10); // Limit to 10 products per child category // TODO must be dynamic and admin set the number of products
            }
        ])
            ->whereNull('parent_id') // Only parent categories
            ->take(3) // Limit to 3 parent categories // TODO must be dynamic and admin set the number of parent categories
            ->get();

        // Attach unique products to each parent category
        $parentCategories->each(function ($parentCategory) {
            $uniqueProducts = $parentCategory->children
                ->flatMap(function ($childCategory) {
                    return $childCategory->products;
                })
                ->unique('id'); // Ensure unique products by ID

            // Add the unique products as a new attribute
            $parentCategory->setRelation('uniqueProducts', $uniqueProducts);
        });

        return view('home.index', compact('sliders', 'indexTopBanners', 'indexBottomBanners', 'parentCategories'));
    }

    public function aboutUs()
    {
        // TODO: Add about us page content to database to make it dynamic
        $bottomBanners = Banner::where('type', BannerTypes::INDEX_BOTTOM)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        return view('home.about-us', compact('bottomBanners'));
    }

    public function contactUs()
    {
        $setting = Setting::first();
        return view('home.contact-us', compact('setting'));
    }

//    public function showProductModal(Request $request)
//    {
//        $modalProduct = Product::findOrFail($request->input('product_id'));
//        return view('home.index', compact('modalProduct'));
//    }
}
