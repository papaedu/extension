<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Papaedu\Extension\Enums\CaptchaChannel;
use Papaedu\Extension\Support\Phone;
use Papaedu\Extension\Support\Traits\Extension;

abstract class CaptchaController extends Controller
{
    use Extension;
    use CaptchaValidate;

    /**
     * @var string
     */
    protected string $ISOCode;

    /**
     * @var string
     */
    protected string $IDDCode;

    /**
     * @var string
     */
    protected string $phoneNumber;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $configName
     * @param  string  $captchaChannel
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function captcha(Request $request, string $configName, string $captchaChannel, string $type): JsonResponse
    {
        $captchaConfigName = $this->geeCaptchaConfigName();
        $this->validate($request, $captchaConfigName, $captchaChannel, $type);
        $this->initParams($request);
        $this->extraValidator($request, 'exists', trans('extension::auth.unregister'));

        $this->sendCaptcha();

        return $this->response->noContent();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function captchaByConfigName(Request $request, string $type): JsonResponse
    {
        $captchaConfigName = $this->geeCaptchaConfigName();
        $this->validate($request, $captchaConfigName, CaptchaChannel::GEETEST, $type);
        $this->initParams($request);
        $this->extraValidator($request, 'exists', trans('extension::auth.unregister'));

        $this->sendCaptcha();

        return $this->response->noContent();
    }

    protected function initParams(Request $request)
    {
        $this->ISOCode = $request->input('iso_code', config('extension.locale.iso_code'));
        $this->phoneNumber = $request->input($this->username());
        $this->IDDCode = (string)Phone::ISOCode2IDDCode($this->phoneNumber, $this->ISOCode);
    }

    protected function sendCaptcha()
    {
        $captcha = CaptchaValidator::generate($this->phoneNumber, $this->ISOCode);
        CaptchaNotification::send($this->phoneNumber, $this->IDDCode, $captcha);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getISOCode(Request $request): string
    {
        return $request->input('iso_code', '');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getPhoneNumber(Request $request): string
    {
        return $request->input($this->username());
    }

    /**
     * @param  string  $ISOCode
     * @param  string  $phoneNumber
     * @return int|null
     */
    public function getIDDCode(string $ISOCode, string $phoneNumber): ?int
    {
        return Phone::ISOCode2IDDCode($phoneNumber, $ISOCode);
    }

    /**
     * @return string
     */
    protected function geeCaptchaConfigName(): string
    {
        return '';
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
