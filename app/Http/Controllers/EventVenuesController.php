<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Models as Models;
use ArtsAndHumanities\Http\Requests;

class EventVenuesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        // get all the types
        $venues = Models\Venue::all()->toArray();

         // edit/delete link
        $content = array_map(function($item){

            $e['description']=$item['description'];
            $e['date'] = date("F j, Y",strtotime($item['updated_at']));
            $e['updated by']= $item['update_user'];
            $edit_link = "<a  href='eventVenues/".$item['id']."/edit'>Edit </a>";
            $delete_link = "<a  href='eventVenues/".$item['id']."/delete'>Delete </a>";

            $e['action'] = $edit_link." | ".$delete_link;
            return $e;
        },$venues);

        // load the view and pass the types
        return view('eventVenues.index')->with('pageTitle','Manage Event Venues')
            ->with('collection', $content);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('eventVenues.create')->with('form_title','Create event venue')->with('pageTitle','Create event venue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store( Requests\EventVenueFormRequest $request)
    {

        //save
        $type = new Models\Venue();
        $type->description       = $request->description;
        $type->update_user      = $this->currentUser;
        $type->save();

        // redirect
        \Session::flash('message', 'Successfully created event venue!');
        return \Redirect::to('eventVenues');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        $type = Models\Venue::where('id','=',$id)->first();
        $model = new \StdClass;

        if(isset($type)){
            $model->content= view('eventVenues.show', array('model'=>$type));
            $model->title= $type->descritpion;
        }else{
            $model->title= 'Not Found';
            $model->content='Type was not found.';
        }

        return view('partials._modal',array('model'=>$model));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $venue = Models\Venue::find($id);

        return view('eventVenues.edit')->with('form_title','Edit event venue')->with('pageTitle','Edit event venue')
            ->with('model',$venue);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Requests\EventVenueFormRequest $request)
    {
        // store
        $type = Models\Venue::find($id);
        $type->description       = $request->description;
        $type->update_user    = $this->currentUser;

        $type->save();

        // redirect
        \Session::flash('message', 'Successfully updated event venue!');
        return \Redirect::to('eventVenues');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {

        Models\Venue::where("id","=",$id)->delete();

        \Session::flash('message', 'Successfully deleted the event venue!');
        return \Redirect::to('eventVenues');
    }
}
