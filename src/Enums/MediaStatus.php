<?php

namespace Papaedu\Extension\Enums;

enum MediaStatus: int
{
    case GENERATED = 1;

    case UPLOADED = 2;

    case USED = 3;
}
