<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Str;

class AES
{
    public static function encrypt128CBC(string $value, string $key, int $options = 0): string
    {
        $iv = Str::random();
        $value = openssl_encrypt($value, 'aes-128-cbc', $key, $options, $iv);
        $json = json_encode(compact('iv', 'value'), JSON_UNESCAPED_SLASHES);

        return base64_encode($json);
    }

    public static function decrypt128CBC(string $payload, string $key, int $options = 0): string
    {
        $payload = json_decode(base64_decode($payload), true);

        return openssl_decrypt($payload['value'], 'aes-128-cbc', $key, $options, $payload['iv']);
    }

    public static function encrypt256CBC(string $value, string $key, int $options = 0): string
    {
        $iv = Str::random();
        $value = openssl_encrypt($value, 'aes-256-cbc', $key, $options, $iv);
        $json = json_encode(compact('iv', 'value'), JSON_UNESCAPED_SLASHES);

        return base64_encode($json);
    }

    public static function decrypt256CBC(string $payload, string $key, int $options = 0): string
    {
        $payload = json_decode(base64_decode($payload), true);

        return openssl_decrypt($payload['value'], 'aes-256-cbc', $key, $options, $payload['iv']);
    }

    public static function encrypt128ECB(string $value, string $key, int $options = 0): string
    {
        return openssl_encrypt($value, 'aes-128-ecb', $key, $options);
    }

    public static function decrypt128ECB(string $payload, string $key, int $options): string
    {
        return openssl_decrypt($payload, 'aes-128-ecb', $key, $options);
    }

    public static function encrypt256ECB(string $value, string $key, int $options): string
    {
        return openssl_encrypt($value, 'aes-256-ecb', $key, $options);
    }

    public static function decrypt256ECB(string $payload, string $key, int $options): string
    {
        return openssl_decrypt($payload, 'aes-256-ecb', $key, $options);
    }
}
