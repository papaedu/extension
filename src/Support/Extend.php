<?php

namespace Papaedu\Extension\Support;

class Extend
{
    const RomanNumeral = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii', 'xiii'];

    /**
     * 是否为罗马数字
     *
     * @param  string  $numeral
     * @return bool
     */
    public static function isRomanNumeral(string $numeral)
    {
        return in_array($numeral, self::RomanNumeral);
    }

    /**
     * 随机数字
     *
     * @param  int  $length
     * @return string
     */
    public static function randomNumeric($length = 8)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= mt_rand(0, 9);
        }

        return $random;
    }

    /**
     * 是否为手机号
     *
     * @param  string  $mobile
     * @return false|int
     */
    public static function isMobile(string $mobile)
    {
        return preg_match('/(1[3-9])\\d{9}/', $mobile);
    }

    /**
     * 密码强度
     *
     * @param  string  $password
     * @return false|int
     */
    public static function passwordStrength(string $password)
    {
        return preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z!@_#$%^&*()\-+=,.?]).{8,32}$/', $password);
    }
}
