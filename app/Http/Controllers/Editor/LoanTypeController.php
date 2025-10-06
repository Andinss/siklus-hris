<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LoanTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\LoanType; 
use Validator;
use Response;
use App\Post;
use View;

class LoanTypeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'loan_type_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.loan_type.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $loan_type = LoanType::orderBy('loan_type_name', 'ASC')->get();

      return Datatables::of($loan_type)  

      ->addColumn('action', function ($loan_type) {
        return '<a href="#" onclick="edit('."'".$loan_type->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$loan_type->id."', '".$loan_type->loan_type_name."'".')"> <i class="ti-trash"></i> Delete</a>';
      })
      
      ->addColumn('mstatus', function ($loan_type) {
        if ($loan_type->status == 0) {
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
      $post = new LoanType(); 
      $post->loan_type_name = $request->loan_type_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $loan_type = LoanType::Find($id);
    echo json_encode($loan_type); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = LoanType::Find($id); 
      $post->loan_type_name = $request->loan_type_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  LoanType::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
