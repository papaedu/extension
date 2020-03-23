<?php

namespace Papaedu\Extension\Support;

class AudioDisk extends DiskAbstract
{
    /**
     * @var string
     */
    protected static $diskName = 'qiniu-audio';

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

        return parent::getDisk()->url(['path' => $path, 'domainType' => 'https']);
    }
}