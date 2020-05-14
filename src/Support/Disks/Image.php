<?php

namespace Papaedu\Extension\Support\Disks;

use Illuminate\Support\Arr;

class Image extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-image';

    /**
     * @param  string  $path
     * @param  string  $scale
     * @param  string  $default
     * @return string
     */
    public function url(string $path, string $scale = '', string $default = '')
    {
        $url = parent::url($path, $default);
        $url .= $scale ? "-{$scale}" : '';

        return $url;
    }

    /**
     * @return string
     */
    public function random()
    {
        return Arr::random([
            'course/1Gn5BHUCuLCANBWVphiYBgO1HCAIXYlKJgZcqRP6.png',
            'course/bFC5xRIGqnCshST789RGX1c3vhsvHYuTzfOgcyiv.jpeg',
        ]);
    }

    protected function getDomain()
    {
        return config('filesystems.disks.qiniu-image.domains.https');
    }
}