<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimeRequest;
use App\Http\Controllers\Controller;
use App\Models\Overtime; 
use App\Models\Overtimedetail;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Positiongroup;
use App\Models\Shift;
use App\Models\Overtimetype;
use Validator;
use Response;
use App\Post;
use View;

class OvertimeapproveController extends Controller
{
  /**
  * @var array
  */
  protected $rules =
  [ 
  'overtimename' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $overtimes = Overtime::all();
      return view ('editor.overtimeapprove.index', compact('overtimes'));
    }

    public function data(Request $request)
    {   
    if($request->ajax()){ 

      $sql = 'SELECT
                overtimerequest.id,
                overtimerequest.notrans,
                overtimerequest.datetrans,
                overtimerequest.departmentid,
                overtimerequest.departmentcode,
                overtimerequest.datefrom,
                overtimerequest.dateto,
                overtimerequest.remark,
                overtimerequest.`status`,
                department.departmentname,
                positiongroup.positiongroupname,
                shift.shiftname
              FROM
                overtimerequest
              LEFT JOIN department ON overtimerequest.departmentid = department.id
              LEFT JOIN positiongroup ON overtimerequest.positiongroupid = positiongroup.id
              LEFT JOIN shift ON overtimerequest.shiftid = shift.id
              WHERE
                overtimerequest.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })

      ->addColumn('action', function ($itemdata) {
          return '<a href="overtimeapprove/detail/'.$itemdata->id.'" title="'."'".$itemdata->notrans."'".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-check"></i> Approve</a>';
      })

      ->addColumn('mstatus', function ($itemdata) {
        if ($itemdata->status == 0) {
          return '<span class="label label-warning"> Request </span>';
        }elseif($itemdata->status == 1){
         return '<span class="label label-success"> Validate </span>';
       }else{
         return '<span class="label label-danger"> Cancel </span>';
       };

     })
      ->make(true);
    } else {
      exit("No data available");
    }
  }
 
    public function detail($id)
    {
      $employee_list = Employee::all()->pluck('employeename', 'id'); 
      $department_list = Department::all()->pluck('departmentname', 'id');
      $positiongroup_list = Positiongroup::all()->pluck('positiongroupname', 'id');
      $shift_list = Shift::all()->pluck('shiftname', 'id');
      $overtimetype_list = Overtimetype::all()->pluck('overtimetypename', 'id');


      //dd($used_list);
      $overtime = Overtime::Find($id); 
      return view ('editor.overtimeapprove.form', compact('employee_list', 'overtime', 'department_list', 'positiongroup_list', 'shift_list', 'overtimetype_list'));
    }

    public function update($id, Request $request)
    { 
        $post = Overtime::Find($id);   
        $post->status = 1; 
        $post->updated_by = Auth::id();
        $post->save();

        return redirect('editor/overtimeapprove');   
      
    }

    public function updatedetail($id, Request $request)
    { 
      $post = Overtimedetail::where('id', $request->iddetail)->first();  
      $post->work = $request->work; 
      $post->othour = $request->othour;  
      $post->overtimetypeid = $request->overtimetypeid;  
      $post->save();

      return response()->json($post); 
    }

    public function approve($id)
    {
      $employee_list = Employee::all()->pluck('employeename', 'id'); 

      //dd($used_list);
      $overtime = Overtime::Find($id); 
      return view ('editor.overtime.view', compact('employee_list', 'overtime'));
    }

     public function savedetail($id, Request $request)
    { 
        $post = new Overtimedetail;
        $post->transid = $id;  
        $post->employeeid = $request->employeeid;   
        $post->work = $request->work;   
        $post->otin = $request->otin;   
        $post->otout = $request->otout;   
        $post->save();

        return response()->json($post); 
      
    }
    
    public function datadetail(Request $request, $id)
    {   
     
    if($request->ajax()){ 

        $sql = 'SELECT
                  overtimerequestdet.id,
                  overtimerequestdet.transid,
                  overtimerequestdet.employeeid,
                  employee.nik,
                  employee.employeename,
                  overtimetype.overtimetypename,
                  overtimerequestdet.work,
                  overtimerequestdet.otin,
                  overtimerequestdet.otout,
                  overtimerequestdet.othour,
                  overtimerequest.status AS statusheader,
                  overtimerequestdet.status
                FROM
                  overtimerequestdet
                INNER JOIN overtimerequest ON overtimerequestdet.transid = overtimerequest.id
                INNER JOIN employee ON overtimerequestdet.employeeid = employee.id
                LEFT JOIN overtimetype ON overtimetype.id = overtimerequestdet.overtimetypeid
                WHERE overtimerequestdet.transid = '.$id.' AND overtimerequestdet.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

       return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        if($itemdata->statusheader == 1){
          return '<span class="label label-success"> Has been Validate </span>';
        }else{
        return '<a  href="javascript:void(0)" title="Edit" class="btn btn-primary btn-xs" onclick="update_id(this, '."'".$itemdata->id."', '".$itemdata->employeeid."'".')"><i class="fa fa-pencil"></i></a> <a  href="javascript:void(0)" title="Approve" class="btn btn-success btn-xs" onclick="approve('."'".$itemdata->id."', '".$itemdata->employeename."'".')"><i class="fa fa-check"></i> </a> <a  href="javascript:void(0)" title="Not Approve" class="btn btn-danger btn-xs" onclick="notapprove('."'".$itemdata->id."', '".$itemdata->employeename."'".')"><i class="fa fa-cut"></i> </a>';
        };
      })

      ->addColumn('mstatus', function ($itemdata) { 
          if ($itemdata->status == 0 || $itemdata->status == '') {
            return '<span class="label label-warning"> Request </span>';
          }elseif ($itemdata->status == 1){
            return '<span class="label label-success"> Approve </span>';
          }else{
            return '<span class="label label-danger"> Not Approve </span>';
          }; 

       })
   
      ->make(true);
    } else {
      exit("No data available");
    }
    }

    public function editdetail($id)
    {
      $datadetail = Overtimedetail::Find($id);
      echo json_encode($datadetail); 
    }

    public function storeapprove($id)
    {
      $post =  Overtimedetail::Find($id);
      $post->status = 1;
      $post->save(); 

      return response()->json($post); 
    }

    public function storenotapprove($id)
    {
      $post =  Overtimedetail::Find($id);
      $post->status = 2;
      $post->save(); 

      return response()->json($post); 
    }
}
