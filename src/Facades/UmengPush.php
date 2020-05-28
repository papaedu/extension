<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class UmengPush extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Papaedu\Extension\UmengPush\UmengPush::class;
    }
}