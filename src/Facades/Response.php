<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;
use Papaedu\Extension\Support\Response as JsonResponse;

class Response extends IlluminateFacade
{
    protected static function getFacadeAccessor(): string
    {
        return JsonResponse::class;
    }
}
