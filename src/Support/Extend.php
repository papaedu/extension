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
     * @return false|string
     */
    public static function randomNumeric($length = 6)
    {
        $str = '1234567890';
        $rand_str = str_shuffle($str);

        return substr($rand_str, 0, $length);
    }

    /**
     * 生成订单号
     *
     * @param  int  $length
     * @return string
     */
    public static function generateOrderSn(int $length = 18)
    {
        $now = now();

        return $now->format('ymdHis').substr($now->micro, -3).self::randomNumeric($length - 15);
    }

    /**
     * 是否为手机号
     *
     * @param  string  $mobile
     * @return false|int
     */
    public static function isMobile(string $mobile)
    {
        return preg_match('/^(1[3-9])\\d{9}$/', $mobile);
    }

    /**
     * 密码强度
     *
     * @param  string  $password
     * @return false|int
     */
    public static function passwordStrength(string $password)
    {
        return preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z!@_#$%^&*()\-+=,.?]).{8,16}$/', $password);
    }
}
