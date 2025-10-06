<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimeTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\OvertimeType; 
use Validator;
use Response;
use App\Post;
use View;

class OvertimeTypeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'overtime_type_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.overtime_type.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $overtime_type = OvertimeType::orderBy('overtime_type_name', 'ASC')->get();

      return DataTables::of($overtime_type)  

      ->addColumn('action', function ($overtime_type) {
        return '<a href="#" onclick="edit('."'".$overtime_type->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$overtime_type->id."', '".$overtime_type->overtime_type_name."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
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
      $post = new OvertimeType(); 
      $post->overtime_type_name = $request->overtime_type_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $overtime_type = OvertimeType::Find($id);
    echo json_encode($overtime_type); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = OvertimeType::Find($id); 
      $post->overtime_type_name = $request->overtime_type_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  OvertimeType::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
