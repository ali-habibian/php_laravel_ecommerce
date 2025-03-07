<?php

namespace App\PaymentGateway;

use App\Constants\PaymentMethods;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use Darryldecode\Cart\Cart;
use DB;
use Exception;

class Payment
{
    public function createOrder($addressId, $amounts, $token, $gatewayName): array
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'user_address_id' => $addressId,
                'coupon_id' => session()->has('coupon') ? session('coupon.id') : null,
                'total_amount' => $amounts['total_amount'],
                'delivery_charge' => $amounts['delivery_amount'],
                'coupon_discount' => $amounts['coupon_amount'],
                'paying_amount' => $amounts['paying_amount'],
                'payment_method' => PaymentMethods::ONLINE
            ]);

            foreach (Cart::getContent() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->associatedModel->product_id,
                    'product_variation_id' => $item->attributes->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => ($item->price * $item->quantity),
                ]);
            }

            Transaction::create([
                'user_id' => auth()->user()->id,
                'order_id' => $order->id,
                'amount' => $amounts['paying_amount'],
                'token' => $token,
                'gateway_name' => $gatewayName,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => 'با عرض پوزش، سیستم موقتا قادر به درج سفارش شما نمی باشد، لطفا مجددا تلاش کنید'];
        }

        return ['success' => true];
    }

    public function updateOrder($token, $refId): array
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::where('token', $token)->firstOrFail();
            $transaction->update([
                'status' => 1,
                'ref_id' => $refId
            ]);

            $order = Order::findOrFail($transaction->order_id);
            $order->update([
                'payment_status' => 1,
                'status' => 1
            ]);

            foreach (Cart::getContent() as $item) {
                $variation = ProductVariation::find($item->attributes->id);
                $variation->update([
                    'quantity' => ($variation->quantity - $item->quantity)
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => 'با عرض پوزش، سیستم موقتا قادر به درج سفارش شما نمی باشد، لطفا مجددا تلاش کنید'];
        }

        return ['success' => true];
    }
}