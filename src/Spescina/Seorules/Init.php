<?php

namespace Spescina\Seorules;

use Closure;

class Init
{
    public function handle($request, Closure $next)
    {
        Facades\Seo::init();

        return $next($request);
    }
}