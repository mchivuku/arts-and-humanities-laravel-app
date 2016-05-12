<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')->with('pageTitle','Dashboard');
    }

    public function login(){

        if(\Session::get('user')!=''){
            return  redirect()->action('EventsController@index');
        }


        // $sid = SID; //Session ID #

        session_start();
        $last_session = \Session::get('LAST_SESSION');
        $user =  \Session::get('user');

        //if the last session was over 15 minutes ago
        if (isset($last_session) && (time() - $last_session > 900)) {
            \Session::put('CAS', false); // set the CAS session to false
            \Session::save();
        }

        $authenticated = \Session::get('CAS');
        $casurl = $this->curPageURL();

        //send user to CAS login if not authenticated
        if (!$authenticated) {
            \Session::put('LAST_SESSION', time());// update last activity time stamp
            \Session::put('CAS', true);
            \Session::save();
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=https://cas.iu.edu/cas/login?cassvc=IU&casurl='.$casurl.'">';
            exit;
        }

        if ($authenticated) {
            $casticket = isset($_GET['casticket'])?$_GET['casticket']:null;

            if (isset($casticket)){


                //set up validation URL to ask CAS if ticket is good
                $_url = 'https://cas.iu.edu/cas/validate';
                $cassvc = 'IU'; //search kb.indiana.edu for "cas application code" to determine code to use here in place of "appCode"

                $params = "cassvc=$cassvc&casticket=$_GET[casticket]&casurl=$casurl";
                $urlNew = "$_url?$params";


                //CAS sending response on 2 lines. First line contains "yes" or "no". If "yes", second line contains username (otherwise, it is empty).
                $ch = curl_init();
                $timeout = 5; // set to zero for no timeout
                curl_setopt ($ch, CURLOPT_URL, $urlNew);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                ob_start();
                curl_exec($ch);
                curl_close($ch);
                $cas_answer = ob_get_contents();
                ob_end_clean();
                //split CAS answer into access and user
                list($access,$user) = explode("\n",$cas_answer);
                $access = trim($access);
                $user = trim($user);
                //set user and session variable if CAS says YES
                if ($access == "yes") {
                    \Session::put('user', $user);

                    \Session::save();
                    return  redirect()->action('EventsController@index');
                }//END SESSION USER
            } else if (!isset($user)) { //END GET CAS TICKET
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=https://cas.iu.edu/cas/login?cassvc=IU&casurl='.$casurl.'">';
                exit;
            }
        }

    }

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

}
