<?php

namespace Papaedu\Extension\Support\Traits;

use EasyWeChat;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Enums\WeChatPlatform;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait WeChat
{
    /**
     * @param  string  $weChatChannel
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function config(string $weChatChannel, Request $request)
    {
        if (!$request->has('url')) {
            throw new HttpException(400, trans('extension::status_message.400.default'));
        }

        $officialAccount = EasyWeChat::officialAccount($weChatChannel);
        $officialAccount->jssdk->setUrl($request->url);

        try {
            $config = $officialAccount->jssdk->buildConfig(
                ['updateAppMessageShareData', 'updateTimelineShareData'],
                false,
                false,
                false
            );

            return new JsonResponse(['data' => $config]);
        } catch (Exception $e) {
        }

        throw new HttpException(500, trans('extension::status_message.500.default'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrypt(Request $request)
    {
        $loginWithWeChat = session('login_with_wechat');
        if (WeChatPlatform::MINI_PROGRAM == $loginWithWeChat['platform']
            && $request->has('iv')
            && $request->has('encrypted_data')) {
            try {
                $miniProgram = EasyWeChat::miniProgram($loginWithWeChat['channel']);
                $data = $miniProgram->encryptor->decryptData(
                    $loginWithWeChat['oauth_user']['session_key'],
                    $request->iv,
                    $request->encrypted_data
                );

                return new JsonResponse(['data' => $data]);
            } catch (EasyWeChat\Kernel\Exceptions\DecryptException $e) {
                throw new HttpException(500, trans('extension::status_message.500.default'));
            }
        }

        throw new HttpException(400, trans('extension::status_message.400.default'));
    }
}