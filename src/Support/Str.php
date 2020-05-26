<?php

namespace Papaedu\Extension\Support;

class Str
{
    const RomanNumeral = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii', 'xiii'];

    /**
     * @param  string  $numeral
     * @return bool
     */
    public static function isRomanNumeral(string $numeral)
    {
        return in_array($numeral, self::RomanNumeral);
    }

    /**
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
}
