<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function(){
    if(\Session::get('user')=='') return Redirect::to('login');
    return Redirect::to('events');
});


Route::get('/login','HomeController@login' );



//Event Types
Route::group(['middleware' => 'cas'], function()
{



    Route::resource('eventTypes', 'EventTypesController');
    Route::get('/eventTypes/{id}/delete','EventTypesController@delete');

//Event Venues
    Route::resource('eventVenues', 'EventVenuesController');
    Route::get('/eventVenues/{id}/delete','EventVenuesController@delete');

});


//Events
Route::group(['prefix' => 'events','middleware' => 'cas'], function () {
    Route::get('/', 'EventsController@index');
    Route::get('/data', 'EventsController@getEvents');
    Route::get('/results', 'EventsController@results');
    Route::get('/edit/{id}', 'EventsController@edit');
    Route::post('/update', 'EventsController@update');
    Route::get('/show/{id}', 'EventsController@show');
    Route::get('/schedule/{id}', 'EventsController@getSchedules');


});


// NO CAS

Route::get("events/images/{filename}",function($filename){

    $path = public_path()."/images/events/".$filename;
    if(file_exists($path)) {
        $img = (file_get_contents($path));
        $response = Response::make($img);
        $response->header('Content-Type', finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path));
        return $response;
    }

    return "";


});


// API Controller
Route::group(['prefix'=>'api'],function(){
    Route::get('/types', 'APIController@types');
    Route::get('/venues', 'APIController@venues');
    Route::get('/events', 'APIController@events');
    Route::get('/featured','APIController@featuredEvents');
    Route::get('/event/{id}', 'APIController@show');
    Route::get('/blog', 'BlogController@index');
});



