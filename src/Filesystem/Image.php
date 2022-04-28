<?php

namespace Papaedu\Extension\Filesystem;

use Illuminate\Support\Arr;

class Image extends DiskAbstract
{
    /**
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public function url(string $path, string $scale = '', string $default = ''): string
    {
        $url = parent::url($path, $default);
        if ($url && $scale) {
            $url .= "-{$scale}";
        }

        return $url;
    }
}
