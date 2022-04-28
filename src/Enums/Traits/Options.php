<?php

namespace Papaedu\Extension\Enums\Traits;

use BackedEnum;

trait Options
{
    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_map(fn ($case) => ['key' => $case->value, 'value' => $case->label()], $cases)
            : array_column($cases, 'name');
    }

    public function option(): array
    {
        return [
            'key' => $this instanceof BackedEnum ? $this->value : $this->name,
            'value' => $this->label(),
        ];
    }
}
