<?php

namespace Papaedu\Extension\Socialite;

use EasyWeChat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\Response;
use Papaedu\Extension\Models\Socialite;

trait LoginByWechatMiniProgram
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
        if (! $request->has('code')) {
            Response::errorBadRequest(trans('extension::socialite.undefined_code'));
        }

        if ($response = $this->attemptLogin($request)) {
            return $response;
        }

        Response::errorBadRequest(trans('extension::socialite.authorization_failed'));
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
            Socialite::setTemp(
                $this->driver(),
                $this->type(),
                $this->oauthUser['openid'],
                [
                    'session_key' => $this->oauthUser['session_key'],
                    'unionid' => $this->oauthUser['unionid'],
                ]
            );

            return Response::array([
                'openid' => $this->oauthUser['openid'],
            ]);
        }

        $this->guard()->login($socialite->user);

        return $this->sendLoginResponse($request);
    }

    protected function attemptOauth(Request $request): bool
    {
        try {
            $app = EasyWeChat::miniApp();
            $this->oauthUser = $app->getUtils()->codeToSession($request->input('code'));
            if (isset($this->oauthUser['unionid'])) {
                return true;
            }
        } catch (EasyWeChat\Kernel\Exceptions\InvalidConfigException $e) {
            Log::error('Login by socialite wechat mini program.', [
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
