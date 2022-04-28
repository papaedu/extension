<?php

namespace Papaedu\Extension\UmengPush\Notifications\Android;

use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;

class AndroidUnicast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'unicast';
        $this->data['device_tokens'] = null;
    }
}
