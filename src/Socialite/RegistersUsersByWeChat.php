<?php

namespace Papaedu\Extension\Socialite;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Auth\AuthTrait;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\Phone;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait RegistersUsersByWeChat
{
    use AuthTrait;

    /**
     * @var string
     */
    protected $IDDCode = '';

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $weChatPlatform
     * @param  string  $weChatChannel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException
     */
    public function register(Request $request, string $weChatPlatform, string $weChatChannel)
    {
        if (!$request->has(['iv', 'encrypted_data'])) {
            throw new HttpException(400, trans('extension::status_message.400.default'));
        }

        if ($user = $this->attemptRegister($request, $weChatPlatform, $weChatChannel)) {
            return $this->sendRegisterResponse($request, $user);
        }

        $this->sendFailedRegisterResponse();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $weChatPlatform
     * @param  string  $weChatChannel
     * @return mixed
     * @throws \Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException
     */
    protected function attemptRegister(Request $request, string $weChatPlatform, string $weChatChannel)
    {
        $application = SocialiteApplication::wechat($weChatPlatform, $weChatChannel);
        $application->loadOauthUserBySession();

        $data = $application->decryptData($request->iv, $request->encrypted_data);
        $this->IDDCode = Phone::ISOCode2IDDCode($data['purePhoneNumber'], $data['countryCode']);

        $data = [
            'idd_code' => $this->IDDCode,
            'iso_code' => $data['countryCode'],
            $this->username() => $data['purePhoneNumber'],
            'gender' => $request->gender,
            'location_id' => $request->location_id,
        ];
        if ($this->validateAlreadyRegister($data)) {
            event(new Registered($user = $this->create($data)));

            $this->guard()->login($user);

            return $user;
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendRegisterResponse(Request $request, $user)
    {
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
