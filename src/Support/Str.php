<?php

namespace Papaedu\Extension\Support;

class Str
{
    const RomanNumeral = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x'];

    public static function isRomanNumeral(string $numeral)
    {
        return in_array($numeral, self::RomanNumeral);
    }
}
