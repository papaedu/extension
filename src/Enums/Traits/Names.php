<?php

namespace Papaedu\Extension\Enums\Traits;

trait Names
{
    public static function values(): array
    {
        return array_column(static::cases(), 'name');
    }
}
