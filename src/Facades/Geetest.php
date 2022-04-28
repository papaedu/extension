<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\Geetest\OnePass;
use Papaedu\Extension\Geetest\SenseBot;

class Geetest extends Facade
{
    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Geetest\SenseBot
     */
    public static function senseBot(string $name = ''): SenseBot
    {
        return $name ? app("geetest.sense_bot.{$name}") : app('geetest.sense_bot');
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Geetest\OnePass
     */
    public static function onePass(string $name = ''): OnePass
    {
        return $name ? app("geetest.one_pass.{$name}") : app('geetest.one_pass');
    }
}
