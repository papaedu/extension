<?php

namespace Papaedu\Extension\Support\Disks;

class Audio extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-audio';

    protected function getDomain()
    {
        return config('filesystems.disks.qiniu-audio.domains.https');
    }
}