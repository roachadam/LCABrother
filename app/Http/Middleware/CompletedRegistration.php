<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CompletedRegistration
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
        // Middleware should not block

        if($this->shouldPass($request->route()->uri))
            return $next($request);

        if(isset(Auth::user()->organization_id))
        {
            if(!isset(Auth::user()->organization->goals))
                return redirect('/goals/create');

            if(Auth::user()->organization->semester()->first() == null)
                return redirect('/goals/store');
        }
        if(!isset(Auth::user()->organization_id))
            return redirect('/organization');

        return $next($request);
    }

    private function shouldPass($uri)
    {
        $exceptions = [
            'avatar/create',
            'organization',
            'organization/create',
            'goals/create',
            'goals/store'
        ];
        foreach($exceptions as $s)
        {
            if($uri == $s)
                return true;
        }
        return false;
    }
}
