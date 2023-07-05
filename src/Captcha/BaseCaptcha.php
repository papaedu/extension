<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\Client\GeetestClient;
use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Support\Phone;

trait BaseCaptcha
{
    public function captcha(Request $request, string $type): JsonResponse
    {
        $this->validateCaptcha($request);

//        app(GeetestClient::class)->validateSenseBot(
//            $request->header(Header::APP_NAME->value, ''),
//            $request->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'),
//            $type
//        );

        $this->sendCaptcha($request);

        return new JsonResponse('', 204);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    protected function sendCaptcha(Request $request): void
    {
        $isoCode = $request->input('iso_code', config('extension.locale.iso_code'));
        $phoneNumber = $request->input($this->username());
        $iddCode = (string) Phone::getCountryCode($phoneNumber, $isoCode);

        $captcha = app(CaptchaValidator::class)->generate($phoneNumber, $isoCode);
        CaptchaSender::send($phoneNumber, $iddCode, $captcha);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username(): string
    {
        return 'username';
    }

    /**
     * Get the guard model to be used.
     *
     * @return string
     */
    protected function userModel(): string
    {
        return 'App\User';
    }
}
