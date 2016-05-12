<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:02 PM
 */

namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends BaseModel
{

    use SoftDeletes;

    protected $softDelete = true;


    protected $table = 'event';
    public $incrementing = false;
    public $primaryKey = 'unique_id';
     /*
     * Relationships
     */
    public function attachments()
    {
        return $this->belongsToMany('Attachment', 'event_attachment','unique_id','event_id');
    }

    public function categories(){
        return $this->belongsToMany('Category',
            'event_category','id','event_id');
    }

    public function contacts(){

        return $this->hasMany('ArtsAndHumanities\Models\Contact',
           'event_id','unique_id');
    }

    public function types(){

        return $this->belongsToMany('ArtsAndHumanities\Models\Type', "event_type", "event_id", "type_id")
            ->withPivot("update_user")
            ->whereEventId($this->unique_id);
    }

    public function venue(){
        return $this->hasOne("ArtsAndHumanities\Models\Venue","id","venue_id");
    }

    public function schedules(){
        return $this->hasMany('ArtsAndHumanities\Models\Schedule','event_id','unique_id')
            ->selectRaw(" event_id,
start_date_time,
DATE_FORMAT(start_date_time,'%b %d %Y') start_date,
LOWER(TIME_FORMAT(start_date_time, '%l:%i %p')) start_time,
end_date_time,
DATE_FORMAT(end_date_time,'%b %d %Y') end_date,
LOWER(TIME_FORMAT(end_date_time, '%l:%i %p')) end_time");

    }

    public function review(){
       return $this->hasOne("ArtsAndHumanities\Models\Review","id","review_id");
    }
}
