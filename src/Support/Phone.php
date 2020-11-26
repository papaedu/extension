<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

class Phone
{
    /**
     * Validate auth request by global phone.
     *
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

    /**
     * Validate auth request with extra by global phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $rule
     * @param  string  $field
     * @param  string  $model
     * @param  string  $IDDCode
     * @param  string  $message
     * @param  string  $databaseField
     */
    public static function extraValidate(Request $request, string $rule, string $field, string $model, string $IDDCode, string $message, string $databaseField = '')
    {
        $databaseField = $databaseField ? $databaseField : $field;

        if (true === config('extension.enable_global_phone')) {
            $rules = [$field => Rule::$rule($model, $databaseField)->where('idd_code', $IDDCode)];
        } else {
            $rules = [$field => "{$rule}:{$model},{$databaseField}"];
        }

        $request->validate($rules, [
            "{$field}.{$rule}" => $message,
        ], [
            $field => trans('extension::field.username'),
        ]);
    }

    protected static function getRules(string $field, array $extraRules)
    {
        if (true === config('extension.enable_global_phone')) {
            $rules['iso_code'] = ['required_with:'.$field];
            $rules[$field] = ['required', 'phone:iso_code,mobile'];
        } else {
            $rules[$field] = ['required', 'phone:'.config('extension.locale.iso_code').',mobile'];
        }

        return $rules + $extraRules;
    }

    protected static function getAttributes(string $field, array $extraAttributes)
    {
        return $extraAttributes + ['iso_code' => trans('extension::field.iso_code'), $field => trans('extension::field.username')];
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