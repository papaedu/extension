<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Papaedu\Extension\Filesystem\Core\ClientAbstract;

/**
 * @method \Papaedu\Extension\Filesystem\Tencent\VodAdapter vod()
 */
class Client extends ClientAbstract
{
    protected function newClass(string $class, string $disk)
    {
        return new $class($disk);
    }
}
