<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Response extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return \Papaedu\Extension\Support\Response::class;
    }
}
