<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckOrgVerified
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()->organization_verified === 2) {
            return redirect()->action('OrgVerificationController@alumni');
        } else if (Auth::user()->organization_verified === 0) {
            return redirect()->action('OrgVerificationController@rejected');
        } else if (Auth::user()->organization_verified === null) {
            return redirect()->action('OrgVerificationController@waiting');
        } else {
            return $next($request);
        }
    }
}
