<?php

namespace Papaedu\Extension\Filesystem;

use InvalidArgumentException;

/**
 * @method static \Papaedu\Extension\Filesystem\Aliyun\Client aliyun()
 * @method static \Papaedu\Extension\Filesystem\Qiniu\Client qiniu()
 */
class Disk
{
    private static array $platforms = [];

    public static function __callStatic(string $platform, array $arguments)
    {
        if (! isset(self::$platforms[$platform])) {
            $clientClass = 'Papaedu\\Extension\\Filesystem\\'.ucfirst($platform).'\\Client';
            if (! class_exists($clientClass)) {
                throw new InvalidArgumentException("Platform name '{$platform}' is invalid.");
            }
            self::$platforms[$platform] = new $clientClass($platform);
        }

        return self::$platforms[$platform];
    }
}
