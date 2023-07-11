<?php

namespace Papaedu\Extension\Filesystem\Traits;

trait UrlScaleTrait
{
    public function url(string $path, string $scale = ''): string
    {
        $url = parent::url($path);
        if (! $url) {
            return '';
        }

        if (! $scale) {
            return $url;
        }

        return "{$url}-{$scale}";
    }
}
