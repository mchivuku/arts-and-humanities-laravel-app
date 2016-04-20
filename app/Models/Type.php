<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:33 PM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends BaseModel{

    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'type';
    public $timestamps = false;

    protected $fillable = array('description', 'updated_at', 'update_user');

    public function events(){
        return $this->belongsToMany("Event", "event_type", "type_id", "event_id")
            ->withPivot("update_user");
    }
 }