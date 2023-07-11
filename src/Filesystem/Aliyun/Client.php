<?php

namespace Papaedu\Extension\Filesystem\Aliyun;

use Papaedu\Extension\Filesystem\Core\ClientAbstract;

/**
 * @method \Papaedu\Extension\Filesystem\Aliyun\ImageAdapter image()
 * @method \Papaedu\Extension\Filesystem\Aliyun\AudioAdapter audio()
 * @method \Papaedu\Extension\Filesystem\Aliyun\VideoAdapter video()
 * @method \Papaedu\Extension\Filesystem\Aliyun\FileAdapter file()
 */
class Client extends ClientAbstract
{
    protected function newClass(string $class, string $disk)
    {
        return new $class("oss-{$disk}");
    }
}
