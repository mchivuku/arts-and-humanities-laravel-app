<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 2:02 PM
 */


namespace ArtsAndHumanities\Models;

use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{

    /**
     *
     * @param $key_name
     * @param $key_value
     * @param $formatted_array
     * @return mixed
     */
    public static function createOrUpdate($key_name,$key_value,$formatted_array) {
        $row = Model::where($key_name,'=',$key_value)->first();//unique_id - determines unique event
        if ($row === null) {
            Model::create($formatted_array);
        } else {
            $row->update($formatted_array);
        }
        $affected_row = Model::where($key_name,'=',$key_value)->first();
        return $affected_row;
    }

}