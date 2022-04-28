<?php

namespace Papaedu\Extension\Filesystem;

use InvalidArgumentException;

class Disk
{
    private static array $disks = [];

    /**
     * @return \Papaedu\Extension\Filesystem\Image
     */
    public static function image()
    {
        return self::custom('qiniu-image', config('filesystems.disks.qiniu-image.domain'));
    }

    /**
     * @return \Papaedu\Extension\Filesystem\Audio
     */
    public static function audio()
    {
        return self::custom('qiniu-audio', config('filesystems.disks.qiniu-audio.domain'), 'audio');
    }

    /**
     * @return \Papaedu\Extension\Filesystem\File
     */
    public static function file()
    {
        return self::custom('qiniu-file', config('filesystems.disks.qiniu-file.domain'), 'file');
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

    /**
     * @param  string  $diskName
     * @param  string  $domain
     * @param  string  $type
     * @return mixed
     */
    public static function custom(string $diskName, string $domain, string $type = 'image')
    {
        if (! isset(self::$disks[$diskName])) {
            if ('image' === $type) {
                self::$disks[$diskName] = new Image($diskName, $domain);
            } elseif ('audio' === $type) {
                self::$disks[$diskName] = new Audio($diskName, $domain);
            } elseif ('file' === $type) {
                self::$disks[$diskName] = new File($diskName, $domain);
            } else {
                throw new InvalidArgumentException('Disk type is invalid.');
            }
        }

        return self::$disks[$diskName];
    }
}
