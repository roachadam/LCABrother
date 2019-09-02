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

     //@TODO, fix case where users can bypass registration and go to email/verify
    public function handle($request, Closure $next)
    {

        // Middleware should not block
        $uri = $request->route()->uri;
        $step = session('regStep');
        //dump($step);

        // If user has already joined/registered org, they should be sent to dash
        if(isset(Auth::user()->organization_id) && $uri != 'dash' && $uri !='orgpending/waiting' && $step == 5)
        {
            return redirect('/dash');
        }

        // For simply joining an organization, must allow bypass for join post request.
        if(strpos($uri, 'join') !== false && strpos($uri, 'user') !== false)
            return $next($request);

        // Bypass step 4 for massinvite, step 1 is joining org
        if($step == 5 || $step == 1)
        {
            //die('does this get hit ever?');
            return $next($request);
        }



        $uris = [
            'avatar/create',
            'organization',
            'organization/create',
            'goals/create',
            'semester/create',
            'massInvite',
        ];

        switch($uri)
        {
            case 'avatar/create':
                return $this->handleUri(0, $uris, $next, $request);
                break;
            case 'organization':
                // DO NOTHING??
                return $this->handleUri(1, $uris, $next, $request);
                break;
            case 'organization/create':
                return $this->handleUri(2, $uris, $next, $request);
                break;
            case 'goals/create':
                return $this->handleUri(3, $uris, $next, $request);
                break;
            case 'goals/store':
                break;
            case 'semester/create':
                return $this->handleUri(4, $uris, $next, $request);
                break;
            case 'semester/initial':
                break;
            case 'massInvite':
                return $this->handleUri(5, $uris, $next, $request);
                break;
            case 'email/verify':
                return redirect('/'.$uris[$step+1]);
            default:
                //die('why');
                return redirect('/'.$uris[$step+1]);
        }

        return $next($request);
    }

    private function handleUri($step, $uris, $next, $request)
    {
        //die('wtf');
        $completedStep = session('regStep');

        // case where you are creating an organization
        if($step == 2 && $completedStep == 0)
        {

            return $next($request);
        }

        // dump('step='.$step);
        // dump('completedStep='.$completedStep);


        //|| ($step == 0 && $completedStep != 0)
        if(abs($step - $completedStep) >= 2 )
        {

            return redirect('/'.$uris[$completedStep+1]);
        }


        return $next($request);
    }
}
