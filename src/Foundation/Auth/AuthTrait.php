<?php

namespace Papaedu\Extension\Foundation\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Papaedu\Extension\Enums\AuthStatus;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthTrait
{
    /**
     * @param  int  $status
     */
    protected function validateStatus(int $status)
    {
        if (AuthStatus::Ban == $status) {
            throw new HttpException(400, '此账号已封停');
        } elseif (AuthStatus::Close == $status) {
            throw new HttpException(400, '此账号已注销');
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function tokenResponse($user)
    {
        $data = [
            'access_token' => $user->createToken($this->tokenName())->plainTextToken,
            'token_type' => 'Bearer',
        ];
        if (isset($user->uuid)) {
            $data['uuid'] = $user->uuid;
        }

        return new JsonResponse(['data' => $data]);
    }

    /**
     * Validate user uuid, if not generate.
     *
     * @param  mixed  $user
     */
    protected function validateUuid($user)
    {
        if (!$user->uuid) {
            $user->uuid = str_replace('-', '', Str::uuid()->toString());
            $user->save();
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the sanctum token name to be used by the controller.
     *
     * @return string
     */
    public function tokenName()
    {
        return 'user';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}