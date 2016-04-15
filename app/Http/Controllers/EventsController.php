<?php

namespace ArtsAndHumanities\Http\Controllers;

use Illuminate\Http\Request;
use ArtsAndHumanities\Models as Models;

use ArtsAndHumanities\Http\Requests;

class EventsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /** Load the search form with events. */
    public function index(){
        $events = Models\Events::all()->orderBy('event_created_date', 'desc');
        return view('events.index')->with('events',$events);
    }
}
