<?php

namespace Papaedu\Extension\Foundation\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Facades\Geetest;

trait AuthenticatesUsersByOnelogin
{
    use AuthTrait;
    use ThrottlesLogins;

    /**
     * Handle a login request to the application.
     *
     * @param  string  $appName
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(string $appName, Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($appName, $request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

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
    protected function attemptLogin(string $appName, Request $request)
    {
        if (!$mobile = Geetest::config($appName)->oneLoginCheckPhone($request->input('process_id', ''), $request->input('auth_code', ''), $request->input('token', ''))) {
            return false;
        }

        $user = $this->create($mobile);
        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        $this->guard()->login($user);

        return true;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $this->validateStatus($this->guard()->user()->status);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $this->tokenResponse($this->guard()->user());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
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