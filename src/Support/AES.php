<?php

namespace Papaedu\Extension\Support;

class AES
{
    /**
     * @param  string  $data
     * @return string
     * @throws \Exception
     */
    public static function encrypt(string $data): string
    {
        $encrypted = openssl_encrypt($data, 'AES-128-ECB', 'papaEnglish', OPENSSL_RAW_DATA);
        if (false === $encrypted) {
            throw new \Exception('AES encrypt error.');
        }

        return strtoupper(bin2hex($encrypted));
    }

    /**
     * @param  string  $data
     * @return string
     * @throws \Exception
     */
    public static function decrypt(string $data): string
    {
        $decrypted = openssl_decrypt(hex2bin($data), 'AES-128-ECB', 'papaEnglish', OPENSSL_RAW_DATA);
        if (false === $decrypted) {
            throw new \Exception('AES decrypt error.');
        }

        return $decrypted;
    }
}
