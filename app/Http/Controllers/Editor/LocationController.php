<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use App\Models\Location; 
use Validator;
use Response;
use App\Post;
use View;

class LocationController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'location_name' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $locations = Location::all();
      return view ('editor.location.index', compact('locations'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = Location::orderBy('location_name', 'ASC')->get();

        return Datatables::of($itemdata) 
        ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->location_name."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
        })
        ->toJson();
      } else {
        exit("No data available");
      }
    }

    public function store(Request $request)
    { 
      $validator = Validator::make($request->all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = new Location(); 
        $post->location_name = $request->location_name; 
        $post->longitude = $request->longitude; 
        $post->latitude = $request->latitude; 
        $post->status = $request->status;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function edit($id)
    {
      $location = Location::Find($id);
      echo json_encode($location); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Location::Find($id); 
        $post->location_name = $request->location_name; 
        $post->longitude = $request->longitude; 
        $post->latitude = $request->latitude; 
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function delete($id)
    {
      $post =  Location::Find($id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;    

     foreach($idkey as $key => $id)
     {
      $post = Location::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }
}
