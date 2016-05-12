<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 5/8/16
 * Time: 11:27 AM
 */


namespace ArtsAndHumanities\Http\Controllers;
use Validator;
use Illuminate\Database\Eloquent\Collection;

use ArtsAndHumanities\Http\Requests;
use ArtsAndHumanities\Models as Models;


use Illuminate\Support\Facades\Input as Input;
use Symfony\Component\HttpFoundation\Request;
use Yajra\Datatables\Datatables;


class AdministratorsController extends Controller
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

       return  view('admins.index')
           ->with('pageTitle',
           'Manage Administrators')
           ->with('admins',$this->buildData());

    }

    public function jsonData(){
        return $this->buildData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function add()
    {

        $modal = new \StdClass();

        $modal->content = view('admins.add');
        $modal->title = 'Add new administrator';

        return view('partials._modal', array('model' => $modal));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function save(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'username' => 'required'
        ]);


        if(!$validator->fails()){

            $result = \DB::table('administrator')
                ->select( \DB::raw( 1 ) )
                ->where( 'username','=', $data['username'] )
                ->whereNull('deleted_at')
                ->first();

            if (isset($result)) {
                $validator->errors()->add('username', 'User already exists in the database');
                return view('partials._formerrors')->with('errors',$validator->errors());
            }

            $admin = new Models\Administrator();
            $admin->username = $request['username'];
            $admin->first_name = $request['first_name'];
            $admin->last_name = $request['last_name'];
            $admin->update_user = $this->currentUser;

            $admin->save();

            // redirect
            \Session::flash('message', 'Successfully added a new administrator!');
            return "true";

        }

         return view('partials._formerrors')->with('errors',$validator->errors());

        //save
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

        $admin = Models\Administrator::where('id', '=', $id)->first();
        $model = new \StdClass;

        if (isset($admin)) {
            $model->content = view('admins.view', array('model' => $admin));
            $model->title = $admin->last_name.", ".$admin->first_name;
        } else {
            $model->title = 'Not Found';
            $model->content = 'Admin not found.';
        }

        return view('partials._modal', array('model' => $model));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function delete($id)
    {

        Models\Administrator::where("id", "=", $id)->delete();

        \Session::flash('message', 'Successfully deleted the administrator!');
        return \Redirect::to('admins');
    }


    protected function buildData(){
        $admins = new Collection;
        // get all the administrators
        $data = Models\Administrator::all();

        // view/delete link
        foreach($data as $item){

            $admin['id'] = $item->id;

            $view = \URL::to("/admins" . '/view/' . $item->id);
            $delete = \URL::to("/admins" . '/delete/' . $item->id);

            $admin['username'] = $item->username;
            $admin['first_name'] = $item->first_name;
            $admin['last_name'] = $item->last_name;
            $admin['date'] = date("F j, Y", strtotime($item->updated_at));
            $admin['update_user'] = $item->update_user;

            $view_link = "<a data-reveal-id=\"viewModal\"
             class=\"modal\" onclick=\"loadModalWindow(this);return false;\" href='" . $view . "'>View  </a>";
            $delete_link = "<a href='" . $delete . "'>Delete  </a>";


            $admin['action'] = $view_link . " | " . $delete_link;

            $admins->push($admin);

        }

        return Datatables::of($admins)->make(true);

    }

}