<?php

namespace Papaedu\Extension\Channels\EasySms;

use Overtrue\EasySms\Message;

class EasySmsMessage extends Message
{
    public static function create()
    {
        return new static();
    }
}
