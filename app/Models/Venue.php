<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:34 PM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends BaseModel{

    use SoftDeletes;
    protected $table = 'venue';
    protected $softDelete = true;
    protected $dates = array('deleted_at');
    public $timestamps = false;
}