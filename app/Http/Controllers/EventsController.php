<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Models as Models;
use ArtsAndHumanities\Models\ViewModels as VM;
use ArtsAndHumanities\Http\Requests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
use Mockery\CountValidator\Exception;

class EventsController extends Controller
{
    protected  $perPage = 10;

    public function __construct()
    {
        parent::__construct();
    }

    /** Load the search form with events. */
    protected function getEvents($params=[]){

        $events  = Models\Event::select('unique_id','summary','image_url_small');

        if(isset($params['title']))
            $events= $events->where('summary','like',"%".$params['title']."%");

        if(isset($params['date'])){
             $date = date('Y-m-d',strtotime($params['date']));
             $events= $events->whereRaw('id IN (select event_id from event_schedule WHERE
                        date(start_date_time)="'. $date .'")');
        }


        $events = $events->paginate($this->perPage);
        $result=null;

        foreach($events as $event){

            $vm = new VM\LookupEventVM();
            $vm->summary = $event->summary;
            $vm->id = $event->unique_id;

            $vm->image_url_small = $event->image_url_small;

            $vm->types = isset($types)?implode(",",$types):"";

            $venue = $event->venue;
            if(isset($venue))
                $vm->venue = $venue->description;

            $vm->schedules = array_map(function($item){

                $start_date = date('Y-m-d',strtotime($item['start_date_time']));
                $end_date = date('Y-m-d',strtotime($item['end_date_time']));

                if($start_date==$end_date){
                    return
                        date('l jS F Y, g:ia ',strtotime($item['start_date_time']))." - ".
                        date('g:ia ',strtotime($item['end_date_time']));
                }
                return
                    date('l jS F Y, g:ia ',strtotime($item['start_date_time']))."to ".
                    date('l jS F Y, g:ia ',strtotime($item['end_date_time']));

            },
                $event->schedules->toArray());

            $result[]=$vm;
        }


        return array('data'=>$result,'links'=>$events->links());

    }

    public function index(){
        $result = $this->getEvents();
        return view('events.index')->with('events',$result)->with('pageTitle','Manage Events');
    }

    public function results(){

        $title = Input::get('title');
        $date = Input::get('date');

        $params['title']=$title;
        $params['date']=$date;

        $result = $this->getEvents($params);

        return view('events.results')->with('events',$result);
    }


    /**
     * Edit Event
     */
    public function edit($id){
        $event  = Models\Event::with('types')->where('unique_id','=',$id)
            ->first();

        $types_db = Models\Type::all();
        $venues_db = Models\Venue::all();

        $build_select= function($data){
            $result=[];
            foreach($data as $x){
                $result[$x->id]=$x->description;
            }
            return $result;
        };

        return view('events.edit')
            ->with('event',$event)
            ->with('types',$build_select($types_db))
            ->with('venues',$build_select($venues_db))->with('pageTitle','Edit Event');;

    }


    /**
     * Function to update event information - include update for venue, event type, thumbnail, featured
     * @param Requests\EventFormRequest $request
     */
    public function update(Requests\EventFormRequest $request){


        $event = Models\Event::where('unique_id','=',$request->id)->first();

        // remove existing ones
        $event->types()->detach();

        \DB::transaction(function ()use($event,$request) {

            // update - short_description;student_pick,faculty_only, faculty_enrichment
            // venue, event types,recommendation text

            //Save thumbnail
            if (isset($request['website_thumbnail'])) {

                $thumbnail_name =
                    pathinfo($request->file('website_thumbnail')->getClientOriginalName(), PATHINFO_FILENAME) . "_" . time() . '.' .
                    $request->file('website_thumbnail')->getClientOriginalExtension();

                $request->file('website_thumbnail')->move(
                    base_path() . '/public/images/events/', $thumbnail_name
                );
                $event->website_image_url_small = base_path() . '/public/images/events/' . $thumbnail_name;

            }

            // Featured image
            if (isset($request['website_featured'])) {
                $website_featured = pathinfo($request->file('website_featured')->getClientOriginalName(), PATHINFO_FILENAME) . "_" . time() . '.' .
                    $request->file('website_featured')->getClientOriginalExtension();

                $request->file('website_featured')->move(
                    base_path() . '/public/images/events/', $website_featured
                );


                $event->website_featured = base_path() . '/public/images/events/' . $website_featured;
            }

            // update event table
            $event->short_description = $request['short_description'];
            $event->student_pick = $request['student_pick'];

            $event->faculty_only = $request['faculty_only'];
            $event->faculty_enrichment = $request['faculty_enrichment'];
            $event->venue_id = $request['venue'];

            // remove existing ones

            foreach ($request['event_types'] as $type) {

               $event->types()->attach($type,
                   ['update_user'=>$this->currentUser]);

            }

            $event->recommendation = $request['recommendation'];
            $event->update_user = $this->currentUser;

            $event->save();

        });

        //redirect to show page
        \Session::flash('message', 'Successfully updated the event!');
        return redirect()->action('EventsController@show', ['id'=>$event->unique_id]);

    }

    public function show($id){

        $event = Models\Event::with('types')->with('venue')->find($id);
        return view('events.show')->with('event',$event)->with('pageTitle','Event &mdash;'.$event->summary);

    }

}
