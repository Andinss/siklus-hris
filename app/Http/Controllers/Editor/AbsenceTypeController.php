<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AbsenceTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\AbsenceType; 
use Validator;
use Response;
use App\Post;
use View;

class AbsenceTypeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'absence_type_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.absence_type.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $absence_type = AbsenceType::orderBy('absence_type_name', 'ASC')->get();

      return DataTables::of($absence_type)  

      ->addColumn('action', function ($absence_type) {
        return '<a href="#" onclick="edit('."'".$absence_type->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$absence_type->id."', '".$absence_type->absence_type_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
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
      $post = new AbsenceType(); 
      $post->absence_type_name = $request->absence_type_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $absence_type = AbsenceType::Find($id);
    echo json_encode($absence_type); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = AbsenceType::Find($id); 
      $post->absence_type_name = $request->absence_type_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  AbsenceType::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
