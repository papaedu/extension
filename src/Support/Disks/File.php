<?php

namespace Papaedu\Extension\Support\Disks;

class File extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-file';

    protected function getDomain()
    {
        return config('filesystems.disks.qiniu-file.domains.https');
    }
}