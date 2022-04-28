<?php

namespace Papaedu\Extension\UmengPush\Notifications\Android;

use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;

class AndroidBroadcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'broadcast';
    }
}
