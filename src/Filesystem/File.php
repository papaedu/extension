<?php

namespace Papaedu\Extension\Filesystem;

class File extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-file';

    protected function getDomain()
    {
        return config('filesystems.disks.qiniu-file.domain');
    }
}