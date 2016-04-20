<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:34 PM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends BaseModel{

    protected $table = 'event_type';
    protected $fillable = ['event_id','type_id','update_user'];
    public $timestamps = false;

  //  protected $primaryKey=['event_id','type_id'];


  //public function events(){
    //    $this->hasMany('ArtsAndHumanities\Models\Event','unique_id','event_id');
   // }

   // public function types(){
     //   $this->hasMany('ArtsAndHumanities\Models\Type','id','type_id');
   // }
}