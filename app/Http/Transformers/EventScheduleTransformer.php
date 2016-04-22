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

class EventScheduleTransformer extends TransformerAbstract
{

    private $params = [];

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     *
     * @param Models\Event $event
     * @param bool $short - summary, schedule, short description or description
     */
    public function transform(Models\Schedule $schedule)
    {

        $build_schedule = function () use ($schedule) {
            return ['start_date' => $schedule->start_date,
                'end_date' => $schedule->end_date,
                'start_time' => str_replace("pm","p.m.",str_replace("am","a.m.",$schedule->start_time)),
                'end_time' =>  str_replace("pm","p.m.",str_replace("am","a.m.",$schedule->end_time))
                ];
        };

        return $build_schedule();
    }


}