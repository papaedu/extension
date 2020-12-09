<?php

namespace Papaedu\Extension\UmengPush\Notifications\IOS;

use Papaedu\Extension\UmengPush\Notifications\IOSNotification;

class IOSGroupcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'groupcast';
        $this->data['filter'] = null;
    }
}
