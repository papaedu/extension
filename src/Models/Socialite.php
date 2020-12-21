<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;

class Socialite extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'nickname',
        'openid',
    ];
}
