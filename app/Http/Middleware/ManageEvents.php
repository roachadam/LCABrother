<?php

namespace App\Http\Middleware;

use Closure;

class ManageEvents
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

        if ($request->user() && !$request->user()->canManageEvents()) {
            dump('manage events middware');
            return redirect()->action('DashController@index');
        }
        return $next($request);
    }
}
