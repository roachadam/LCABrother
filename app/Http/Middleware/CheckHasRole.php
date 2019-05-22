<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(! Auth::user()->canViewAllService());
        //dd($request->route()->uri);




        return $next($request);
    }
}
