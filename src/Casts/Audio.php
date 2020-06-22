<?php

namespace Papaedu\Extension\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Papaedu\Extension\Support\Disks\Disk;

class Audio implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return int
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return Disk::audio()->url($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return float
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return Disk::audio()->parseUrl($value);
    }
}
