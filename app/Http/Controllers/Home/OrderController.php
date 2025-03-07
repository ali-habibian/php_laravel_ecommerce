<?php

namespace App\Http\Controllers\Home;

use App\Constants\PaymentTypes;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\Province;
use App\PaymentGateway\Pay;
use App\PaymentGateway\Zarinpal;
use Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class OrderController extends Controller
{
    public function checkout()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('home.cart.index')->with('error', 'سبد خرید شما خالی است');
        }

        $userAddress = auth()->user()->addresses;
        $provinces = Province::all();

        return view('home.orders.checkout', compact('userAddress', 'provinces'));
    }

    public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => [
                'required',
                Rule::in(PaymentTypes::getPaymentTypeValues())
            ],
            'address_id' => [
                'required',
                Rule::exists('user_addresses', 'id')->where('user_id', auth()->user()->id)
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'payment_error' => 'مشکلی در انتقال به صفحه پرداخت رخ داده است، لطفا مجددا تلاش کنید'
            ]);

        }

        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            return redirect()->route('home.index')->with('error', $checkCart['error']);
        }

        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            return redirect()->route('home.index')->with('error', $amounts['error']);
        }

        if ($request->payment_method == PaymentTypes::PAY->value) {
            return redirect()->back()->with('error', 'درگاه پرداخت پی موقتا از دسترس خارج شده است، لطفا درگاه دیگری را انتخاب کنید');

//            $payGateway = new Pay();
//            $payGatewayResult = $payGateway->send($amounts, $request->address_id);
//
//            if (array_key_exists('error', $payGatewayResult)) {
//                return redirect()->back()->with('error', $payGatewayResult['error']);
//            } else {
//                return redirect()->to($payGatewayResult['redirect']);
//            }
        } else if ($request->payment_method == PaymentTypes::ZARINPAL->value) {
            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->send($amounts, 'پرداخت تست درگاه زرین پال', $request->address_id);

            if (array_key_exists('error', $zarinpalGatewayResult)) {
                return redirect()->back()->with('error', $zarinpalGatewayResult['error']);
            } else {
                return redirect()->to($zarinpalGatewayResult['redirect']);
            }
        } else {
            return redirect()->back()->with('error', 'درگاه پرداختی انتخاب شده معتبر نمی باشد');
        }
    }

    public function paymentVerify(Request $request, $gateway)
    {
        if ($gateway == PaymentTypes::PAY->value) {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->verify($request->token, $request->status);

            if (array_key_exists('error', $payGatewayResult)) {
                return redirect()->back()->with('error', $payGatewayResult['error']);
            } else {
                return redirect()->route('home.index')->with('success', $payGatewayResult['success']);
            }
        } elseif ($gateway == PaymentTypes::ZARINPAL->value){
            $zarinpalGateway = new Zarinpal();

            $amounts = $this->getAmounts();
            if (array_key_exists('error', $amounts)) {
                return redirect()->route('home.index')->with('error', $amounts['error']);
            }

            $zarinpalGatewayResult = $zarinpalGateway->verify($request->Authority, $amounts['paying_amount']);

            if (array_key_exists('error', $zarinpalGatewayResult)) {
                return redirect()->back()->with('error', $zarinpalGatewayResult['error']);
            } else {
                return redirect()->route('home.index')->with('success', $zarinpalGatewayResult['success']);
            }
        }else{
            return redirect()->back()->with('error', 'درگاه پرداختی انتخاب شده معتبر نمی باشد');
        }
    }

    private function checkCart()
    {
        if (Cart::isEmpty()) {
            return [
                'error' => 'سبد خرید شما خالی است'
            ];
        }

        $priceChangedProducts = [];
        foreach (Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                $priceChangedProducts[] = $item->id;
                Cart::remove($item->id);
            }
        }

        if (count($priceChangedProducts) > 0) {
            return [
                'error' => 'قیمت یک یا چند محصول تغییر کرده است، ما آن محصولات را از سبد خرید شما حذف کردیم، لطفا مجددا سفارش خود را ثبت کنید'
            ];
        }

        $quantityChangedProducts = [];
        foreach (Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            if ($item->quantity > $variation->quantity) {
                $quantityChangedProducts[] = $item->id;
                Cart::remove($item->id);
            }
        }

        if (count($quantityChangedProducts) > 0) {
            return [
                'error' => 'موجودی انبار یک یا چند محصول از سبد خرید شما تغییر کرده و کمتر از تعداد درخواستی شما است، ما آن محصولات را از سبد خرید شما حذف کردیم، لطفا مجددا سفارش خود را ثبت کنید'
            ];
        }

        return ['success' => true];
    }

    private function getAmounts()
    {
        if (session()->has('coupon')) {
            try {
                validateCoupon(session('coupon.code'));
            } catch (Exception $e) {
                if ($e->getCode() === 403) {
                    return ['error' => $e->getMessage()];
                }
                return ['error' => 'کد تخفیف وارد شده معتبر نمی باشد'];
            }
        }

        return [
            'total_amount' => (Cart::getTotal() + cartTotalDiscountAmount()),
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session('coupon.amount') : 0,
            'paying_amount' => cartTotalAmount()
        ];
    }
}
