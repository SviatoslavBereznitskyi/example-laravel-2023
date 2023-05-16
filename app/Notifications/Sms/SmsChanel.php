<?php

declare(strict_types=1);

namespace App\Notifications\Sms;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsChanel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     */
    public function send($notifiable, Notification $notification): void
    {
        /** @var VonageMessage $message */
        $message = $notification->toSms($notifiable);

        $basic = new Basic('54bc3b16', 'GC5R18juNq2zInzH');
        $client = new Client($basic);

        if ($notifiable instanceof Notifiable) {
            $to = $notifiable->routeNotificationFor('sms');
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $to = $notifiable->routes[static::class];
        } else {
            $to = $notifiable;
        }
        $client->sms()->send(
            new SMS($to, config('app.name'), $message->content)
        );
    }
}
