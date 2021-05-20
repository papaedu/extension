<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\CaptchaValidator;

trait BaseResetsUsernames
{
    use AuthTrait;

    /**
     * @var int|null
     */
    protected ?int $IDDCode = null;

    /**
     * Handle a reset mobile request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {
        $this->validateReset($request);

        $user = $this->update(
            $this->guard()->user(),
            ['idd_code' => $this->IDDCode] + $request->only('iso_code', 'new_username')
        );

        $user->tokens()->delete();

        return $this->sendResetResponse($request, $user);
    }

    /**
     * Send the response after the guest was reset mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $user): JsonResponse
    {
        CaptchaValidator::clean(
            $request->new_username,
            $request->input('iso_code', config('extension.locale.iso_code'))
        );

        if ($response = $this->beforeResetResponse($request, $user)) {
            return $response;
        }

        return new JsonResponse([], 204);
    }

    /**
     * The user has been reset mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function beforeResetResponse(Request $request, $user)
    {
        //
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
