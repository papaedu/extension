<?php

namespace Papaedu\Extension\Support\Disks;

use Illuminate\Support\Str;

trait DiskHelpers
{
    /**
     * @return string
     */
    public static function getTestPathPrefix()
    {
        return app()->environment('production') ? '' : 'test/';
    }

    /**
     * @param  string  $module
     * @return mixed
     */
    public static function getPathPrefix(string $module)
    {
        return self::getTestPathPrefix() . Str::finish($module, '/');
    }

    /**
     * @param  string  $ext
     * @return string
     */
    public static function getFilename(string $ext)
    {
        $filename = Str::random(40);

        return "{$filename}.$ext";
    }
}