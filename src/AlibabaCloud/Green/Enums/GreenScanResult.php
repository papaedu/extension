<?php

namespace Papaedu\Extension\AlibabaCloud\Green\Enums;

enum GreenScanResult: int
{
    case CHECKING = 0;

    case PASS = 1;

    case REVIEW = 2;

    case BLOCK = 3;
}
