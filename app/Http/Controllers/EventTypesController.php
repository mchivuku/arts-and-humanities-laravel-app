<?php

namespace ArtsAndHumanities\Http\Controllers;

use ArtsAndHumanities\Models as Models;
use ArtsAndHumanities\Http\Requests;
use Illuminate\Support\Facades\Input as Input;
class EventTypesController extends Controller
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
        $types = Models\Type::orderBy('sort_order')->get()->toArray();

         // edit/delete link
        $content = array_map(function($item){

            $e['id']=$item['id'];
            $e['description']=$item['description'];
            $e['date'] = date("F j, Y",strtotime($item['updated_at']));
            $e['updated by']= $item['update_user'];
            $edit_link = "<a  href='eventTypes/".$item['id']."/edit'>Edit </a>";
            $delete_link = "<a  href='eventTypes/".$item['id']."/delete'>Delete </a>";

            $e['action'] = $edit_link." | ".$delete_link;
            return $e;
        },$types);

        // load the view and pass the types
        return view('eventTypes.index')->with('pageTitle','Event Types')
            ->with('collection', $content);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('eventTypes.create')->with('pageTitle','Create event type')
            ;
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

        $type = Models\Type::where('id','=',$id)->first();
        $model = new \StdClass;

        if(isset($type)){
            $model->content= view('eventTypes.show', array('model'=>$type));
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
        $event = Models\Type::find($id);

        return view('eventTypes.edit')->with('form_title','Edit event type')->with('pageTitle','Edit event type')
            ->with('model',$event);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Requests\EventTypeFormRequest $request)
    {
        // store
        $type = Models\Type::find($id);
        $type->description       = $request->description;
        $type->update_user    = $this->currentUser;

        $type->save();

        // redirect
        \Session::flash('message', 'Successfully updated event type!');
        return \Redirect::to('eventTypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {

        Models\Type::where("id","=",$id)->delete();

        \Session::flash('message', 'Successfully deleted the event type!');
        return \Redirect::to('eventTypes');
    }

    public function saveOrder(){
        $inputs = Input::all();

        $ids = $inputs['id'];

        $count = 1;


        foreach ($ids as $id) {

            $pdo = \DB::getPdo();
            $q = "UPDATE type set sort_order = " . $count. " WHERE id = " . $id . ";";

            $pdo->exec($q);

            $count++;
        }


        // redirect
        \Session::flash('message', 'Successfully save the order!');
        return \Redirect::to('eventTypes');
    }
}
