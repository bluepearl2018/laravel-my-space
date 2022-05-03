<?php

namespace Eutranet\MySpace\Http\Middleware;

use Auth;
use Closure;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;

class HasAcceptedMySpaceGeneralTermsOn
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
        if (Auth::check()) {
            if (Auth::user()->has_accepted_my_space_general_terms_on !== null) {
                return $next($request);
            } else {
                Flash::warning(trans('To unlock your account and continue, you have to read and accept our general terms.'));
                $mySpaceGeneralTerm = MySpaceGeneralTerm::find(1);
                if ($mySpaceGeneralTerm !== null) {
                    return redirect()->route('my-space.read-and-accept-my-space-general-terms', [
                        Auth::user(), $mySpaceGeneralTerm
                    ]);
                } else {
                    Flash::error('My Space General terms not found');
                    return redirect()->route('my-space.dashboard');
                }
            }
        }
        return redirect()->route('login');
    }
}
