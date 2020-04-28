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
        Enum::macro('toFormatArray', function ($removeNone = false) {
            $array = self::toArray();
            $formatArray = [];

            if ($removeNone) {
                unset($array['None']);
            }

            foreach ($array as $value) {
                $formatArray[] = [
                    'key' => $value,
                    'value' => self::getDescription($value),
                ];
            }

            return $formatArray;
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
