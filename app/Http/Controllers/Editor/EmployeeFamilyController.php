<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeefamilyRequest;
use App\Http\Controllers\Controller;
use App\Models\Employeefamily; 
use App\Models\Employee;
use App\Models\Employeerelationship;
use App\Models\Educationlevel;
use App\Models\Sex;
use Validator;
use Response;
use App\Post;
use View;

class EmployeefamilyController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'familyname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index($id)
  {
    $employee = Employee::where('id', $id)->first();
    $employeerelationship_list = Employeerelationship::all()->pluck('employeerelationshipname', 'employeerelationshipname'); 
    $educationlevel_list = Educationlevel::all()->pluck('educationlevelname', 'educationlevelname');

    $sex_list = Sex::all()->pluck('sexname', 'sexname');


    return view ('editor.employeefamily.index', compact('employee', 'employeerelationship_list', 'sex_list', 'educationlevel_list'));
  }

  public function data(Request $request, $id)
  {   
    if($request->ajax()){ 
      $itemdata = Employeefamily::where('employeeid', $id)->orderBy('familyname', 'ASC')->get();

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a class="btn btn-xs btn-danger"  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->employeefamilyname."'".')"> <i class="fa fa-trash"></i></a> <a class="btn btn-xs btn-success"  href="javascript:void(0)" title="Delete" onclick="edit('."'".$itemdata->id."', '".$itemdata->employeefamilyname."'".')"> <i class="fa fa-pencil"></i></a>';
      })

      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })

      ->addColumn('mstatus', function ($itemdata) {
        if ($itemdata->status == 0) {
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

  public function store(Request $request, $id)
  { 
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
      return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = new Employeefamily(); 
      $post->familyname = $request->familyname; 
      $post->occupation = $request->occupation;
      $post->lasteducation = $request->lasteducation;
      $post->relationship = $request->relationship;
      $post->emergencycontact = $request->emergencycontact;
      $post->sex = $request->sex;
      $post->datebirth = $request->datebirth;
      $post->employeeid = $id;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

   public function edit($id)
    {

      $employeefamily = Employeefamily::Find($id);
      echo json_encode($employeefamily); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make(Input::all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Employeefamily::Find($id); 
        $post->familyname = $request->familyname;
        $post->occupation = $request->occupation;
        $post->lasteducation = $request->lasteducation;
        $post->relationship = $request->relationship;
        $post->emergencycontact = $request->emergencycontact;
        $post->sex = $request->sex;
        // $post->deleted_at = NULL;
        // $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

  public function delete($id)
  {
    $post =  Employeefamily::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
 
}
