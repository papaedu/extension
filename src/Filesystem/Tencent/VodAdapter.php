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
}
