<?php

namespace ArtsAndHumanities\Http\Middleware;

use ArtsAndHumanities\Services\CASHelper;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class Authenticate
{

    //THIS FUNCTION GETS THE CURRENT URL
    function curPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s://";
            if ($_SERVER["SERVER_PORT"] != "443") {
                $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            }
        } else {
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            }
        }

        return $pageURL;

    }//END CURRENT URL FUNCTION


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
        if(\Session::get('user')==""){
            return  redirect()->action('HomeController@login');
        }
        return $next($request);
    }

}
