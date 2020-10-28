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
     * @return mixed
     */
    public static function getPathPrefix()
    {
        return self::getTestPathPrefix() . date('Y/m/d/');
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