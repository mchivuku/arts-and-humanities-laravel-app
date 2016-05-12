<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 5/8/16
 * Time: 11:26 AM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends BaseModel{

    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'administrator';
    public $timestamps = false;

    protected $fillable =
        array('username', 'updated_at', 'update_user','first_name','last_name');

}