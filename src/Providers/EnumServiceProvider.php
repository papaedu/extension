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
        Enum::macro('toKeyValue', function ($removeNone = false) {
            $keyValue = [];
            $array = self::toSelectArray();
            if ($removeNone) {
                unset($array[0]);
            }

            foreach ($array as $key => $value) {
                $keyValue[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }

            return $keyValue;
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
