<?php

namespace Papaedu\Extension\Support\Disks;

class Disk
{
    public static function image()
    {
        return new Image();
    }

    public static function file()
    {
        return new File();
    }

    public static function audio()
    {
        return new Audio();
    }

    public static function vod()
    {
        return new Vod();
    }
}