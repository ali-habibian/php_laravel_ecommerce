<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('home.cart.index');
    }

    public function addProductToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'variation_id' => 'required|exists:product_variations,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $productVariation = $product->productVariations()->findOrFail($request->variation_id);

        if ($request->quantity > $productVariation->quantity) {
            return response()->json(['error' => 'تعداد درخواستی بیشتر از موجودی است'], 422);
        }

        $rowId = $product->id . '_' . $productVariation->id;
        if (Cart::get($rowId)) {
            return response()->json(['error' => 'محصول قبلا به سبد خرید اضافه شده است'], 422);
        }

        Cart::add(array(
            'id' => $rowId,
            'name' => $product->name,
            'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
            'quantity' => $request->quantity,
            'attributes' => $productVariation->toArray(),
            'associatedModel' => $product,
        ));

        return response()->json(['success' => 'محصول با موفقیت به سبد خرید اضافه شد']);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'qtybutton' => 'required|array',
            'qtybutton.*' => 'required|integer|min:1',
        ]);

        foreach ($request->qtybutton as $rowId => $quantity) {
            $item = Cart::get($rowId);

            if ($quantity > $item->attributes->quantity) {
                return redirect()->back()->with('error', 'تعداد درخواستی بیشتر از موجودی است');
            }

            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity,
                )
            ));
        }

        return redirect()->back()->with('success', 'سبد خرید شما با موفقیت بروزرسانی شد');
    }

    public function removeCartItem($rowId)
    {
        Cart::remove($rowId);

        return redirect()->back()->with('success', 'محصول با موفقیت از سبد خرید شما حذف شد');
    }

    public function clearCart()
    {
        Cart::clear();

        return redirect()->back()->with('success', 'سبد خرید شما خالی شد');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (!auth()->check()) {
            return redirect()->back()->with('error', 'برای استفاده از کد تخفیف باید وارد سایت شوید');
        }

        try {
            validateCoupon($request->code);
            return redirect()->back()->with('success', 'کد تخفیف با موفقیت اعمال شد');
        } catch (Exception $e) {
            if ($e->getCode() === 403) {
                return redirect()->back()->with('error', $e->getMessage());
            }

            return redirect()->back()->with('error', 'کد تخفیف وارد شده معتبر نمی باشد');
        }
    }
}
