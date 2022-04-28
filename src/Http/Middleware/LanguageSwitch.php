<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Papaedu\Extension\Enums\Header;

class LanguageSwitch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        switch ($request->header(Header::LANG->value)) {
            case 'en':
                App::setLocale('en');
                break;
            default:
        }

        return $next($request);
    }
}
