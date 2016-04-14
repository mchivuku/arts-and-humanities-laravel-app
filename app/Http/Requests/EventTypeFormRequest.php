<?php

namespace ArtsAndHumanities\Http\Requests;

use ArtsAndHumanities\Http\Requests;

class EventTypeFormRequest extends Request
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
        // Help - from laravel discussions
        \Validator::extend( 'description_exists', function ( $attribute, $value, $parameters, $validator ) {

            // first parameter is the table name
            $table = array_shift( $parameters );

            $fields = [ $attribute => $value ];

            while ( $field = array_shift( $parameters ) ) {
                $fields[ $field ] = $this->get( $field );
            }

            $result = \DB::table( $table )->select( \DB::raw( 1 ) )->where( $fields )->first();

            return empty( $result ); // edited here
        }, 'Description value exists in the database' );


        return [
            'description'=>'required|description_exists:type,description'
        ];
    }
}
