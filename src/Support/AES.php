<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Str;

class AES
{
    private const DEFAULT_KEY = 'p@pA3NgL!2HO12#4';

    private const MASKING_CIPHER_ALGO = 'AES-128-ECB';

    private const APP_CIPHER_ALGO = 'AES-256-CBC';

    private const JS_CIPHER_ALGO = 'AES-256-ECB';

    /**
     * App 端数据加密
     *
     * @throws \Exception
     */
    public static function encryptForApp(string $data, string $iv = '', string $key = ''): array
    {
        $iv = self::getIv($iv);
        $encrypted = openssl_encrypt($data, self::APP_CIPHER_ALGO, self::getKey($key), OPENSSL_RAW_DATA, $iv);
        if (false === $encrypted) {
            throw new \Exception('AES encrypt error.');
        }

        return [
            'data' => base64_encode($encrypted),
            'iv' => $iv,
        ];
    }

    /**
     * App 端数据加密
     *
     * @throws \Exception
     */
    public static function decryptForApp(string $data, string $iv, string $key = ''): string
    {
        $decrypted = openssl_decrypt(
            base64_decode($data),
            self::APP_CIPHER_ALGO,
            self::getKey($key),
            OPENSSL_RAW_DATA,
            self::getIv($iv)
        );
        if (false === $decrypted) {
            throw new \Exception('AES decrypt error.');
        }

        return $decrypted;
    }

    /**
     * JS 端数据加密
     *
     * @param  string  $data
     * @param  string  $key
     * @return string
     * @throws \Exception
     */
    public static function encryptForJS(string $data, string $key = ''): string
    {
        $encrypted = openssl_encrypt($data, self::JS_CIPHER_ALGO, self::getKey($key), OPENSSL_DONT_ZERO_PAD_KEY);
        if (false === $encrypted) {
            throw new \Exception('AES encrypt error.');
        }

        return base64_encode($encrypted);
    }

    /**
     * JS 端数据加密
     *
     * @param  string  $data
     * @param  string  $key
     * @return string
     * @throws \Exception
     */
    public static function decryptForJS(string $data, string $key = ''): string
    {
        $decrypted = openssl_decrypt(
            base64_decode($data),
            self::JS_CIPHER_ALGO,
            self::getKey($key),
            OPENSSL_DONT_ZERO_PAD_KEY
        );
        if (false === $decrypted) {
            throw new \Exception('AES decrypt error.');
        }

        return $decrypted;
    }

    /**
     * 数据脱敏
     *
     * @throws \Exception
     */
    public static function encryptMasking(string $data, string $key = ''): string
    {
        $encrypted = openssl_encrypt($data, self::MASKING_CIPHER_ALGO, self::getKey($key), OPENSSL_RAW_DATA);
        if (false === $encrypted) {
            throw new \Exception('AES encrypt error.');
        }

        return strtoupper(bin2hex($encrypted));
    }

    /**
     * 数据脱敏
     *
     * @throws \Exception
     */
    public static function decryptMasking(string $data, string $key = ''): string
    {
        $decrypted = openssl_decrypt(hex2bin($data), self::MASKING_CIPHER_ALGO, self::getKey($key), OPENSSL_RAW_DATA);
        if (false === $decrypted) {
            throw new \Exception('AES decrypt error.');
        }

        return $decrypted;
    }

    /**
     * @param  string  $data
     * @param  string  $cipherAlgo
     * @param  string  $key
     * @param  string  $iv
     * @param  int  $options
     * @return string
     * @throws \Exception
     */
    public static function encrypt(
        string $data,
        string $cipherAlgo,
        string $key,
        string $iv = '',
        int $options = OPENSSL_RAW_DATA
    ): string {
        $encrypted = openssl_encrypt($data, $cipherAlgo, $key, $options, substr($iv, 0, 16));
        if (false === $encrypted) {
            throw new \Exception('AES encrypt error.');
        }

        return base64_encode($encrypted);
    }

    /**
     * @param  string  $data
     * @param  string  $algo
     * @param  string  $key
     * @param  string  $iv
     * @param  int  $options
     * @return string
     * @throws \Exception
     */
    public static function decrypt(
        string $data,
        string $algo,
        string $key,
        string $iv = '',
        int $options = OPENSSL_RAW_DATA
    ): string {
        $decrypted = openssl_decrypt(base64_decode($data), $algo, $key, $options, substr($iv, 0, 16));
        if (false === $decrypted) {
            throw new \Exception('AES decrypt error.');
        }

        return $decrypted;
    }

    protected static function getKey(string $key): string
    {
        if ($key) {
            return $key;
        }

        if ($key = config('extension.aes.key')) {
            return $key;
        }

        return self::DEFAULT_KEY;
    }

    protected static function getIv(string $iv): string
    {
        if ($iv) {
            return substr($iv, 0, 16);
        }

        return Str::random();
    }
}
