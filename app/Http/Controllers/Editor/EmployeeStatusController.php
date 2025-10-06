<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeStatusRequest;
use App\Http\Controllers\Controller;
use App\Models\EmployeeStatus; 
use Validator;
use Response;
use App\Post;
use View;

class EmployeeStatusController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'employee_status_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.employee_status.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $employee_status = EmployeeStatus::orderBy('employee_status_name', 'ASC')->get();

      return DataTables::of($employee_status)  

      ->addColumn('action', function ($employee_status) {
        return '<a href="#" onclick="edit('."'".$employee_status->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$employee_status->id."', '".$employee_status->employee_status_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
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
      $post = new EmployeeStatus(); 
      $post->employee_status_name = $request->employee_status_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $employee_status = EmployeeStatus::Find($id);
    echo json_encode($employee_status); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = EmployeeStatus::Find($id); 
      $post->employee_status_name = $request->employee_status_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  EmployeeStatus::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
