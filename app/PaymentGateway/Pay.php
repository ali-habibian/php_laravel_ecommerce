<?php

namespace App\PaymentGateway;

use App\Constants\PaymentTypes;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class Pay extends Payment
{
    public function send($amounts, $addressId): array
    {
        $api = 'test';
        $amount = $amounts['paying_amount'] . '0'; // .'0' converts it to Rial
        $mobile = auth()->user()->mobile;
        $factorNumber = null;
        $description = null;
        $redirect = route('home.orders.payment.callback', PaymentTypes::PAY);
        $result = $this->sendRequest($api, $amount, $redirect, $mobile, $factorNumber, $description);
        $result = json_decode($result);
        if (isset($result->status)) {
            if ($result->status) {
                $createdOrder = parent::createOrder($addressId, $amounts, $result->token, PaymentTypes::PAY);

                if (array_key_exists('error', $createdOrder)) {
                    return $createdOrder;
                }

                $go = "https://pay.ir/pg/$result->token";
                return ['redirect' => $go];
            } else {
//                return redirect()->back()->withErrors([
//                    'payment_error' => $result->errorMessage
//                ]);
                return ['error' => $result->errorMessage];
            }
        } else {
            return ['error' => "پرداخت شما با خطا مواجه شد، لطفا مجددا تلاش کنید"];
        }
    }

    public function verify($token, $status): array
    {
        $api = 'test';
        $result = json_decode($this->verifyRequest($api, $token));
        if (isset($result->status)) {
            if ($result->status == 1) {
                $updatedOrder = parent::updateOrder($token, $result->transId);
                if (array_key_exists('error', $updatedOrder)) {
                    return $updatedOrder;
                }

                Cart::clear();
//                return redirect()->route('home.index')->with('success', "پرداخت شما با موفقیت انجام شد، کد رهگیری شما {$result->transId} می‌باشد");
                return ['success' => "پرداخت شما با موفقیت انجام شد، کد رهگیری شما {$result->transId} می‌باشد"];
            } else {
//                return redirect()->route('home.index')->with('error', "پرداخت شما با خطا مواجه شد، لطفا مجددا تلاش کنید");
                return ['error' => "پرداخت شما با خطا مواجه شد، لطفا مجددا تلاش کنید"];
            }
        } else {
//            if ($status == 0) {
//            return redirect()->route('home.index')->with('error', "پرداخت شما با خطا مواجه شد، لطفا مجددا تلاش کنید");
//            }
            return ['error' => "پرداخت شما با خطا مواجه شد، لطفا مجددا تلاش کنید"];
        }
    }

    public function sendRequest($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ]);
    }

    public function verifyRequest($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}