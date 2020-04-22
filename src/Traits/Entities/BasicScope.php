<?php

namespace Papaedu\Extension\Traits\Entities;

trait BasicScope
{
    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentCreated($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentUpdated($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}