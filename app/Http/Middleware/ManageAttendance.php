<?php

namespace App\Http\Middleware;

use Closure;

class ManageAttendance
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
        if ($request->user() && !$request->user()->canManageAttendance()) {
            return redirect()->action('DashController@index');
        }
        return $next($request);
    }
}