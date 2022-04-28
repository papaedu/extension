<?php

namespace Papaedu\Extension\Payment\JdPay\Support;

class TDES
{
    public function encrypt2Hex($string, $key): string
    {
        $bytes = Helper::str2bytes($string);
        $count = count($bytes);

        $x = ($count + 4) % 8;
        $y = (0 == $x) ? 0 : (8 - $x);

        $sizeBytes = Helper::int2bytes($count);
        $result = [];
        for ($i = 0; $i < 4; $i++) {
            $result[$i] = $sizeBytes[$i];
        }
        for ($j = 0; $j < $count; $j++) {
            $result[4 + $j] = $bytes[$j];
        }
        for ($k = 0; $k < $y; $k++) {
            $result[$count + 4 + $k] = 0x00;
        }

        $tdes = $this->encrypt(Helper::bytes2str($result), $key);

        return Helper::str2hex($tdes);
    }

    public function encrypt($input, $key)
    {
        $encrypted = openssl_encrypt($input, 'des-ede3', $key);

        return base64_decode($encrypted);
    }

    public function decrypt2Hex($hex, $key)
    {
        $bytes = Helper::hex2bytes($hex);
        $tdes = $this->decrypt(Helper::bytes2str($bytes), $key);

        $tdesBytes = Helper::str2bytes($tdes);
        $resultBytes = [];
        for ($i = 0; $i < 4; $i++) {
            $resultBytes[$i] = $tdesBytes[$i];
        }

        $dsb = Helper::byteArray2int($resultBytes, 0);
        $result = [];
        for ($j = 0; $j < $dsb; $j++) {
            $result[$j] = $tdesBytes[4 + $j];
        }

        return Helper::hex2bin(Helper::bytes2hex($result));
    }

    public function decrypt($encrypted, $key)
    {
        return openssl_decrypt($encrypted, 'des-ede3', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
    }
}
