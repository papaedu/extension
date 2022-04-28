<?php

namespace Papaedu\Extension\MediaLibrary;

use InvalidArgumentException;

/**
 * @method static \Papaedu\Extension\MediaLibrary\Image image()
 * @method static \Papaedu\Extension\MediaLibrary\Audio audio()
 * @method static \Papaedu\Extension\MediaLibrary\File file()
 * @method static \Papaedu\Extension\MediaLibrary\Vod vod()
 */
class MediaLibrary
{
    private static array $mediaLibraries = [];

    protected static function handle(string $bucket)
    {
        if (! isset(self::$mediaLibraries[$bucket])) {
            $class = 'Papaedu\\Extension\\MediaLibrary\\'.ucfirst($bucket);
            if (! class_exists($class)) {
                throw new InvalidArgumentException("Bucket name '{$bucket}' is invalid.");
            }
            self::$mediaLibraries[$bucket] = new $class($bucket);
        }

        return self::$mediaLibraries[$bucket];
    }

    public static function __callStatic($name, $arguments)
    {
        return self::handle($name);
    }
}
