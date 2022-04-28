<?php

namespace Papaedu\Extension\Models\Attributes;

use Vinkla\Hashids\Facades\Hashids;

trait HashidsRouteAttribute
{
    use HashidsAttribute;

    public function resolveRouteBinding($value, $field = null)
    {
        $value = current(Hashids::connection($this->hashidsConnection ?? $this->defaultHashidsConnection)->decode($value));
        if (! $value) {
            return;
        }

        return parent::resolveRouteBinding($value, $field);
    }

    public function getRouteKey(): string
    {
        return $this->hashidsValue;
    }
}
