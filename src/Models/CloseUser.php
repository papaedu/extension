<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;

class CloseUser extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'reason',
        'status',
    ];
}
