<?php

namespace Papaedu\Extension\Validation\Rules;

use Papaedu\Extension\Captcha\CaptchaValidator;

class Captcha
{
    /**
     * Validate captcha with IDD code and username.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @param  object  $validator
     * @return bool
     */
    public function validate($attribute, $value, array $parameters, $validator): bool
    {
        $data = $validator->getData();

        if (!$username = $data[$parameters[0]] ?? '') {
            return false;
        }

        return CaptchaValidator::validate($username, $data['iso_code'] ?? '', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute错误';
    }
}
