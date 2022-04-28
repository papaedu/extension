<?php

namespace Papaedu\Extension\TencentCloud\Tim;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Channels\TencentCloud\IM\TencentCloudImMessage;
use Papaedu\Extension\Enums\TencentCloudChatType;
use Papaedu\Extension\Facades\TencentCloud;
use Papaedu\Extension\TencentCloud\Exceptions\BadRequestException;
use Papaedu\Extension\TencentCloud\Exceptions\HttpException;
use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\BatchSendMsgRequest;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncOtherMachine;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\AndroidInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\SendMsgRequest;

class TencentCloudTim
{
    /**
     * @param $to
     * @param  \Papaedu\Extension\Channels\TencentCloud\IM\TencentCloudImMessage  $message
     * @throws \Exception
     */
    public function sendPrivateMsg($to, TencentCloudImMessage $message)
    {
        try {
            // 设置发送的消息内容
            $msgBody = new MsgBody();
            if ($customMessage = $message->getCustomMessage()) {
                $msgBody->setCustomMsg($customMessage);
            } elseif ($text = $message->getText()) {
                $msgBody->setTextMsg($text);
            } else {
                Log::error('TencentCloudTim 消息内容不存在', [
                    'to' => $to,
                ]);

                return;
            }

            if (is_array($to)) {
                $request = new BatchSendMsgRequest($to, $msgBody, $message->getFromAccount());
            } else {
                $request = new SendMsgRequest($to, $msgBody, $message->getFromAccount());
            }
            $request->setSyncOtherMachine(SyncOtherMachine::OUT_OF_SYNC);

            // 设置离线推送消息内容
            $offlinePushInfo = $this->getOfflinePushInfo($message);
            $request->setOfflinePushInfo($offlinePushInfo);

            TencentCloud::tim()->sendRequest($request);
        } catch (GuzzleException | HttpException $e) {
            Log::error('TencentCloudTim 请求异常', [
                'to' => $to,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        } catch (BadRequestException $e) {
            Log::error('TencentCloudTim 异常请求', [
                'to' => $to,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        } catch (InvalidArgumentException $e) {
            Log::error('TencentCloudTim 参数异常', [
                'to' => $to,
                'text' => $message->getText(),
                'parameters' => isset($request) ? $request->getParameters() : '',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param  \Papaedu\Extension\Channels\TencentCloud\IM\TencentCloudImMessage  $message
     * @return \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo
     */
    public function getOfflinePushInfo(TencentCloudImMessage $message): OfflinePushInfo
    {
        $offlinePushInfo = new OfflinePushInfo();
        $offlinePushInfo->setTitle($message->getFromAccountName());
        $offlinePushInfo->setDesc($message->getText());
        $offlinePushInfo->setExt(json_encode([
            'entity' => [
                'chat_type' => TencentCloudChatType::PRIVATE_CHAT->value,
                'nickname' => $message->getFromAccountName(),
                'sender' => $message->getFromAccount(),
            ],
        ]));

        if (config('tencent-cloud.tim.offline_push.android_info.oppo_channel_id')
            || config('tencent-cloud.tim.offline_push.android_info.xiaomi_channel_id')) {
            $androidInfo = new AndroidInfo();
            $androidInfo->setOppoChannelId(config('tencent-cloud.tim.offline_push.android_info.oppo_channel_id'));
            $androidInfo->setXiaoMiChannelId(config('tencent-cloud.tim.offline_push.android_info.xiaomi_channel_id'));
            $offlinePushInfo->setAndroidInfo($androidInfo);
        }

        return $offlinePushInfo;
    }
}
