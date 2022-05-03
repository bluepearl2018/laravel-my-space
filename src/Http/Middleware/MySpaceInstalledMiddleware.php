<?php

namespace Eutranet\MySpace\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;
use Flash;

class MySpaceInstalledMiddleware
{
    public function handle($request, Closure $next)
    {
        // Compare with config requirements
        return $next($request);
    }
}
