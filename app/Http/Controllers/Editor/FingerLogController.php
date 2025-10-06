<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollRequest;
use App\Http\Controllers\Controller;
use App\Models\Payroll; 
use App\Models\Payperiod;
use App\Models\Department;
use App\Models\Employee;
use Validator;
use Response;
use App\Post;
use View;
use App\User;

class FingerlogController extends Controller
{
  
  public function index()
  { 
    $datafilter = User::where('id', Auth::id())->first();
    $department_list = Department::all()->pluck('departmentname', 'id');
    $payperiod_list = Payperiod::all()->pluck('description', 'id');
    $employee_list = Employee::all()->pluck('employeename', 'id');
    return view ('editor.fingerlog.index', compact('department_list','payperiod_list','employee_list','datafilter'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $userid = Auth::id();
      $sql = 'SELECT
                absence_log.nik,
                absence_log.scan_date
              FROM
                absence_log, user
              WHERE absence_log.scan_date BETWEEN user.begindate AND user.enddate
              AND user.id = '.Auth::id().'';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata)  

      ->make(true);
    } else {
      exit("No data available");
    }
  } 
}
