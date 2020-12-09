<?php

namespace Papaedu\Extension\UmengPush\Notifications\IOS;

use Papaedu\Extension\UmengPush\Notifications\IOSNotification;

class IOSBroadcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'broadcast';
    }
}
