<?php

namespace Papaedu\Extension\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait Authenticated
{
    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated($user)
    {
        return $this->response->array([
            'access_token' => $user->createToken('front')->plainTextToken,
            'token_type' => 'Bearer',
            'uuid' => $user->uuid,
        ]);
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
}