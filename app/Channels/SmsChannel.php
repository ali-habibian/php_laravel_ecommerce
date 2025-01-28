<?php

namespace App\Channels;

use App\Notifications\SendOtpToUser;
use Ghasedak\DataTransferObjects\Request\InputDTO;
use Ghasedak\DataTransferObjects\Request\OtpMessageDTO;
use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
use Ghasedak\GhasedaksmsApi;
use Illuminate\Support\Carbon;

class SmsChannel
{
    public function send($notifiable, SendOtpToUser $notification)
    {
        $message = new OtpMessageDTO(Carbon::now(), [new ReceptorDTO($notifiable->mobile)], 'Ghasedak', [new InputDTO('Code', $notification->getParams())]);
        $api = new GhasedaksmsApi(config('ghasedaksms.api_key'));
        $api->sendOtp($message);
    }
}