<?php

namespace Papaedu\Extension\Support\Disks;

class Disk
{
    private static $image;

    private static $audio;

    private static $file;

    private static $vod;

    public static function image()
    {
        if (!self::$image) {
            self::$image = new Image();
        }

        return self::$image;
    }

    public static function audio()
    {
        if (!self::$audio) {
            self::$audio = new Audio();
        }

        return self::$audio;
    }

    public static function file()
    {
        if (!self::$file) {
            self::$file = new File();
        }

        return self::$file;
    }

    public static function vod()
    {
        if (!self::$vod) {
            self::$vod = new Vod();
        }

        return self::$vod;
    }
}
