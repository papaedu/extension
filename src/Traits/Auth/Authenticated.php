<?php

namespace Papaedu\Extension\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait Authenticated
{
    protected $hasUuid = true;

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated($user)
    {
        $result = [
            'access_token' => $user->createToken($this->tokenName())->plainTextToken,
            'token_type' => 'Bearer',
        ];
        if (true === $this->hasUuid) {
            $result['uuid'] = $user->uuid;
        }

        return $this->response->array($result);
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
     * Before return log info response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function beforeResponse(Request $request, $user)
    {
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
}