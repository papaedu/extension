<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Exceptions\BadRequestException;
use Papaedu\Extension\Exceptions\HttpException;
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
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request): bool
    {
        try {
            $username = Geetest::onePass($request->header(Header::APP_NAME, ''))
                ->oneLoginCheckPhone(
                    $request->input('process_id', ''),
                    $request->input('auth_code', ''),
                    $request->input('token', '')
                );

            if (empty($username)) {
                return false;
            }

            // Only support locale telephone for now.
            $user = $this->create($this->credentials($username));
            if ($user->wasRecentlyCreated) {
                event(new Registered($user));
            }

            // Only support locale telephone for now.
            $this->guard()->login($user);

            return true;
        } catch (HttpException $e) {
            Log::error($e->getMessage(), $e->getTrace());
        } catch (BadRequestException $e) {
            Log::warning($e->getMessage());
        }

        return false;
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
