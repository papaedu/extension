<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums;

final class ForbidCallbackControl
{
    public const BEFORE = 'ForbidBeforeSendMsgCallback';// 禁止发消息前回调

    public const AFTER = 'ForbidAfterSendMsgCallback';// 禁止发消息后回调
}
