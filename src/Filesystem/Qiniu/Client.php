<?php

namespace Papaedu\Extension\Filesystem\Qiniu;

use Papaedu\Extension\Filesystem\Core\ClientAbstract;

/**
 * @method \Papaedu\Extension\Filesystem\Qiniu\ImageAdapter image()
 * @method \Papaedu\Extension\Filesystem\Qiniu\AudioAdapter audio()
 * @method \Papaedu\Extension\Filesystem\Qiniu\FileAdapter file()
 */
class Client extends ClientAbstract
{
    protected function newClass(string $class, string $disk)
    {
        return new $class("qiniu-{$disk}", config("filesystems.disks.qiniu-{$disk}.domain"));
    }

    /**
     * @return mixed|\Papaedu\Extension\Filesystem\Vod
     */
    public static function vod()
    {
        if (! isset(self::$disks['vod'])) {
            self::$disks['vod'] = new Vod('', config('tencent-cloud.vod.host', ''));
        }

        return self::$disks['vod'];
    }
}
