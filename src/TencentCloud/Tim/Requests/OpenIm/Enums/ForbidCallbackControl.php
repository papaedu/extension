<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums;

enum ForbidCallbackControl: string
{
    case BEFORE = 'ForbidBeforeSendMsgCallback';// 禁止发消息前回调

    case AFTER = 'ForbidAfterSendMsgCallback';// 禁止发消息后回调
}
