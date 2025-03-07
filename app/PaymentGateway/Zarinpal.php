<?php

namespace App\PaymentGateway;

use App\Constants\PaymentTypes;

class Zarinpal extends Payment
{
    public function send($amounts, $description, $addressId): array
    {
        $data = [
            'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'amount' => $amounts['paying_amount'] . '0',
            'callback_url' => route('home.orders.payment.callback', PaymentTypes::ZARINPAL->value),
            'description' => $description
        ];

        $response = $this->curl_post('https://sandbox.zarinpal.com/pg/v4/payment/request.json', $data);
        if ($response['error']) {
            return ['error' => "cURL Error #:" . $response['error']];
        } else {
            $result = $response['result'];

            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    $createOrder = parent::createOrder($addressId, $amounts, $result['data']["authority"], PaymentTypes::ZARINPAL->value);
                    if (array_key_exists('error', $createOrder)) {
                        return $createOrder;
                    }

                    return ['redirect' => 'https://sandbox.zarinpal.com/pg/StartPay/' . $result['data']["authority"]];
                }
                return ['error' => 'Error Code: ' . $result['data']['code']];
            } else {
                return ['error' => 'Error Code: ' . $result['errors']['code'] . ' message: ' . $result['errors']['message']];
            }
        }
    }

    public function verify($authority, $amount): array
    {
        $data = [
            'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'authority' => $authority,
            'amount' => $amount . '0'
        ];

        $response = $this->curl_post('https://sandbox.zarinpal.com/pg/v4/payment/verify.json', $data);
        if ($response['error']) {
            return ['error' => "cURL Error #:" . $response['error']];
        } else {
            $result = $response['result'];
//            dd($result);
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    $updateOrder = parent::updateOrder($authority, $result['data']['ref_id']);
                    if (array_key_exists('error', $updateOrder)) {
                        return $updateOrder;
                    }
                    \Cart::clear();
                    return ['success' => "پرداخت شما با موفقیت انجام شد، کد رهگیری شما {$result['data']['ref_id']} می‌باشد"];
                } else {
                    return ['error' => 'Transaction failed. Status: ' . $result['errors']['code'] . ' message: ' . $result['errors']['message']];
                }
            } else {
                return ['error' => 'Error Code: ' . $result['errors']['code'] . ' message: ' . $result['errors']['message']];
            }
        }
    }

    private function curl_post($url, $data): array
    {
        $jsonData = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return ['result' => json_decode($result, true), 'error' => $err];
    }
}