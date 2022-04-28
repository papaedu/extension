<?php

namespace Papaedu\Extension\Filesystem;

use Illuminate\Support\Str;

class Vod extends DiskAbstract
{
    /**
     * 获取完整地址
     *
     * @param  string  $path
     * @param  string  $default
     * @return string
     */
    public function url(string $path, string $default = ''): string
    {
        $path = $path ?: $default;
        if (! $path) {
            return '';
        }

        if (preg_match('/^http[s]?:\/\//', $path)) {
            return $path;
        }

        return Str::finish(config('tencent-cloud.vod.host', ''), '/').ltrim($path, '/');
    }
}
