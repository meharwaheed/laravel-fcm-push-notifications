<?php

namespace Waheed\LaravelFcmPushNotifications\Channels;
use Illuminate\Notifications\Notification;
class FcmChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
            /** @var \Waheed\LaraFcm\FcmMessage $message */
        $message = $notification->toFirebase($notifiable);
    }
}
