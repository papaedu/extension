<?php

namespace Papaedu\Extension\UmengPush\Notifications\Android;

use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;

class AndroidGroupcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'groupcast';
        $this->data['filter'] = null;
    }
}
