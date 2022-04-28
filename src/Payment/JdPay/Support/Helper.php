<?php

namespace Papaedu\Extension\Payment\JdPay\Support;

class Helper
{
    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string  $str  The input string
     * @return string camelCased output string
     */
    public static function camelCase($str)
    {
        $str = self::convertToLowercase($str);

        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $str
        );
    }

    /**
     * Convert strings with underscores to be all lowercase before camelCase is preformed.
     *
     * @param  string  $str  The input string
     * @return string The output string
     */
    protected static function convertToLowercase(string $str): string
    {
        $explodedStr = explode('_', $str);
        $lowercaseStr = [];

        if (count($explodedStr) > 1) {
            foreach ($explodedStr as $value) {
                $lowercaseStr[] = strtolower($value);
            }
            $str = implode('_', $lowercaseStr);
        }

        return $str;
    }

    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param  mixed  $target  The object to set parameters on
     * @param  array  $parameters  An array of parameters to set
     */
    public static function initialize($target, array $parameters = [])
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set'.ucfirst(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }

    public static function str2bytes($str): array
    {
        $bytes = [];
        for ($i = 0; $i < strlen($str); $i++) {
            $bytes[] = ord($str[$i]);
        }

        return $bytes;
    }

    public static function int2bytes($int): array
    {
        $bytes = [];
        $bytes [0] = ($int >> 24 & 0xff);
        $bytes [1] = ($int >> 16 & 0xff);
        $bytes [2] = ($int >> 8 & 0xff);
        $bytes [3] = ($int & 0xff);

        return $bytes;
    }

    public static function bytes2str($bytes): string
    {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }

        return $str;
    }

    public static function str2hex($str): string
    {
        $hex = "";
        for ($i = 0; $i < strlen($str); $i++) {
            $tmp = dechex(ord($str[$i]));
            if (strlen($tmp) == 1) {
                $hex .= "0";
            }
            $hex .= $tmp;
        }

        return strtolower($hex);
    }

    public static function hex2bytes($hex): array
    {
        $bytes = [];
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $bytes [$i / 2] = hexdec($hex[$i].$hex[$i + 1]) & 0xff;
        }

        return $bytes;
    }

    public static function byteArray2int($bytes, $offset): int
    {
        $value = 0;
        for ($i = 0; $i < 4; $i++) {
            $shift = (4 - 1 - $i) * 8;
            $value = $value + ($bytes[$i + $offset] & 0x000000FF) << $shift; // 往高位游
        }

        return $value;
    }

    public static function hex2bin($hex): string
    {
        $n = strlen($hex);
        $sbin = "";
        $i = 0;
        while ($i < $n) {
            $a = substr($hex, $i, 2);
            $c = pack("H*", $a);
            if ($i == 0) {
                $sbin = $c;
            } else {
                $sbin .= $c;
            }
            $i += 2;
        }

        return $sbin;
    }

    public static function bytes2hex($bytes): string
    {
        $str = self::bytes2str($bytes);

        return self::str2hex($str);
    }
}
