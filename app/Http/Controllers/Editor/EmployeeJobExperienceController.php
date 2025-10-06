<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeejobexperienceRequest;
use App\Http\Controllers\Controller;
use App\Models\Employeejobexperience; 
use App\Models\Employee;
use App\Models\Position;
use Validator;
use Response;
use App\Post;
use View;

class EmployeejobexperienceController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'yearfrom' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index($id)
  {
    $employee = Employee::where('id', $id)->first();
    $position_list = Position::all()->pluck('positionname', 'id'); 

    return view ('editor.employeejobexperience.index', compact('employee', 'position_list'));
  }

  public function data(Request $request, $id)
  {   
    if($request->ajax()){ 

       $sql = 'SELECT
                employeejobexperience.id,
                employeejobexperience.employeeid,
                employeejobexperience.yearfrom,
                employeejobexperience.yearto,
                employeejobexperience.company,
                employeejobexperience.businesstype,
                employeejobexperience.positionid,
                position.positionname,
                employeejobexperience.reportto,
                employeejobexperience.lastsalary,
                employeejobexperience.directhead,
                employeejobexperience.`status`
              FROM
                employeejobexperience
              INNER JOIN position ON employeejobexperience.positionid = position.id
               WHERE employeejobexperience.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->where('employeeid', $id)->orderBy('id', 'ASC')->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a class="btn btn-xs btn-danger"  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->positionname."'".')"> <i class="fa fa-trash"></i></a> <a class="btn btn-xs btn-success"  href="javascript:void(0)" title="Delete" onclick="edit('."'".$itemdata->id."', '".$itemdata->positionname."'".')"> <i class="fa fa-pencil"></i></a>';
      })

      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
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
      $post = new Employeejobexperience(); 
      $post->positionid = $request->positionid; 
      $post->yearfrom = $request->yearfrom;
      $post->yearto = $request->yearto;
      $post->company = $request->company;
      $post->businesstype = $request->businesstype;
      $post->lastsalary = $request->lastsalary;
      $post->directhead = $request->directhead; 
      $post->employeeid = $id;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {

    $employeejobexperience = Employeejobexperience::Find($id);
    echo json_encode($employeejobexperience); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
      return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = Employeejobexperience::Find($id); 
      $post->positionid = $request->positionid; 
      $post->yearfrom = $request->yearfrom;
      $post->yearto = $request->yearto;
      $post->company = $request->company;
      $post->businesstype = $request->businesstype;
      $post->lastsalary = $request->lastsalary; 
      $post->directhead = $request->directhead; 
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  Employeejobexperience::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
 
}
