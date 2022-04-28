<?php

namespace Papaedu\Extension\Models\Relationships;

trait SocialiteRelationship
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
