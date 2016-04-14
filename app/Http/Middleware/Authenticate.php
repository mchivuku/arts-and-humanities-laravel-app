<?php

namespace ArtsAndHumanities\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( empty($_SERVER['REMOTE_USER'])){
            //Redirect to the cas authentication page.
            throw new Exception("You are Not authenticated");
        }
        return $next($request);
    }

}
