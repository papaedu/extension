<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'platform',
        'device_id',
        'system',
        'device_type',
        'device_name',
    ];
}
