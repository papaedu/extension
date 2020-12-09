<?php

namespace Papaedu\Extension\UmengPush\Notifications\IOS;

use Papaedu\Extension\Http\Exceptions\UmengNotificationException;
use Papaedu\Extension\UmengPush\Notifications\IOSNotification;
use Papaedu\Extension\UmengPush\Notifications\Traits\FileTrait;

class IOSCustomizedcast extends IOSNotification
{
    use FileTrait;

    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'customizedcast';
        $this->data['alias_type'] = null;
    }

    /**
     * @return bool|void
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function isComplete()
    {
        parent::isComplete();
        if (!isset($this->data['alias']) && !isset($this->data['file_id'])) {
            throw new UmengNotificationException('You need to set alias or upload file for customizedcast!');
        }
    }
}
