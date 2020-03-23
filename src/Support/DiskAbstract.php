<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Papaedu\Extension\Traits\DiskHelpers;

abstract class DiskAbstract
{
    use DiskHelpers;

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    public static function getDisk()
    {
        return Storage::disk(static::$diskName);
    }

    /**
     * @param  string  $module
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string
     */
    public static function upload(string $module, UploadedFile $image)
    {
        return self::getDisk()->put(self::getPathPrefix($module), $image);
    }

    /**
     * @param  string  $module
     * @param  string  $ext
     * @return string
     */
    public static function getKey(string $module, string $ext)
    {
        return self::getPathPrefix($module) . self::getFilename($ext);
    }

    /**
     * @return string
     */
    public static function getUploadToken()
    {
        return self::getDisk()->getDriver()->uploadToken();
    }
}