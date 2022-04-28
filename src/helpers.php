<?php

use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Enums\Platform;

if (! function_exists('app_name')) {
    function app_name(string $default = ''): string
    {
        return app('request')->header(Header::APP_NAME->value, $default);
    }
}

if (! function_exists('platform')) {
    function platform(?Platform $platform = null): Platform|bool
    {
        $headerPlatform = Platform::getTransform(app('request')->header(Header::PLATFORM->value, ''));
        if (is_null($platform)) {
            return $headerPlatform;
        }

        return $headerPlatform == $platform->value;
    }
}
