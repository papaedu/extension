<?php

namespace Papaedu\Extension\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Tens implements CastsAttributes
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
        return $value / 10;
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
        return $value * 10;
    }
}
