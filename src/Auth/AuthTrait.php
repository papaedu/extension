<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Papaedu\Extension\Enums\AuthStatus;
use Papaedu\Extension\Enums\BadRequestCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthTrait
{
    /**
     * @var bool
     */
    protected bool $handleBaned = true;

    /**
     * @var bool
     */
    protected bool $handleClosed = true;

    /**
     * @param  mixed  $user
     */
    protected function validateStatus($user)
    {
        if (AuthStatus::BANED == $user->status && true == $this->handleBaned) {
            throw new HttpException(
                400,
                trans('extension::auth.status_baned'),
                null,
                [],
                BadRequestCode::ACCOUNT_BANED
            );
        }
        if (AuthStatus::CLOSED == $user->status && true == $this->handleClosed) {
            throw new HttpException(
                400,
                trans('extension::auth.status_closed'),
                null,
                [],
                BadRequestCode::ACCOUNT_CLOSED
            );
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function tokenResponse($user): JsonResponse
    {
        $data = [
            'access_token' => $user->createToken($this->tokenName())->plainTextToken,
            'token_type' => 'Bearer',
        ];
        if (isset($user->uuid)) {
            $data['uuid'] = $user->uuid;
        }
        if (isset($user->login_count)) {
            $data['login_count'] = $user->login_count;
        }

        return new JsonResponse(['data' => $data]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return 'username';
    }

    /**
     * Get the sanctum token name to be used by the controller.
     *
     * @return string
     */
    public function tokenName(): string
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
