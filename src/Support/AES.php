<?php

namespace Papaedu\Extension\Support;

class AES
{
    /**
     * @param  string  $data
     * @param  string  $algo
     * @param  string  $key
     * @param  string  $iv
     * @param  int  $options
     * @return string
     * @throws \Exception
     */
    public static function encrypt(
        string $data,
        string $algo,
        string $key,
        string $iv = '',
        int $options = OPENSSL_RAW_DATA
    ): string {
        $encrypted = openssl_encrypt($data, $algo, $key, $options, substr($iv, 0, 16));
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
}
