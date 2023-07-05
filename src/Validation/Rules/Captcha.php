<?php

namespace Papaedu\Extension\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Papaedu\Extension\Captcha\CaptchaValidator;

class Captcha implements Rule
{
    public function passes($attribute, $value): bool
    {
        $data = $validator->getData();

        if (! $username = $data[$parameters[0]] ?? '') {
            return false;
        }

        return app(CaptchaValidator::class)->validate($username, $data['iso_code'] ?? '', $value);
    }

    public function message(): string
    {
        return ':attribute错误';
    }
}
