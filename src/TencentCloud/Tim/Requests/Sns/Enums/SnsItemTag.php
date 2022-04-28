<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums;

enum SnsItemTag: string
{
    case GROUP = 'Tag_SNS_IM_Group';// 好友分组

    case REMARK = 'Tag_SNS_IM_Remark';// 好友备注

    case ADD_SOURCE = 'Tag_SNS_IM_AddSource';// 加好友来源

    case ADD_WORDING = 'Tag_SNS_IM_AddWording';// 加好友附言
}
