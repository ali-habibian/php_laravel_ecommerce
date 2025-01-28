<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Ghasedak\DataTransferObjects\Request\InputDTO;
use Ghasedak\DataTransferObjects\Request\OtpMessageDTO;
use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
use Ghasedak\GhasedaksmsApi;
use Ghasedaksms\GhasedaksmsLaravel\Message\GhasedaksmsMessage;
use Ghasedaksms\GhasedaksmsLaravel\Message\GhasedaksmsVerifyLookUp;
use Ghasedaksms\GhasedaksmsLaravel\Notification\GhasedaksmsBaseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class SendOtpToUser extends Notification
{
    use Queueable;

    public string $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }

    public function getParams()
    {
        return $this->code;
    }

}
