<?php

namespace Papaedu\Extension\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Papaedu\Extension\Filesystem\Core\AdapterAbstract;
use Papaedu\Extension\Filesystem\Disk;

class AliyunAudio implements CastsAttributes
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
        return Disk::aliyun()->audio()->url((string) $value);
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
        $path = Disk::aliyun()->audio()->path($value);
        if (str_starts_with($path, AdapterAbstract::TMP_DIR)) {
            return Disk::aliyun()->audio()->move($path);
        }

        return $path;
    }
}
