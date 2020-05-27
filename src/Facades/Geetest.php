<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class Geetest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Papaedu\Extension\Geetest\Geetest::class;
    }
}
