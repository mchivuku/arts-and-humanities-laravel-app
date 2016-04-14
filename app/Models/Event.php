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
    /*
     * Relationships
     */
    public function attachments()
    {
        return $this->belongsToMany('Attachement', 'event_attachement','unique_id','event_id');
    }

    public function recommendations(){
        return $this->belongsToMany('Recommendation',
            'event_recommendation','unique_id','event_id');
    }

    public function categories(){
        return $this->belongsToMany('Category',
            'event_category','unique_id','event_id');
    }

    public function contacts(){
        return $this->belongsToMany('Contact',
            'event_contact','unique_id','event_id');
    }

    public function types(){
        return $this->belongsToMany('Type',
            'event_type','unique_id','event_id');
    }


    public function venue(){
        return $this->hasOne("Venue","venue_id","id");
    }



}
