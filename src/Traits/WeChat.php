<?php

namespace Papaedu\Extension\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Socialite\SocialiteApplication;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function trans;

trait WeChat
{
    /**
     * @param  string  $weChatChannel
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function config(string $weChatChannel, Request $request): JsonResponse
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

    public function decrypt(Request $request): JsonResponse
    {
        if ($request->has('iv') && $request->has('encrypted_data')) {
            $application = SocialiteApplication::wechat();
            $data = $application->decryptData($request->iv, $request->encrypted_data);

            return new JsonResponse(['data' => $data]);
        }

        throw new HttpException(400, trans('extension::status_message.400.default'));
    }
}
