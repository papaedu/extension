<?php

namespace Papaedu\Extension\Socialite;

use Illuminate\Http\Request;
use Overtrue\Socialite\Exceptions\AuthorizeFailedException;
use Papaedu\Extension\Auth\AuthTrait;
use Papaedu\Extension\Enums\BadRequestCode;
use Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthenticatesUsersByWechat
{
    use AuthTrait;
    use SocialiteTrait;

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $weChatPlatform
     * @param  string  $weChatChannel
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, string $weChatPlatform, string $weChatChannel)
    {
        if (!$request->has('code')) {
            throw new HttpException(400, trans('bad_request.authorization_failed'));
        }

        try {
            $application = SocialiteApplication::wechat($weChatPlatform, $weChatChannel);
            $application->attemptOauth($request->code);

            if ($weChatId = $application->getId()) {
                if ($this->attemptLogin($weChatId)) {
                    return $this->sendLoginResponse();
                }

                $application->saveOauthUser();

                throw new HttpException(
                    400,
                    trans('extension::socialite.wechat.unbind'),
                    null,
                    [],
                    BadRequestCode::SOCIALITE_UNBIND
                );
            }
        } catch (WeChatUndefinedUnionIdException $e) {
            throw new HttpException(
                400,
                trans('extension::socialite.authorization_failed'),
                null,
                [],
                BadRequestCode::SOCIALITE_UNDEFINED_UNION_ID
            );
        } catch (AuthorizeFailedException $e) {
        }

        throw new HttpException(
            400,
            trans('extension::socialite.authorization_failed'),
            null,
            [],
            BadRequestCode::SOCIALITE_AUTHORIZED_FAILED
        );
    }

    public function info(Request $request)
    {
        if (!$request->has(['iv', 'encrypted_data'])) {
            throw new HttpException(400, trans('extension::status_message.400.default'));
        }

        $application = SocialiteApplication::wechat();
        $application->attemptSetUserInfo($request->iv, $request->encrypted_data);
        if ($weChatId = $application->getId()) {
            if ($this->attemptLogin($weChatId)) {
                return $this->sendLoginResponse($application);
            }

            $application->saveOauthUser();

            throw new HttpException(
                400,
                trans('extension::socialite.wechat.unbind'),
                null,
                [],
                BadRequestCode::SOCIALITE_UNBIND
            );
        }

        throw new HttpException(
            400,
            trans('extension::socialite.authorization_failed'),
            null,
            [],
            BadRequestCode::SOCIALITE_AUTHORIZED_FAILED
        );
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  string  $weChatId
     * @return bool
     */
    protected function attemptLogin(string $weChatId): bool
    {
        $socialite = $this->socialiteModel()
            ->where('openid', $weChatId)// It's means maybe openid, maybe union id.
            ->where('type', $this->socialiteTypeUnionId())
            ->first([
                $this->userId(),
            ]);
        if (is_null($socialite)) {
            return false;
        }

        $this->guard()->login($socialite->user);

        return true;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Papaedu\Extension\Socialite\WeChatWith  $application
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse($application)
    {
        $this->bindSocialite(
            $application->getSocialiteType(),
            $this->guard()->id(),
            $application->getOpenid(),
            $application->getNickname()
        );

        return $this->tokenResponse($this->guard()->user());
    }
}
