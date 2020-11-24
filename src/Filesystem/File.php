<?php

namespace Papaedu\Extension\Filesystem;

class File extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-file';

    public function __construct()
    {
        $this->setDomain(config('filesystems.disks.qiniu-file.domain'));
    }
}