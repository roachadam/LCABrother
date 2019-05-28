<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckOrgVerified
{
    /**`
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->organization_verified === 0){
            return redirect()->action('OrgVerificationController@rejected');
        }
        if(Auth::user()->organization_verified === null)
        {
            return redirect()->action('OrgVerificationController@waiting');
        }
        return $next($request);
    }
}
