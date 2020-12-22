<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Facades\Geetest;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait RegistersUsersByOnelogin
{
    use AuthTrait;

    /**
     * @var string
     */
    protected $IDDCode = '';

    /**
     * Handle a registration request for the application.
     *
     * @param  string  $appName
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(string $appName, Request $request)
    {
        $this->validateRegister($request);

        if ($user = $this->attemptRegister($appName, $request)) {
            return $this->sendRegisterResponse($request, $user);
        }

        $this->sendFailedRegisterResponse();
    }

    /**
     * Validate the guest register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRegister(Request $request)
    {
        $request->validate([
            'process_id' => ['required'],
            'token' => ['required'],
        ], [
            'required' => trans('extension::auth.onelogin_failed'),
        ]);
    }

    /**
     * @param  string  $appName
     * @param  \Illuminate\Http\Request  $request
     * @return null
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function attemptRegister(string $appName, Request $request)
    {
        $username = Geetest::config($appName)
            ->oneLoginCheckPhone(
                $request->input('process_id', ''),
                $request->input('auth_code', ''),
                $request->input('token', '')
            );

        if (!$username) {
            return null;
        }

        $data = [
            'idd_code' => config('extension.locale.idd_code'),
            'iso_code' => config('extension.locale.iso_code'),
            $this->username() => $username,
        ];
        if ($this->validateAlreadyRegister($data)) {
            event(new Registered(
                $user = $this->create($data)
            ));

            $this->guard()->login($user);

            return $user;
        }

        throw new HttpException(400, trans('extension::auth.registered', trans('extension::field.username')));
    }

    /**
     * @param  array  $data
     */
    public function validateAlreadyRegister(array $data)
    {
    }

    /**
     * Send the response after the user was registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    protected function sendRegisterResponse(Request $request, $user)
    {
        CaptchaValidator::clear(
            $request->input('idd_code', config('extension.locale.idd_code')),
            $request->input($this->username())
        );

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $this->tokenResponse($user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedRegisterResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('extension::auth.onelogin_failed')],
        ]);
    }

    /**
     * Get the guard model to be used.
     *
     * @return string
     */
    public function userModel()
    {
        return 'App\User';
    }
}
