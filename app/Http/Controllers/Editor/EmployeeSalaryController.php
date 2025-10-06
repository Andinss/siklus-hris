<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use App\Models\Employee; 
use App\Models\City;
use Validator;
use Response;
use App\Post;
use View;

class EmployeesalaryController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'basic' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $employeesalarys = City::all();
    return view ('editor.employeesalary.index', compact('employeesalarys'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sql = 'SELECT
                employee.id,
                employee.nik,
                employee.identityno,
                employee.employeename, 
                position.positionname,
                employee.basic, 
                employee.postall, 
                employee.mealtransall, 
                employee.overtimeall, 
                employee.extrapudding, 
                employee.rateovertime, 
                employee.mealtransrate, 
                employee.ratetunjanganmalam, 
                employee.ratemealincity, 
                employee.ratemealoutcity,
                employee.status 
                FROM
                employee
                LEFT JOIN department ON employee.departmentcode = department.departmentcode
                LEFT JOIN position ON employee.positionid = position.id
                LEFT JOIN city ON employee.cityid = city.id
                LEFT JOIN educationlevel ON employee.educationlevelid = educationlevel.id
                LEFT JOIN payrolltype ON employee.paytypeid = payrolltype.id
                WHERE
                employee.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Set Salary" class="btn btn-primary btn-xs" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-credit-card"></i> Set Salary</a>';
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

  
  public function edit($id)
  {
    $employeesalary = Employee::Find($id);
    echo json_encode($employeesalary); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Employee::Find($id); 
    $post->basic = $request->basic;
    $post->postall = $request->postall;
    $post->mealtransall = $request->mealtransall;
    $post->overtimeall = $request->overtimeall;
    $post->extrapudding = $request->extrapudding;
    $post->rateovertime = $request->rateovertime;
    $post->mealtransrate = $request->mealtransrate;
    $post->ratetunjanganmalam = $request->ratetunjanganmalam;
    $post->ratemealincity = $request->ratemealincity;
    $post->ratemealoutcity = $request->ratemealoutcity;
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  } 
}
