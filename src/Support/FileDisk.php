<?php

namespace Papaedu\Extension\Support;

class FileDisk extends DiskAbstract
{
    /**
     * @var string
     */
    protected static $diskName = 'qiniu-file';

    /**
     * @param  string  $path
     * @param  string  $default
     * @return string
     */
    public static function get(string $path, string $default = '')
    {
        if (!$path) {
            return $default ?: '';
        }

        return self::getDisk()->url(['path' => $path, 'domainType' => 'https']);
    }
}