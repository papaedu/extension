<?php

namespace Papaedu\Extension\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Papaedu\Extension\Exceptions\InvalidArgumentException;

trait ReceiverTrait
{
    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     */
    public function getReceiver(string $name, object $notifiable, Notification $notification): PhoneNumberInterface
    {
        if (! method_exists($notification, $name)) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toEasySms.');
        }

        if ($notifiable instanceof Model) {
            if (! method_exists($notifiable, 'routeNotificationFor')) {
                throw new InvalidArgumentException('The notifiable is invalid, not found method routeNotificationFor.');
            }
            $receiver = $notifiable->routeNotificationFor('sms', $notification);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $receiver = $notifiable->routes[__CLASS__];
        } else {
            throw new InvalidArgumentException('The notifiable is invalid, not Model or AnonymousNotifiable.');
        }

        if (! $receiver instanceof PhoneNumberInterface) {
            throw new InvalidArgumentException('The to is invalid, not instanceof PhoneNumberInterface');
        }

        return $receiver;
    }
}
