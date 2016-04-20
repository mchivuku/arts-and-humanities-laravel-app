<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:02 PM
 */

namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends BaseModel
{
    protected $table = 'event';
    public $incrementing = false;
    public $primaryKey = 'unique_id';
     /*
     * Relationships
     */
    public function attachments()
    {
        return $this->belongsToMany('Attachement', 'event_attachement','unique_id','event_id');
    }



    public function categories(){
        return $this->belongsToMany('Category',
            'event_category','id','event_id');
    }

    public function contacts(){
        return $this->belongsToMany('ArtsAndHumanities\Models\Contact',
            'event_contact','unique_id','event_id');
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
        return $this->hasMany('ArtsAndHumanities\Models\Schedule','event_id','unique_id');
    }

    public $type_ids;



}
