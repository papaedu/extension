<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;
use Papaedu\Extension\Models\Methods\SocialiteMethod;
use Papaedu\Extension\Models\Relationships\SocialiteRelationship;

class Socialite extends Model
{
    use SocialiteMethod;
    use SocialiteRelationship;

    public const TEMP_KEY = 's:%s:openid:%s';

    public const TEMP_EXPIRE_SECONDS = 7200;

    protected $fillable = [
        'user_id',
        'type',
        'nickname',
        'openid',
    ];
}
