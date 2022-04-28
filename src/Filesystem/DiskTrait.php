<?php

namespace Papaedu\Extension\Filesystem;

use Illuminate\Support\Str;

trait DiskTrait
{
    /**
     * @return string
     */
    public static function getPrePathPrefix(): string
    {
        return app()->environment('production') ? '' : 'test/';
    }

    /**
     * @param  string  $prefix
     * @return string
     */
    public static function getPathPrefix(string $prefix = ''): string
    {
        $path = self::getPrePathPrefix().date('Y/m/d/');
        if (empty($prefix)) {
            return trim($path, '/');
        }

        return $path.trim($prefix, '/');
    }

    /**
     * @param  string  $ext
     * @return string
     */
    public static function getFilename(string $ext): string
    {
        $filename = Str::random(40);

        return "{$filename}.$ext";
    }
}
