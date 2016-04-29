<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/20/16
 * Time: 12:04 PM
 */

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Http\Transformers\EventTransformer;
use ArtsAndHumanities\Http\Transformers\EventTypeTransformer;
use ArtsAndHumanities\Http\Transformers\EventVenueTransformer;
use ArtsAndHumanities\Models as Models;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input as Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item as Item;

class APIController extends BaseController
{
    protected $fractal;
    protected $perPage = 10;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Function to return types
     */
    public function types()
    {
        $types = Models\Type::all();
        return $this->fractal
            ->createData(new Collection($types, new EventTypeTransformer))
            ->toJson();
    }

    /**
     * Function to return venues
     */
    public function venues()
    {
        $venues = Models\Venue::all();
        return $this->fractal
            ->createData(new Collection($venues, new EventVenueTransformer))
            ->toJson();
    }


    /**
     * Function to return event for the feed
     * load today by default
     */
    public function events()
    {
        $date = Input::get('date');
        $typeId = Input::get('type');
        $venueId = Input::get('venue');
        $day = Input::get('day');

        $paginator =
            Models\Event::with('schedules')->with('types')->with('venue');

        // filter date
        if (isset($date)) {
            $paginator = $paginator->whereRaw('unique_id IN (select event_id from event_schedule WHERE
                        date(start_date_time)="' . $date . '")');
        }

        if (isset($day) && $day == 'today') {
            $today = date('Y-m-d');

            $paginator = $paginator
                ->whereRaw('unique_id IN (select event_id from event_schedule WHERE
                        date(start_date_time)="' . $today . '")');
        }

        if (isset($day) && $day == 'nextsevendays') {
            $today = date('Y-m-d');
            $seventhdayfromtoday = date('Y-m-d', strtotime("+7 day"));

            $paginator = $paginator
                ->whereRaw('unique_id IN (select event_id from event_schedule WHERE
                        date(start_date_time)>="' . $today . '" and date(start_date_time)<="' . $seventhdayfromtoday . '")');
        }

        // load today by default
        if (!isset($day) && !isset($date)) {
            $today = date('Y-m-d');

            $paginator = $paginator
                ->whereRaw('unique_id IN (select event_id from event_schedule WHERE
                        date(start_date_time)="' . $today . '")');
        }


        //filter type
        if (isset($typeId)) {

            $paginator = $paginator->whereRaw("(EXISTS (
		SELECT
			*
		FROM
			`type`
		INNER JOIN `event_type` ON `type`.`id` = `event_type`.`type_id`
		WHERE
			`event_type`.`event_id` = `event`.`unique_id`
		AND `type_id` = $typeId
 		AND `type`.`deleted_at` IS NULL))");
        }

        //filter venue
        if (isset($venueId)) {
            $paginator = $paginator->where('venue_id', '=', $venueId);
        }

        $paginator = $paginator->paginate($this->perPage);

        $events = $paginator->getCollection();

        $params['short'] = true;
        $params['date'] = $date;
        $params['day'] = $day;


        $resource = new Collection($events, new EventTransformer($params));
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->fractal->createData($resource)->toJson();
    }


    /** Featured events for homepage */
    public function featuredEvents()
    {
        $events = \DB::select(\DB::raw("select unique_id,summary, (select start_date_time FROM event_schedule where
event_schedule.event_id=event.unique_id order by
CASE WHEN DATEDIFF(`start_date_time`, CURDATE())  < 0 THEN 1 ELSE 0 END, DATEDIFF(`start_date_time`, CURDATE())
LIMIT 1) start_date from
event
where
(select start_date_time FROM event_schedule where
event_schedule.event_id=event.unique_id order by
CASE WHEN DATEDIFF(`start_date_time`, CURDATE())  < 0 THEN 1 ELSE 0 END, DATEDIFF(`start_date_time`, CURDATE())
LIMIT 1)>=CURDATE() limit 3"));

        return response()->json(['data' => $events]);

    }

    public function show($id){
        $event = Models\Event::with('schedules')->with('contacts')->find($id);

        $resource = new Item($event, new EventTransformer(['includes'=>['schedules']]));

        return $this->fractal->createData($resource)->toJson();

    }
}