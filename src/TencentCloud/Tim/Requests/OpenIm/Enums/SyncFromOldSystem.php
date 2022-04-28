<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums;

enum SyncFromOldSystem: int
{
    case REAL_TIME_MESSAGE = 1;// 实时消息导入，消息加入未读计数

    case HISTORY_MESSAGE = 2;// 历史消息导入，消息不计入未读
}
