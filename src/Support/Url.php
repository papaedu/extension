<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Arr;
use Storage;

class Url
{
    /**
     * Return complete image url.
     *
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public static function image(string $path, string $scale = '', string $default = '')
    {
        return self::getStorageDiskUrl(config('storage.image.disk', 'qiniu-image'), $path, $scale, $default);
    }

    /**
     * Return complete audio url.
     *
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public static function audio(string $path, string $scale = '', string $default = '')
    {
        return self::getStorageDiskUrl(config('storage.audio.disk', 'qiniu-audio'), $path, $scale, $default);
    }

    /**
     * Return complete file url.
     *
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public static function file(string $path, string $scale = '', string $default = '')
    {
        return self::getStorageDiskUrl(config('storage.file.disk', 'qiniu-file'), $path, $scale, $default);
    }

    /**
     * Get Storage disk url.
     *
     * @param  string  $disk
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    protected static function getStorageDiskUrl(string $disk, string $path, string $scale = '', string $default = '')
    {
        $url = $path ? Storage::disk($disk)->url(['path' => $path, 'domainType' => 'https']) : $default;
        $url .= $scale ? "-{$scale}" : '';

        return $url;
    }

    /**
     * Random a test image url.
     *
     * @return string
     */
    public static function randomImage()
    {
        return Arr::random([
            'course/1Gn5BHUCuLCANBWVphiYBgO1HCAIXYlKJgZcqRP6.png',
            'course/bFC5xRIGqnCshST789RGX1c3vhsvHYuTzfOgcyiv.jpeg',
        ]);
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

        return self::filterPath($path);
    }

    /**
     * Get complete vod url.
     *
     * @param  string  $path
     * @return string
     */
    public static function vod(string $path)
    {
        if (!$path) {
            return '';
        }

        $scheme = Arr::first(explode(':', $path));
        if (in_array($scheme, ['http', 'https'])) {
            return $path;
        }

        return config('qcloud.vod.host', '').self::filterPath($path);
    }

    /**
     * Filter path slash.
     *
     * @param  string  $path
     * @return string
     */
    protected static function filterPath(string $path)
    {
        return trim($path, '/');
    }
}
