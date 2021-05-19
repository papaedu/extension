<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\CaptchaValidator;

trait BaseForgetsPasswords
{
    use AuthTrait;

    /**
     * @var int|null
     */
    protected ?int $IDDCode = null;

    /**
     * Handle a forgot password request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(Request $request): JsonResponse
    {
        $this->validateForgot($request);

        event(new PasswordReset(
            $user = $this->update(
                $this->extraParams($request) + $request->only($this->username(), 'password')
            )
        ));

        $user->tokens()->delete();

        $this->guard()->login($user);

        return $this->sendForgotResponse($request);
    }

    /**
     * Send the response after the guest was forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendForgotResponse(Request $request): JsonResponse
    {
        CaptchaValidator::clean(
            $request->input($this->username()),
            $request->input('iso_code', config('extension.locale.iso_code'))
        );

        $this->validateStatus($this->guard()->user());

        if ($response = $this->beforeForgotResponse($request, $this->guard()->user())) {
            return $response;
        }

        return $this->tokenResponse($this->guard()->user());
    }

    /**
     * The user has been forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function beforeForgotResponse(Request $request, $user)
    {
    }

    /**
     * Get the guard model to be used.
     *
     * @return string
     */
    public function userModel(): string
    {
        return 'App\User';
    }
}
