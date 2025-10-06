<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Department; 
use Validator;
use Response;
use App\Post;
use View;

class DepartmentController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'department_name' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $departments = Department::all();
      return view ('editor.department.index', compact('departments'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = Department::orderBy('department_name', 'ASC')->get();

        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->department_name."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
      })->toJson();
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
        $post = new Department(); 
        $post->department_code = $request->department_code;
        $post->department_name = $request->department_name; 
        $post->status = $request->status;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function edit($id)
    {
      $department = Department::Find($id);
      echo json_encode($department); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Department::Find($id); 
        $post->department_code = $request->department_code;
        $post->department_name = $request->department_name; 
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function delete($id)
    {
      $post =  Department::Find($id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;    

     foreach($idkey as $key => $id)
     {
      $post = Department::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }
}
