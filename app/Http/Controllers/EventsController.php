<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Http\Requests;
use ArtsAndHumanities\Http\Transformers\BaseTransformer;
use ArtsAndHumanities\Http\Transformers\EventTransformer;
use ArtsAndHumanities\Models as Models;
use ArtsAndHumanities\Models\ViewModels as VM;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input as Input;
use Yajra\Datatables\Datatables;


class EventsController extends Controller
{
    protected $perPage = 10;
    protected $transformer;

    public function __construct(EventTransformer $transformer)
    {

        $this->transformer=$transformer;
        parent::__construct();
    }


    public function index()
    {

        $review_id = Input::get('review');

        $reviews['all'] = 'All Events';
        $dbreviews = Models\Review::all()->toArray();
        foreach ($dbreviews as $review) {
            $reviews[$review['id']] = 'All  ' . $review['description'] . " Events";
        }

        if (isset($review_id) && $review_id != "all") {
            $events = Models\Event::with('types')->with('venue')
                ->with('review')
                ->where('review_id', '=', $review_id)
                ->select('unique_id', 'summary', 'image_url_small','event_url',
                    'location', 'website_image_url_small', 'review_id')
                ->get();
        } else {
            $events = Models\Event::with('types')
                ->with('review')->with('venue')->get();
        }


        return view('events.index')
            ->with('events', $this->buildEventData($events))
            ->with('reviews', $reviews)
            ->with('pageTitle', 'Manage Events')
            ->with('review_id', $review_id)
            ->with('section_title',
                isset($review_id) && $review_id != "" ?
                    $reviews[$review_id] : "All Events");
    }

    /** Helpers */
    private function buildEventData($data)
    {
        $events = new Collection;

        foreach ($data as $event) {

            $thumbnail = $event->website_image_url_small != "" ?
                asset("images/events/" . basename($event->website_image_url_small))
                : $event->image_url_small;

            if ($thumbnail == "") $thumbnail = "#";

            $edit = \URL::to("/events/edit" . '/' . $event->unique_id);
            $schedule_link = \URL::to("/events/schedule" . '/' . $event->unique_id);
            $venue = $event->venue()->first();
            $status = $event->review()->first()->description;
            $website_link = $_ENV['HOME_PATH'] . "/calendar/event?id=" . $event->unique_id;

            $url = $event->event_url;

            $events->push([
                'id' => $event->unique_id,
                'thumbnail' => $thumbnail,
                'summary' =>$event->summary,
                'event_url'=>$event->event_url,
                'location' => $event->location,
                'featured_venue' => isset($venue) ? $event->venue()->first()->description : "",
                'event_types' => implode(", ",
                    array_map(function ($item) {
                        return $item['description'];
                    },
                        $event->types()->get()->toArray())),
                'status' => $status,
                'schedule' => "<a data-reveal-id=\"viewModal\" onclick=\"loadSchedule(this);return false;\" href='" . $schedule_link . "' class=\"modal\" >View Schedule</a>",
                'action' => "<a href='$edit'>Edit</a>",
                'link' => '<a target=\"_blank\" href="' . $website_link . '">View on the website</a>'
            ]);
        }

      return ( Datatables::of($events)->
            addColumn('summary_url',function($event){
            return '<a target="_blank"   href="' . $event['event_url'] . '">' . $event['summary'] . '</a>';
        })->editColumn('thumbnail', function ($event) {
            if ($event['thumbnail'] == '#')
                return "";
            return '<a target="_blank" class="th" href="' . $event['thumbnail'] . '">
                                <img aria-hidden=true src="' . $event['thumbnail'] . '"/></a>';

        })->make(true));


    }

    public function getEvents()
    {
        $review_id = Input::get('review');

        if (isset($review_id) && $review_id != "all") {
            $events = Models\Event::with('types')->with('venue')->with('review')
                ->where('review_id', '=', $review_id)
                ->select('unique_id', 'summary',
                    'image_url_small', 'location', 'website_image_url_small', 'review_id')->get();
        } else {
            $events = Models\Event::with('types')->with('venue')
                ->with('review')
                ->select('unique_id', 'summary', 'image_url_small',
                    'location', 'website_image_url_small', 'venue_id', 'review_id')->get();
        }


        return $this->buildEventData($events);
    }

    public function getSchedules($id)
    {
        $event = Models\Event::with('schedules')
            ->where('unique_id', '=', $id)->first();

         $schedules = $this->schedules($event);

        $modal = new \StdClass();
        if (isset($schedules)) {
            $modal->content = view('events.schedule', array('schedules' => $schedules));
            $modal->title = 'Event Schedule &mdash;' . $event->summary;

        } else {
            $modal->title = 'Not Found';
            $modal->content = 'Schedules not found.';
        }

        return view('partials._modal', array('model' => $modal));

    }

    /**
     * Edit Event
     */
    public function edit($id)
    {
        $start_date="";
        $end_date="";$repeat_message="";

        $event = Models\Event::with('types')->with('schedules')->where('unique_id', '=', $id)
            ->first();

        $types_db = Models\Type::all()->lists('description', 'id');
        $venues_db = Models\Venue::all()->lists('description', 'id');

        $repeat_message = $this->transformer->getRepeatMessage($event);
        $schedules = $this->schedules($event);

        if(count($schedules)>1){
            $start_date = $schedules[0];
            $end_date = last($schedules);
        }else{
            $start_date=$schedules[0];
            $end_date = "";
        }




        return view('events.edit')
            ->with('event', $event)
            ->with('types', $types_db)
            ->with('schedule',array('start_date'
            =>$start_date,'end_date'=>$end_date,'repeat_message'=>$repeat_message))
            ->with('reviews', Models\Review::all()->lists('description', 'id'))
            ->with('venues', $venues_db)
            ->with('pageTitle', 'Edit Event');

    }

    /**
     * Function to update event information - include update for venue, event type, thumbnail, featured
     * @param Requests\EventFormRequest $request
     */
    public function update(Requests\EventFormRequest $request)
    {
        $event = Models\Event::where('unique_id', '=', $request->id)->first();

        // remove existing ones
        $event->types()->detach();

        \DB::transaction(function () use ($event, $request) {

            // update - short_description;student_pick,faculty_only, faculty_enrichment
            // venue, event types,recommendation text

            //Save thumbnail
            if (isset($request['website_thumbnail'])) {

                $thumbnail_name =
                    pathinfo($request->file('website_thumbnail')
                        ->getClientOriginalName(), PATHINFO_FILENAME) . "_" . time() . '.' .
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
            $event->review_id = $request['reviewId'];

            $event->faculty_only = $request['faculty_only'];
            $event->faculty_enrichment = $request['faculty_enrichment'];
            $event->venue_id = $request['venue'];

            // remove existing ones

            if (isset($request['event_types'])) {
                foreach ($request['event_types'] as $type) {
                    $event->types()->attach($type,
                        ['update_user' => $this->currentUser]);
                }

            }

            $event->recommendation = $request['recommendation'];
            $event->update_user = $this->currentUser;

            $event->save();

        });

        //redirect to show page
        \Session::flash('message', 'Successfully updated the event!');
        return redirect()->action('EventsController@show', ['id' => $event->unique_id]);

    }

    public function show($id)
    {

        $event = Models\Event::with('types')
            ->with('venue')->with('review')->find($id);

        return view('events.show')->with('event', $event)
            ->with('pageTitle', 'Event &mdash;' . $event->summary);

    }


    protected function schedules($event){

        $schedules = array_map(function ($item) {

            $start_date = date('Y-m-d', strtotime($item['start_date_time']));
            $end_date = date('Y-m-d', strtotime($item['end_date_time']));

            if ($start_date == $end_date) {
                return
                    date('l jS F Y, g:ia ', strtotime($item['start_date_time'])) . " - " .
                    date('g:ia ', strtotime($item['end_date_time']));
            }
            return
                date('l jS F Y, g:ia ', strtotime($item['start_date_time'])) . "to " .
                date('l jS F Y, g:ia ', strtotime($item['end_date_time']));

        },

            $event->schedules->toArray());

        return $schedules;
    }
}
