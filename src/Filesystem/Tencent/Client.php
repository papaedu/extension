<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Papaedu\Extension\Filesystem\Core\ClientAbstract;

/**
 * @method \Papaedu\Extension\Filesystem\Tencent\ImageAdapter image()
 * @method \Papaedu\Extension\Filesystem\Tencent\AudioAdapter audio()
 * @method \Papaedu\Extension\Filesystem\Tencent\VideoAdapter video()
 * @method \Papaedu\Extension\Filesystem\Tencent\FileAdapter file()
 * @method \Papaedu\Extension\Filesystem\Tencent\VodAdapter vod()
 */
class Client extends ClientAbstract
{
    protected function newClass(string $class, string $disk)
    {
        $bucket = config("tencent-cloud.cos.{$disk}.bucket");
        $region = config("tencent-cloud.cos.{$disk}.region");
        $domain = config("tencent-cloud.cos.{$disk}.domain");

        return new $class($bucket, $region, $domain);
    }
}
