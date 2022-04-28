<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums;

enum DeleteType: string
{
    case SINGLE = 'Delete_Type_Single';// 单向删除好友

    case BOTH = 'Delete_Type_Both';// 双向删除好友
}
