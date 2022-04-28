<?php

namespace Papaedu\Extension\UmengPush\Notifications\IOS;

use Papaedu\Extension\UmengPush\Notifications\IOSNotification;
use Papaedu\Extension\UmengPush\Notifications\Traits\FileTrait;

class IOSFilecast extends IOSNotification
{
    use FileTrait;

    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'filecast';
        $this->data['file_id'] = null;
    }
}
