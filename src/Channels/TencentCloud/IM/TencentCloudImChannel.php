<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Tim\TencentCloudTim;

class TencentCloudImChannel
{
    public function __construct(protected TencentCloudTim $tencentCloudTim)
    {
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notifiable, 'routeNotificationFor')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method routeNotificationFor.');
        }
        if (! method_exists($notification, 'toTencentCloudIm')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toTencentCloudIm.');
        }

        $receiver = $notifiable->routeNotificationFor('tencent_cloud_im');
        if (! is_string($receiver) || empty($receiver)) {
            throw new InvalidArgumentException('The to is invalid, is not string or empty.');
        }
        $message = $notification->toTencentCloudIm($notifiable);

        try {
            $this->tencentCloudTim->sendPrivateMsg($receiver, $message);
        } catch (Exception $e) {
            Log::error('[tencent_cloud_im_channel]发送失败：未找到匹配网关', [
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                'to' => $receiver,
            ]);
        }
    }
}
