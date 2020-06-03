<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AppId extends Enum
{
    const PapaEdu = 1;

    const PapaIELTS = 2;

    const PapaTOFEL = 3;

    const PapaGMAT = 4;

    const PapaGRE = 5;

    const PapaTutor = 6;

    public static function getDescription($value): string
    {
        if ($value === self::PapaEdu) {
            return '趴趴英语';
        }
        if ($value === self::PapaIELTS) {
            return '趴趴英语雅思';
        }
        if ($value === self::PapaTOFEL) {
            return '趴趴英语托福';
        }
        if ($value === self::PapaGMAT) {
            return '趴趴英语GMAT';
        }
        if ($value === self::PapaGRE) {
            return '趴趴英语GRE';
        }
        if ($value === self::PapaTutor) {
            return '趴趴英语教师';
        }

        return parent::getDescription($value);
    }

    public static function transform(string $appName)
    {
        if ($appName === 'papaedu') {
            return self::PapaEdu;
        }
        if ($appName === 'papaielts') {
            return self::PapaIELTS;
        }
        if ($appName === 'papatofel') {
            return self::PapaTOFEL;
        }
        if ($appName === 'papagmat') {
            return self::PapaGMAT;
        }
        if ($appName === 'papagre') {
            return self::PapaGRE;
        }
        if ($appName === 'papatutor') {
            return self::PapaTutor;
        }

        return 0;
    }
}
