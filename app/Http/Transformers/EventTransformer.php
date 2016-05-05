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

        if(isset($params['includes']))
        {
            $this->defaultIncludes=$params['includes'];
        }


        $this->base_transformer = new BaseTransformer();

    }

    /**
     *
     * @param Models\Event $event
     * @param bool $short - summary, schedule, short description or description
     */
    public function transform(Models\Event $event)
    {

        if (isset($this->params['short']))
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
                        $event->image_url_small,
                'repeat_message'=>$this->base_transformer->getRepeatMessage($event->event_url)

            ];


        return [
            'id' => $event->unique_id,
            'description' => $event->description,
            'short_description' => $event->short_description,
            'summary'=>$event->summary,
            'event_url'=>$event->event_url,
            'thumbnail_url' =>
                isset($event->website_image_url_small) &&
                $event->website_image_url_small != '' ?
                    \URL::to("events/images/" . basename($event->website_image_url_small)) :
                    $event->image_url_small,

            'large_image_url' => $event->image_url_large,
            'cost'=>$event->cost,
            'contact_email'=>$event->contact_email,
            'more_contact_info'=>$event->more_contact_info,
            'other_info'=>$event->other_info,
            'contacts'=>$event->contacts()->get()->implode('contact_info', ', '),
            'repeat_message'=>$this->getRepeatMessage($event),
            'url'=>$event->url

        ];


    }

    public function includeSchedules(Models\Event $event)
    {

        return $this->collection($event->schedules, new EventScheduleTransformer($this->params));
    }

    public function includeSchedulesOrderByToday(Models\Event $event){
        return $this->collection($event->schedulesOrderByToday, new EventScheduleTransformer($this->params));
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

    public function getRepeatMessage(Models\Event $event){
        return $this->base_transformer->getRepeatMessage($event->event_url);
    }

}