<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/19/16
 * Time: 9:55 AM
 */

namespace ArtsAndHumanities\Http\Requests;

use ArtsAndHumanities\Http\Requests;

class EventFormRequest extends Request
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
        return [
            'short_description' => 'max:100',
            'website_thumbnail' => 'mimes:jpeg,bmp,png',
            'website_featured' =>'mimes:jpeg,bmp,png'
        ];
    }
}