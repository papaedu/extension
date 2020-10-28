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
        $path = self::getTestPathPrefix() . date('Y/m/d/');
        if ($prefix) {
            return $path . trim($prefix, '/');
        }

        return trim($path, '/');
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