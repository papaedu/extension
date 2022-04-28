<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums;

enum AddType: string
{
    case SINGLE = 'Add_Type_Single';// 表示单向加好友

    case BOTH = 'Add_Type_Both';// 表示双向加好友
}
