<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Str;

class Extend
{
    private const ROMAN_NUMERAL = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii', 'xiii'];

    public static function replacements($line, array $replace): string
    {
        if (empty($replace)) {
            return $line;
        }

        $shouldReplace = [];
        foreach ($replace as $key => $value) {
            $shouldReplace[':'.($key ?? '')] = $value;
        }

        return strstr($line, $shouldReplace);
    }

    /**
     * 是否为罗马数字
     *
     * @param  string  $numeral
     * @return bool
     */
    public static function isRomanNumeral(string $numeral): bool
    {
        return in_array($numeral, self::ROMAN_NUMERAL);
    }

    /**
     * 随机数字
     *
     * @param  int  $length
     * @return int
     */
    public static function randomNumeric(int $length = 6): int
    {
        $str = mt_rand(1, 9);
        for ($i = 1; $i < $length; $i++) {
            $str .= mt_rand(0, 9);
        }

        return intval($str);
    }

    /**
     * 计算2个经纬度之间的距离
     *
     * @param  float  $lat1
     * @param  float  $lng1
     * @param  float  $lat2
     * @param  float  $lng2
     * @return float
     */
    public static function getDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;
        $r = 6378.137;
        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $r * $c;
    }

    /**
     * 生成订单号
     *
     * @param  int  $length
     * @return string
     */
    public static function generateOrderSn(int $length = 18): string
    {
        $orderSn = now()->format('ymdHis').substr((string) now()->micro, -3);

        return $orderSn.self::randomNumeric($length - strlen($orderSn));
    }

    /**
     * 生成支付交易号
     *
     * @param  int  $length
     * @return string
     */
    public static function generateOutTradeNo(int $length = 28): string
    {
        $outTradeNo = now()->format('YmdHis').now()->micro;

        return $outTradeNo.self::randomNumeric($length - strlen($outTradeNo));
    }

    /**
     * 获取 web 页面地址
     *
     * @param  string  $path
     * @return string
     */
    public static function webUrl(string $path): string
    {
        return Str::finish(config('extension.web_url'), '/').ltrim($path, '/');
    }

    /**
     * 获取 wap 页面地址
     *
     * @param  string  $path
     * @return string
     */
    public static function wapUrl(string $path): string
    {
        return Str::finish(config('extension.wap_url'), '/').ltrim($path, '/');
    }
}
