<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class ManageInvolvement
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
        if ($request->user() && !$request->user()->canManageInvolvement()) {
            return redirect()->action('DashController@index');
        }
        return $next($request);
    }
}
