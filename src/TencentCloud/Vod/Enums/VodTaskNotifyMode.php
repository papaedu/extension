<?php

namespace Papaedu\Extension\TencentCloud\Vod\Enums;

enum VodTaskNotifyMode: string
{
    case FINISH = 'Finish';

    case CHANGE = 'Change';

    case NONE = 'None';
}
