<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\PayrollType; 
use Validator;
use Response;
use App\Post;
use View;

class PayrollTypeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'payroll_type_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.payroll_type.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $payroll_type = PayrollType::orderBy('payroll_type_name', 'ASC')->get();

      return Datatables::of($payroll_type)  
      ->addColumn('action', function ($payroll_type) {
        return '<a href="#" onclick="edit('."'".$payroll_type->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$payroll_type->id."', '".$payroll_type->payroll_type_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
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
      $post = new PayrollType(); 
      $post->payroll_type_name = $request->payroll_type_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $payroll_type = PayrollType::Find($id);
    echo json_encode($payroll_type); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = PayrollType::Find($id); 
      $post->payroll_type_name = $request->payroll_type_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  PayrollType::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
