<?php

namespace Papaedu\Extension\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Papaedu\Extension\Filesystem\Disk;
use Papaedu\Extension\MediaLibrary\MediaLibrary;

class Image implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function get($model, string $key, $value, array $attributes): string
    {
        return Disk::image()->url((string) $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return Disk::image()->parseUrl($value);
    }
}
