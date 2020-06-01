<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class Geetest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geetest.papaedu';
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Geetest\Geetest
     */
    public static function config($name = '')
    {
        return $name ? app("geetest.{$name}") : app('geetest.papaedu');
    }
}
