<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use App\Enums\ImSystemIdentifier;
use Illuminate\Notifications\Notification;
use Papaedu\Extension\Facades\TencentCloud;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncOtherMachine;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\SendMsgRequest;

class TencentCloudImChannel
{
    /**
     * 单发消息
     *
     * @param $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\BadRequestException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\HttpException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTencentIM($notifiable);
        $msgBody = new MsgBody();
        $msgBody->setTextMsg($message->getText());
        $request = new SendMsgRequest(
            $notifiable->uuid,
            random_int(1, 999999),
            $msgBody,
            $message->getFromAccount()
        );
        $request->setSyncOtherMachine(SyncOtherMachine::OUT_OF_SYNC);
        TencentCloud::tim()->sendRequest($request);
    }
}
