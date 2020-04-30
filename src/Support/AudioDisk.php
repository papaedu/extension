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
        $path = $path ?: $default;
        if (!$path) {
            return '';
        }

        return parent::getDisk()->url(['path' => $path, 'domainType' => 'https']);
    }
}