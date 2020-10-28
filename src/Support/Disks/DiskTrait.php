<?php

namespace Papaedu\Extension\Support\Disks;

use Illuminate\Support\Str;

trait DiskTrait
{
    /**
     * @return string
     */
    public static function getTestPathPrefix()
    {
        return app()->environment('production') ? '' : 'test/';
    }

    /**
     * @param  string  $prefix
     * @return string
     */
    public static function getPathPrefix(string $prefix = '')
    {
        return self::getTestPathPrefix() . Str::finish(date('Y/m/d/' . $prefix), '/');
    }

    /**
     * @param  string  $ext
     * @return string
     */
    public static function getFilename(string $ext)
    {
        $filename = Str::random(32);

        return "{$filename}.$ext";
    }
}