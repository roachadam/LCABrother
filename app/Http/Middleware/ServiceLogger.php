<?php

namespace App\Http\Middleware;

use Closure;

class ServiceLogger
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
        if($request->user() && ! $request->user()->canLogServiceEvent()){
            return redirect()->action('DashController@index');
        }
        return $next($request);
    }
}
