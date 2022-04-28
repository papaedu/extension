<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums;

enum ApplyJoinOption: string
{
    case FREE_ACCESS = 'FreeAccess';// 自由加入

    case NEED_PERMISSION = 'NeedPermission';// 需要验证

    case DISABLE_APPLY = 'DisableApply';// 禁止加入
}
