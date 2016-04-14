<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Services\HtmlMacros;
use Collective\Html\HtmlBuilder;
use Illuminate\Http\Request;
use ArtsAndHumanities\Models as Models;
use ArtsAndHumanities\Http\Requests;

class EventTypeController extends Controller
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
        $types = Models\Type::all()->toArray();

         // edit/delete link
        $types = array_map(function($item){
            $edit= "{{ URL::to('/' . '".$item['id']."') }}";
            $item['link'] = "";
            $item['link'] .= "|". "<a  class='button tiny round' href='$edit'>Delete</a>";
            return $item;
        },$types);

        // load the view and pass the types
        return view('eventTypes.index')
            ->with('collection', $types);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('eventTypes.create')->with('form_title','Create event type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store( Requests\EventTypeFormRequest $request)
    {

        //save
        $type = new Models\Type();
        $type->description       = $request->description;
        $type->update_user      = $this->currentUser;
        $type->save();

        // redirect
        \Session::flash('message', 'Successfully created event type!');
        return \Redirect::to('eventTypes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
