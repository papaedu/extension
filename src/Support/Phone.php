<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class Phone
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $attributes
     */
    public static function validate(Request $request, string $field, array $rules, array $messages, array $attributes)
    {
        $request->validate(static::getRules($field, $rules), $messages, static::getAttributes($field, $attributes));
    }

    protected static function getRules(string $field, array $extraRules)
    {
        if (true === config('extension.enable_global_phone')) {
            $rules['iso_code'] = ['required_with:'.$field];
            $rules[$field] = ['required', 'phone:iso_code,mobile'];
        } else {
            $rules[$field] = ['required', 'phone:'.config('extension.locale.iso_code').',mobile'];
        }

        return array_merge($rules, $extraRules);
    }

    protected static function getAttributes(string $field, array $extraAttributes)
    {
        return array_merge([
            'iso_code' => trans('extension::field.iso_code'),
            $field => trans('extension::field.username'),
        ], $extraAttributes);
    }

    /**
     * Exchange ISO code to IDD code.
     *
     * @param  string  $phoneNumber
     * @param  string  $ISOCode
     * @return int|null
     */
    public static function ISOCode2IDDCode(string $phoneNumber, string $ISOCode)
    {
        $phoneNumber = PhoneNumber::make($phoneNumber, $ISOCode);

        return $phoneNumber->getPhoneNumberInstance()->getCountryCode();
    }
}