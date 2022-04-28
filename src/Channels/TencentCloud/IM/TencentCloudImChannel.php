<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Papaedu\Extension\TencentCloud\Tim\TencentCloudTim;

class TencentCloudImChannel
{
    /**
     * @var \Papaedu\Extension\TencentCloud\Tim\TencentCloudTim
     */
    protected TencentCloudTim $tencentCloudTim;

    public function __construct(TencentCloudTim $tencentCloudTim)
    {
        $this->tencentCloudTim = $tencentCloudTim;
    }

    /**
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationFor('tencent_cloud_im');
        } elseif (is_array($notifiable)) {
            $to = $notifiable;
        } else {
            return;
        }
        $message = $notification->toTencentCloudIm($notifiable);

        $this->tencentCloudTim->sendPrivateMsg($to, $message);
    }
}
