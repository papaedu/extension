<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait BaseAuthenticatesUsersByCaptcha
{
    use BaseAuthenticatesUsers;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request): bool
    {
        $user = $this->create($this->credentials($request));
        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        $this->guard()->login($user);

        return true;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $this->extraParams($request) + $request->only($this->username());
    }

    /**
     * Get the failed login response instance.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('extension::auth.captcha_failed')],
        ]);
    }
}
