<?php

namespace Papaedu\Extension\Providers;

use BenSampo\Enum\Enum;
use Illuminate\Support\ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Enum::macro('toEnumArray', function ($removeNone = true) {
            $array = self::toArray();
            $enumArray = [];

            if ($removeNone) {
                unset($array['None']);
            }

            foreach ($array as $value) {
                $enumArray[] = [
                    'key' => $value,
                    'value' => self::getDescription($value),
                ];
            }

            return $enumArray;
        });

        Enum::macro('toEnumValueArray', function ($removeNone = true) {
            $array = self::toArray();
            $enumArray = [];

            if ($removeNone) {
                unset($array['None']);
            }

            foreach ($array as $value) {
                $enumArray[] = [
                    'key' => self::getDescription($value),
                    'value' => self::getDescription($value),
                ];
            }

            return $enumArray;
        });

        Enum::macro('getKeyValue', function ($enumValue) {
            $enum = self::getInstance($enumValue);

            return [
                'key' => $enum->value,
                'value' => $enum->description,
            ];
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
