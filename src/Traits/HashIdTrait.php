<?php

namespace App\Models\Traits;

use Hashids;

trait HashIdTrait
{
    private $hashId;

    public function getHashIdAttribute()
    {
        if (!$this->hashId) {
            $connection = $this->hashIdConnection ?? 'main';
            $this->hashId = Hashids::connection($connection)->encode($this->id);
        }

        return $this->hashId;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $connection = $this->hashIdConnection ?? 'main';
        $value = current(Hashids::connection($connection)->decode($value));
        if (!$value) {
            return;
        }

        return parent::resolveRouteBinding($value, $field);
    }

    public function getRouteKeyName()
    {
        return 'hash_id';
    }
}
