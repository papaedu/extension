<?php

namespace Papaedu\Extension\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Papaedu\Extension\Filesystem\Core\AdapterAbstract;
use Papaedu\Extension\Filesystem\Disk;

class AliyunImage implements CastsAttributes
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
        return Disk::aliyun()->image()->url((string) $value);
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
        $path = Disk::aliyun()->image()->path($value);
        if (str_starts_with($path, AdapterAbstract::TMP_DIR)) {
            return Disk::aliyun()->image()->move($value);
        }

        return $path;
    }
}
