<?php

namespace Papaedu\Extension\Filesystem;

use InvalidArgumentException;
use Papaedu\Extension\Filesystem\Qiniu\QiniuAdapter;

/**
 * @method static \Papaedu\Extension\Filesystem\Aliyun\Client aliyun()
 * @method static \Papaedu\Extension\Filesystem\Qiniu\Client qiniu()
 *
 * @method static \Papaedu\Extension\Filesystem\Qiniu\ImageAdapter image()
 * @method static \Papaedu\Extension\Filesystem\Qiniu\AudioAdapter audio()
 * @method static \Papaedu\Extension\Filesystem\Qiniu\FileAdapter file()
 */
class Disk
{
    private static array $clients = [];

    private static array $adapters = [];

    public static function __callStatic(string $client, array $arguments)
    {
        if (! isset(self::$clients[$client])) {
            if (! in_array($client, ['aliyun', 'qiniu'])) {
                return self::callClient($client);
            }

            $clientClass = 'Papaedu\\Extension\\Filesystem\\'.ucfirst($client).'\\Client';
            if (! class_exists($clientClass)) {
                throw new InvalidArgumentException("Client name '{$client}' is invalid.");
            }
            self::$clients[$client] = new $clientClass($client);
        }

        return self::$clients[$client];
    }

    public static function callClient(string $adapter): QiniuAdapter
    {
        if (! isset(self::$adapters[$adapter])) {
            $adapterClass = 'Papaedu\\Extension\\Filesystem\\Qiniu\\'.ucfirst($adapter).'Adapter';

            self::$adapters[$adapter] = new $adapterClass($adapter);
        }

        return self::$adapters[$adapter];
    }
}
