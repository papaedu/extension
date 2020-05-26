<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class EasySms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'easySms';
    }
}
