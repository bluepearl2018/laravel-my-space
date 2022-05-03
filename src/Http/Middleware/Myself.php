<?php

namespace Eutranet\MySpace\Http\Middleware;

use Closure;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Auth;

class Myself
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (auth()->check()) {
            return $next($request);
        }
        Flash::warning(__('Access your resource.'));
        return redirect()->route('my-space.dashboard');
    }
}
