<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EducationLevelRequest;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel; 
use Validator;
use Response;
use App\Post;
use View;

class EducationLevelController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'education_level_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.education_level.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $education_level = EducationLevel::orderBy('education_level_name', 'ASC')->get();

      return DataTables::of($education_level)  

      ->addColumn('action', function ($education_level) {
        return '<a href="#" onclick="edit('."'".$education_level->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$education_level->id."', '".$education_level->education_level_name."'".')"><i class="fas fa-trash-alt"></i> Delete</a>';
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
      $post = new EducationLevel(); 
      $post->education_level_name = $request->education_level_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $education_level = EducationLevel::Find($id);
    echo json_encode($education_level); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = EducationLevel::Find($id); 
      $post->education_level_name = $request->education_level_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  EducationLevel::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
