<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;
use Papaedu\Extension\Casts\Image;

class CloseUser extends Model
{
    protected $fillable = [
        'guest_id',
        'unique_id',
        'iso_code',
        'idd_code',
        'username',
        'we_chat',
        'nickname',
        'avatar',
        'gender',
        'birthday',
        'note',
        'status',
        'login_count',
        'last_login_at',
        'registered_at',
        'reason',
    ];

    protected $casts = [
        'avatar' => Image::class,
    ];
}
