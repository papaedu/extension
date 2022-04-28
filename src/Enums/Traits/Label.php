<?php

namespace Papaedu\Extension\Enums\Traits;

use JetBrains\PhpStorm\Pure;

trait Label
{
    #[Pure]
    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return '';
    }
}
