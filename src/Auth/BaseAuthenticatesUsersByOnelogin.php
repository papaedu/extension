<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Facades\Geetest;

trait BaseAuthenticatesUsersByOnelogin
{
    use BaseAuthenticatesUsers;

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'process_id' => ['required'],
            'token' => ['required'],
        ], [
            'required' => trans('extension::auth.onelogin_failed'),
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  string  $appName
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(string $appName, Request $request): bool
    {
        $username = Geetest::config($appName)
            ->oneLoginCheckPhone(
                $request->input('process_id', ''),
                $request->input('auth_code', ''),
                $request->input('token', '')
            );

        if (!$username) {
            return false;
        }

        // Only support locale telephone for now.
        $user = $this->create($this->credentials($username));
        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        $this->guard()->login($user);

        return true;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  string  $username
     * @return array
     */
    protected function credentials(string $username): array
    {
        return $this->extraParams() + [$this->username() => $username];
    }

    /**
     * Get the failed login response instance.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('extension::auth.onelogin_failed')],
        ]);
    }
}
