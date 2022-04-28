<?php

namespace Papaedu\Extension\UmengPush\Notifications\Android;

use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;
use Papaedu\Extension\UmengPush\Notifications\Traits\FileTrait;

class AndroidFilecast extends AndroidNotification
{
    use FileTrait;

    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'filecast';
        $this->data['file_id'] = null;
    }
}
