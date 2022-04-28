<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Profile\Enums;

final class AllowType
{
    public const NEED_CONFIRM = 'AllowType_Type_NeedConfirm';// 需要经过自己确认对方才能添加自己为好友

    public const ALLOW_ANY = 'AllowType_Type_AllowAny';// 允许任何人添加自己为好友

    public const DENT_ANY = 'AllowType_Type_DenyAny';// 不允许任何人添加自己为好友
}
