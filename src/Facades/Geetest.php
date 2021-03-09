<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class Geetest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geetest.sense_bot';
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Geetest\SenseBot
     */
    public static function senseBot($name = '')
    {
        return $name ? app("geetest.sense_bot.{$name}") : app('geetest.sense_bot');
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Geetest\OnePass
     */
    public static function onePass($name = '')
    {
        return $name ? app("geetest.one_pass.{$name}") : app('geetest.one_pass');
    }
}
