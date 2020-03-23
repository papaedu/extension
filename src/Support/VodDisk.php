<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Arr;

class VodDisk extends DiskAbstract
{
    /**
     * Get complete vod url.
     *
     * @param  string  $path
     * @return string
     */
    public static function get(string $path)
    {
        if (!$path) {
            return '';
        }

        $scheme = Arr::first(explode(':', $path));
        if (in_array($scheme, ['http', 'https'])) {
            return $path;
        }

        return Str::finish(config('qcloud.vod.host', ''), '/') . self::filterPath($path);
    }

    /**
     * Filter host in vod url.
     *
     * @param  string  $path
     * @return string
     */
    public static function filterVod(string $path)
    {
        if (!$path) {
            return '';
        }

        $path = str_replace(config('qcloud.vod.host', ''), '', $path);

        return trim($path, '/');
    }
}