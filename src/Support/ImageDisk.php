<?php

namespace Papaedu\Extension\Support;

class ImageDisk extends DiskAbstract
{
    /**
     * @var string
     */
    protected static $diskName = 'qiniu-image';

    /**
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public static function get(string $path, string $scale = '', string $default = '')
    {
        if (!$path) {
            if ($default) {
                $url = $default;
            } else {
                return '';
            }
        } else {
            $url = self::getDisk()->url(['path' => $path, 'domainType' => 'https']);
        }

        $url .= $scale ? "-{$scale}" : '';

        return $url;
    }
}