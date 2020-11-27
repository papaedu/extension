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
        $request->validate(
            static::getValidateRules($field, $rules),
            $messages,
            static::getValidateAttributes($field, $attributes)
        );
    }

    /**
     * Validate auth request with extra by global phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $validation
     * @param  string  $field
     * @param  string  $model
     * @param  string  $IDDCode
     * @param  string  $ignoreId
     * @param  string  $message
     * @param  string  $databaseField
     */
    public static function extraValidate(Request $request, string $validation, string $field, string $model, string $IDDCode, string $message = '', string $ignoreId = '', string $databaseField = '')
    {
        if ($message) {
            $messages = ["{$field}.{$validation}" => $message];
        } else {
            $messages = [];
        }

        $request->validate(
            static::getExtraValidateRules($validation, $field, $model, $IDDCode, $ignoreId, $databaseField),
            $messages,
            [$field => trans('extension::field.username')]
        );
    }

    /**
     * Get validate rules.
     *
     * @param  string  $field
     * @param  array  $extraRules
     * @return array
     */
    protected static function getValidateRules(string $field, array $extraRules)
    {
        if (true === config('extension.enable_global_phone')) {
            $rules['iso_code'] = ['required_with:'.$field];
            $rules[$field] = ['required', 'phone:iso_code,mobile'];
        } else {
            $rules[$field] = ['required', 'phone:'.config('extension.locale.iso_code').',mobile'];
        }

        return $rules + $extraRules;
    }

    /**
     * Get extra validate rules.
     *
     * @param  string  $validation
     * @param  string  $field
     * @param  string  $model
     * @param  string  $IDDCode
     * @param  string  $ignoreId
     * @param  string  $databaseField
     * @return array
     */
    protected static function getExtraValidateRules(string $validation, string $field, string $model, string $IDDCode, string $ignoreId = '', string $databaseField = '')
    {
        $databaseField = $databaseField ? $databaseField : $field;

        $rule = Rule::$validation($model, $databaseField);
        if (true === config('extension.enable_global_phone')) {
            $rule->where('idd_code', $IDDCode);
        }
        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }

        return [$field => $rule];
    }

    /**
     * Get validate attributes.
     *
     * @param  string  $field
     * @param  array  $extraAttributes
     * @return array
     */
    protected static function getValidateAttributes(string $field, array $extraAttributes)
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