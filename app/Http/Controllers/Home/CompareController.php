<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    const SESSION_KEY = 'compareProducts';
    const MAX_COMPARE_PRODUCTS = 4;

    public function addProductToCompare(Product $product)
    {
        if (session()->has(self::SESSION_KEY)) {
            if (in_array($product->id, session(self::SESSION_KEY))){
                return redirect()->back()->with('warning', 'محصول مورد نظر قبلا به لیست مقایسه اضافه شده است');
            }

            if (count(session(self::SESSION_KEY)) >= self::MAX_COMPARE_PRODUCTS){
                return redirect()->back()->with('warning', 'شما حداکثر ' . self::MAX_COMPARE_PRODUCTS . ' محصول را می‌توانید به لیست مقایسه اضافه کنید');
            }

            session()->push(self::SESSION_KEY, $product->id);
        } else {
            session()->put(self::SESSION_KEY, [$product->id]);
        }

        return redirect()->back()->with('success', 'محصول با موفقیت به لیست مقایسه اضافه شد');
    }
}
