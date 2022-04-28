<?php

namespace Papaedu\Extension\UmengPush\Notifications\Android;

use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;

class AndroidListcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'listcast';
        $this->data['device_tokens'] = null;
    }
}
