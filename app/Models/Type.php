<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:33 PM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends BaseModel{

    protected $table = 'type';
    public $timestamps = false;
    protected $fillable = array('description', 'updated_at', 'update_user');

}