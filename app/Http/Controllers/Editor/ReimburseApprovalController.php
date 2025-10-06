<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReimburseRequest;
use App\Http\Controllers\Controller;
use App\Models\Reimburse; 
use App\Models\ReimburseDetail;
use App\Models\MedicalType;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Year;
use App\Models\Month;
use App\Models\PayrollPeriod;
use Validator;
use Response;
use App\Post;
use View;

class ReimburseApprovalController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
  'transdate' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $reimburses = Reimburse::all();
      return view ('editor.reimburse_approval.index', compact('reimburses'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  reimburse.id,
                  reimburse.code_trans,
                  reimburse.no_trans,
                  reimburse.date_trans,
                  reimburse.employee_id,
                  employee.nik,
                  employee.employee_name,
                  reimburse.department_id,
                  department.department_name,
                  reimburse.medical_type_id,
                  medical_type.medical_type_name,
                  reimburse.period_id,
                  period.description,
                  reimburse.patient_name,
                  FORMAT(reimburse.plafond,0) AS plafond,
                  FORMAT(reimburse.used,0) AS used,
                  FORMAT(reimburse.remain,0) AS remain,
                  reimburse.remark,
                  reimburse.status
                FROM
                  reimburse
                LEFT JOIN employee ON reimburse.employee_id = employee.id
                LEFT JOIN department ON reimburse.department_id = department.id
                LEFT JOIN medical_type ON reimburse.medical_type_id = medical_type.id
                LEFT JOIN period ON reimburse.period_id = period.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return DataTables::of($itemdata) 
        ->addColumn('action', function ($itemdata) {
          return '<a href="reimburse-approval/detail/'.$itemdata->id.'" title="'."'".$itemdata->no_trans."'".'" class="btn btn-sm btn-outline-primary" onclick="edit('."'".$itemdata->id."'".')"><i class="fas fa-book"></i> Detail</a>';
        })
        ->addColumn('mstatus', function($itemdata){
          if ($itemdata->status == 0) {
            return '<span class="label label-success"> Open </span>';
          }else{
           return '<span class="label label-warning"> Approve </span>';
          };
        })
        ->rawColumns(['action', 'mstatus'])
        ->toJson();
      } else {
        exit("No data available");
      }
    }
 
  public function detail($id)
    {
      $employee_list = Employee::all()->pluck('employee_name', 'id'); 
      $reimburse_type_list = MedicalType::all()->pluck('medical_type_name', 'id'); 
      $month_list = Month::all()->pluck('monthname', 'id'); 
      $year_list = Year::all()->pluck('yearname', 'yearname'); 
      $department_list = Department::all()->pluck('department_name', 'id'); 

      $sql_day_work = 'SELECT
                          DATEDIFF(
                            reimburse.date_trans,
                            employee.join_date
                          ) AS day_work
                        FROM
                          employee
                        INNER JOIN reimburse ON employee.id = reimburse.employee_id
                        WHERE
                          reimburse.id = '.$id.'';  
      $day_work = DB::table(DB::raw("($sql_day_work) as rs_sql"))->first();  

      // $reimburse = Reimburse::Find($id); 
      $sql = 'SELECT
                reimburse.id ,
                reimburse.code_trans ,
                reimburse.no_trans ,
                date_format(
                  reimburse.date_trans ,
                  "%d-%m-%Y"
                ) AS date_trans ,
                reimburse.employee_id ,
                reimburse.department_id ,
                reimburse.medical_type_id ,
                reimburse.period_id ,
                reimburse.patient_name ,
                FORMAT(reimburse.plafond , 0) AS plafond ,
                FORMAT(reimburse.used , 0) AS used ,
                FORMAT(reimburse.remain , 0) AS remain ,
                FORMAT(reimburse.claim_amount , 0) AS claim_amount ,
                reimburse.remain AS remain_val ,
                reimburse.remark ,
                reimburse.`status` ,
                employee.nik ,
                employee.employee_name ,
                department.department_name ,
                position.position_name ,
                medical_type.medical_type_name ,
                period.description
              FROM
                reimburse
              LEFT JOIN employee ON reimburse.employee_id = employee.id
              LEFT JOIN department ON employee.department_id = department.id
              LEFT JOIN position ON employee.position_id = position.id
              LEFT JOIN medical_type ON reimburse.medical_type_id = medical_type.id
              LEFT JOIN period ON reimburse.period_id = period.id
              WHERE reimburse.id ='.$id.'';
      $reimburse = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

       $sql = 'SELECT
                reimburse_detail.id AS id,
                reimburse_detail.trans_id,
                reimburse_detail.description,
                reimburse_detail.date_claim,
                reimburse_detail.quantity,
                reimburse_detail.amount AS amount,
                reimburse_detail.no_ref
              FROM
                reimburse_detail
              WHERE reimburse_detail.trans_id = '.$id.' AND reimburse_detail.deleted_at IS NULL';
      $reimburse_detail = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


      return view ('editor.reimburse_approval.form', compact('employee_list', 'reimburse', 'reimburse_type_list', 'month_list', 'year_list', 'department_list', 'day_work', 'reimburse_detail'));
    } 

    public function store(Request $request)
    { 

      $userid= Auth::id();
      $code_trans = $request->input('code_trans'); 

       DB::insert("INSERT INTO reimburse (code_trans, no_trans, date_trans, created_by, created_at)
      SELECT '".$code_trans."',
      IFNULL(CONCAT('".$code_trans."','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(RIGHT(reimburse.no_trans,5)),5))+100001,5)), CONCAT('".$code_trans."','-',DATE_FORMAT(NOW(), '%d%m%y'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW()) 
      FROM
      reimburse
      WHERE code_trans= '".$code_trans."'");

      $lastInsertedID = DB::table('reimburse')->max('id');
      //return redirect()->action('Editor\ReimburseController@edit', $lastInsertedID->id);
      return redirect('editor/reimburse/detail/'.$lastInsertedID.''); 
    }
 

    public function update($id, Request $request)
    { 
        $post = Reimburse::Find($id);  
        $post->status = 1;   
        $post->updated_by = Auth::id();
        $post->save();

        return redirect('editor/reimburse-approval');   
      
    }
}
