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

Route::get('/', 'HomeController@index');

//Event Types
Route::resource('eventTypes', 'EventTypesController');
Route::get('/eventTypes/{id}/delete','EventTypesController@delete');

//Event Venues
Route::resource('eventVenues', 'EventVenuesController');
Route::get('/eventVenues/{id}/delete','EventVenuesController@delete');