<?php

namespace Papaedu\Extension\Models\Scopes;

trait TimestampScope
{
    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $createdAt
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedAt($query, array $createdAt)
    {
        return $query->whereBetween('created_at', $createdAt);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $updatedAt
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpdatedAt($query, array $updatedAt)
    {
        return $query->whereBetween('updated_at', $updatedAt);
    }
}
