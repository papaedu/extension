<?php

namespace Papaedu\Extension\Socialite;

use EasyWeChat;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\Response;
use Papaedu\Extension\Models\Socialite;
use Papaedu\Extension\Support\Extend;

trait LoginByWechatMobile
{
    /**
     * @var array
     */
    protected array $oauthUser = [];

    /**
     * @var string
     */
    protected string $socialiteType = 'weixin_papaedu_mini_program';

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->sendFailedLoginResponse();
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'openid' => ['required'],
            'iv' => ['required'],
            'encrypted_data' => ['required'],
        ], [
            'required' => trans('extension::socialite.undefined_code'),
        ]);
    }

    protected function attemptLogin(Request $request): ?JsonResponse
    {
        if (! $this->attemptOauth($request)) {
            return null;
        }

        $socialite = Socialite::query()
            ->where('type', $this->unionType())
            ->where('openid', $this->oauthUser['unionid'])
            ->first([
                'user_id',
            ]);
        if (is_null($socialite)) {
            $user = $this->create($this->credentials($this->oauthUser));
            if ($user->wasRecentlyCreated) {
                event(new Registered($user));
            }

            Socialite::create([
                'user_id' => $user->id,
                'type' => $this->unionType(),
                'nickname' => config('extension.auth.nickname_prefix').Extend::randomNumeric(),
                'openid' => $this->oauthUser['unionid'],
            ]);
            Socialite::create([
                'user_id' => $user->id,
                'type' => $this->oauthUser['type'],
                'nickname' => '',
                'openid' => $this->oauthUser['openid'],
            ]);
        } else {
            $user = $socialite->user;
        }

        $this->guard()->login($user);

        return $this->sendLoginResponse($request);
    }

    protected function attemptOauth(Request $request): bool
    {
        $oauthUser = Socialite::getTemp($this->driver(), $request->input('openid'));
        if (! $oauthUser) {
            return false;
        }

        try {
            $app = EasyWeChat::miniApp();
            $decryptedData = $app->getUtils()->decryptSession(
                $oauthUser['session_key'],
                $request->input('iv'),
                $request->input('encrypted_data')
            );

            $oauthUser['openid'] = $request->input('openid');
            $oauthUser['iso_code'] = '';
            $oauthUser['idd_code'] = $decryptedData['countryCode'];
            $oauthUser[$this->username()] = $decryptedData['phoneNumber'];
            $this->oauthUser = $oauthUser;

            return true;
        } catch (EasyWeChat\Kernel\Exceptions\DecryptException $e) {
            Log::error('Login by socialite wechat mobile.', [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
            Response::errorBadRequest(trans('extension::socialite.authorization_abnormal'));
        }

        return false;
    }

    /**
     * @param  int  $type
     * @param  int  $userId
     * @param  string  $openid
     * @param  string  $nickname
     */
    protected function binding(int $type, int $userId, string $openid, string $nickname = '')
    {
        Socialite::updateOrCreate([
            'type' => $type,
            'openid' => $openid,
        ], [
            'user_id' => $userId,
            'nickname' => $nickname,
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  array  $oauthUser
     * @return array
     */
    protected function credentials(array $oauthUser): array
    {
        return $this->extraParams($oauthUser) + [
                $this->username() => strval($oauthUser[$this->username()]),
            ];
    }

    protected function sendFailedLoginResponse()
    {
        Response::errorBadRequest(trans('extension::socialite.authorization_failed'));
    }

    /**
     * @param  array  $oauthUser
     * @return array
     */
    protected function extraParams(array $oauthUser): array
    {
        return [
            'idd_code' => $this->oauthUser['idd_code'],
        ];
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return 'default';
    }

    /**
     * @return int
     */
    protected function type(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    protected function unionType(): int
    {
        return 10;
    }
}
