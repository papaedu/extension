<?php

namespace Papaedu\Extension\UmengPush\Notifications\IOS;

use Papaedu\Extension\UmengPush\Notifications\IOSNotification;

class IOSUnicast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'unicast';
        $this->data['device_tokens'] = null;
    }
}
