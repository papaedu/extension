<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Illuminate\Support\Str;

class VodAdapter
{
    public function url(string $path): string
    {
        if (! $path) {
            return '';
        }

        if (preg_match('~^(http|https)://~ixu', $path)) {
            return $path;
        }

        return Str::finish(config('tencent-cloud.vod.host', ''), '/').ltrim($path, '/');
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
