<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/20/16
 * Time: 1:37 PM
 */

namespace ArtsAndHumanities\Http\Transformers;

use ArtsAndHumanities\Models as Models;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['schedules', 'venue', 'types'];
    private $params = [];
    protected $base_transformer;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->base_transformer = new BaseTransformer();

    }

    /**
     *
     * @param Models\Event $event
     * @param bool $short - summary, schedule, short description or description
     */
    public function transform(Models\Event $event)
    {
        $short = $this->params['short'];

        if ($short)
            return [
                'id' => $event->unique_id,
                'description' => $this->base_transformer->truncateDesc($event->description, 250),
                'short_description' => $event->short_description,
                'summary'=>$event->summary,
                'event_url'=>$event->event_url,
                'thumbnail_url' =>
                    isset($event->website_image_url_small) &&
                    $event->website_image_url_small != '' ?
                        \URL::to("events/images/" . basename($event->website_image_url_small)) :
                        $event->image_url_small

            ];

    }


    public function includeSchedules(Models\Event $event)
    {

        return $this->collection($event->schedules, new EventScheduleTransformer($this->params));
    }

    public function includeVenue(Models\Event $event)
    {
        $venue = $event->venue;
        if (isset($venue))
            return $this->item($venue, new EventVenueTransformer);
    }

    public function includeTypes(Models\Event $event)
    {
        $types = $event->types;
        if (isset($types))
            return $this->collection($types, new EventTypeTransformer());
    }

}