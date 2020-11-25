<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Arr;

class GlobalPhone
{
    /**
     * @param  string  $usernameFiled
     * @param  array  $rules
     * @param  array  $additions
     * @return array
     */
    public static function getValidator(string $usernameFiled, array $rules, array $additions = [])
    {
        if (true === config('extension.enable_global_phone')) {
            $rules[$usernameFiled] = ['required', 'phone:idd_code,AUTO,'.config('extension.locale.iso_code').',mobile'];
            $rules = Arr::prepend($rules, 'required_with:'.$usernameFiled, 'idd_code');

            if ($additions) {
                foreach ($additions as $field => $value) {
                    if (!is_array($value)) {
                        $value = [$value];
                    }

                    if (isset($rules[$field])) {
                        $rules[$field] = array_merge($rules[$field], $value);
                    } else {
                        $rules[$field] = $value;
                    }
                }
            }
        }

        return $rules;
    }
}