<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PositionRequest;
use App\Http\Controllers\Controller;
use App\Models\Position; 
use Validator;
use Response;
use App\Post;
use View;

class PositionController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'position_name' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $positions = Position::all();
      return view ('editor.position.index', compact('positions'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = Position::orderBy('position_name', 'ASC')->get();

        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->position_name."'".')"><i class="fas fa-trash-alt"></i> Delete</a>';
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
        $post = new Position(); 
        // $post->position_code = $request->position_code;
        $post->position_name = $request->position_name; 
        $post->status = $request->status;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function edit($id)
    {
      $position = Position::Find($id);
      echo json_encode($position); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Position::Find($id); 
        // $post->position_code = $request->position_code;
        $post->position_name = $request->position_name; 
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function delete($id)
    {
      $post =  Position::Find($id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;    

     foreach($idkey as $key => $id)
     {
      $post = Position::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }
}
