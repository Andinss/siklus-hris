<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EducationMajorRequest;
use App\Http\Controllers\Controller;
use App\Models\EducationMajor; 
use Validator;
use Response;
use App\Post;
use View;

class EducationMajorController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'education_major_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.education_major.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $education_major = EducationMajor::orderBy('education_major_name', 'ASC')->get();

      return DataTables::of($education_major)  

      ->addColumn('action', function ($education_major) {
        return '<a href="#" onclick="edit('."'".$education_major->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$education_major->id."', '".$education_major->education_major_name."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
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
      $post = new EducationMajor(); 
      $post->education_major_name = $request->education_major_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $education_major = EducationMajor::Find($id);
    echo json_encode($education_major); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = EducationMajor::Find($id); 
      $post->education_major_name = $request->education_major_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  EducationMajor::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
