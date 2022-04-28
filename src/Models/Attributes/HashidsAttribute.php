<?php

namespace Papaedu\Extension\Models\Attributes;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Vinkla\Hashids\Facades\Hashids;

trait HashidsAttribute
{
    private string $hashidsValue = '';

    protected string $defaultHashidsConnection = 'main';

    public function hashids(): Attribute
    {
        return new Attribute(
            get: function (): string {
                if (! $this->hashidsValue) {
                    $this->hashidsValue = Hashids::connection($this->hashidsConnection ?? $this->defaultHashidsConnection)->encode($this->id);
                }

                return $this->hashidsValue;
            }
        );
    }
}
