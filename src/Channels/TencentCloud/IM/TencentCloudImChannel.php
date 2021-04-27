<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Enums\TencentCloudChatType;
use Papaedu\Extension\Facades\TencentCloud;
use Papaedu\Extension\TencentCloud\Exceptions\BadRequestException;
use Papaedu\Extension\TencentCloud\Exceptions\HttpException;
use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncOtherMachine;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\AndroidInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\SendMsgRequest;

class TencentCloudImChannel
{
    /**
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$receiver = $notifiable->routeNotificationFor('tencent_cloud_im')) {
            return;
        }

        $message = $notification->toTencentCloudIm($notifiable);

        try {
            $offlinePushInfo = new OfflinePushInfo();
            $offlinePushInfo->setTitle($message->getFromAccountName());

            $msgBody = new MsgBody();
            if ($customMessage = $message->getCustomMessage()) {
                $msgBody->setCustomMsg($customMessage);
                $offlinePushInfo->setDesc($message->getText());
            } elseif ($text = $message->getText()) {
                $msgBody->setTextMsg($text);
                $offlinePushInfo->setDesc($message->getText());
            } else {
                return;
            }

            $ext = [
                'entity' => [
                    'chat_type' => TencentCloudChatType::PRIVATE_CHAT,
                    'content' => $message->getText(),
                    'nickname' => $message->getFromAccountName(),
                    'send_time' => time(),
                    'sender' => $message->getFromAccount(),
                ],
            ];
            $offlinePushInfo->setExt(json_encode($ext));

            if (config('extension.tencent_cloud.tim.offline_push.android_info.oppo_channel_id')
                || config('extension.tencent_cloud.tim.offline_push.android_info.xiaomi_channel_id')) {
                $androidInfo = new AndroidInfo();
                $androidInfo->setOppoChannelId(config('extension.tencent_cloud.tim.offline_push.android_info.oppo_channel_id'));
                $androidInfo->setOppoChannelId(config('extension.tencent_cloud.tim.offline_push.android_info.xiaomi_channel_id'));
                $offlinePushInfo->setAndroidInfo($androidInfo);
            }

            $request = new SendMsgRequest(
                $notifiable->uuid,
                random_int(1, 999999),
                $msgBody,
                $message->getFromAccount()
            );
            $request->setSyncOtherMachine(SyncOtherMachine::OUT_OF_SYNC);
            $request->setOfflinePushInfo($offlinePushInfo);

            TencentCloud::tim()->sendRequest($request);
        } catch (GuzzleException | HttpException $e) {
            Log::error('TencentCloudImChannel 请求异常', [
                'uuid' => $notifiable->uuid,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        } catch (BadRequestException $e) {
            Log::error('TencentCloudImChannel 异常请求', [
                'uuid' => $notifiable->uuid,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        } catch (InvalidArgumentException $e) {
            Log::error('TencentCloudImChannel 参数异常', [
                'uuid' => $notifiable->uuid,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
