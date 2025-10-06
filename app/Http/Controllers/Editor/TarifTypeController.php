<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
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

      return Datatables::of($education_level)  

      ->addColumn('action', function ($education_level) {
        return '<a href="#" onclick="edit('."'".$education_level->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$education_level->id."', '".$education_level->education_level_name."'".')"> <i class="ti-trash"></i> Delete</a>';
      })
      
      ->addColumn('mstatus', function ($education_level) {
        if ($education_level->status == 0) {
          return '<span class="label label-success"> Active </span>';
        }else{
         return '<span class="label label-danger"> Not Active </span>';
       };
     })
      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  { 
    $validator = Validator::make(Input::all(), $this->rules);
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
    $validator = Validator::make(Input::all(), $this->rules);
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
