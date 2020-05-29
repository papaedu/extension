<?php

namespace Papaedu\Extension\Traits\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait Authenticated
{
    protected $isValidateUuid = true;

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated($user)
    {
        $this->validateUuid($user);

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
        if ($this->isValidateUuid && !$user->uuid) {
            $user->uuid = str_replace('-', '', Str::uuid()->toString());
            $user->save();
        }
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