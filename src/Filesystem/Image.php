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

    /**
     * @return string
     */
    public function random(): string
    {
        return Arr::random([
            'course/1Gn5BHUCuLCANBWVphiYBgO1HCAIXYlKJgZcqRP6.png',
            'course/bFC5xRIGqnCshST789RGX1c3vhsvHYuTzfOgcyiv.jpeg',
        ]);
    }
}
