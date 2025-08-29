<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailOtp extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->line('Please use the following One-Time Password (OTP) to verify your email address:')
            ->line('Your OTP is: **' . $notifiable->otp . '**')
            ->line('This OTP is valid for 15 minutes.')
            ->line('If you did not create an account, no further action is required.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
