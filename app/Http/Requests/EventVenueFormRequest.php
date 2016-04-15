<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/15/16
 * Time: 10:28 AM
 */


namespace ArtsAndHumanities\Http\Requests;

use ArtsAndHumanities\Http\Requests;

class EventVenueFormRequest extends EventAttributeFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        parent::rules();
 
        return [
            'description'=>'required|description_exists:venue,description,id'
        ];
    }
}