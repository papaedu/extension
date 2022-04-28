<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums;

enum SyncOtherMachine: int
{
    case SYNC = 1;// 把消息同步到 From_Account 在线终端和漫游上

    case OUT_OF_SYNC = 2;// 消息不同步至 From_Account
}
