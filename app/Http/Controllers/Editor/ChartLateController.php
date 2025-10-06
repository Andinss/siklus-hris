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

class ChartlateController extends Controller
{
  
  public function index()
  {  

  	$sql = 'SELECT
				COUNT(absence.id) AS id,
				position.positionname
			FROM
				absence
			INNER JOIN employee ON absence.employeeid = employee.id
          	LEFT JOIN department ON employee.departmentid = department.id
          	LEFT JOIN position ON employee.positionid = position.id
			LEFT JOIN shift ON absence.shiftid = shift.id
			WHERE
				absence.holiday <> 1
			AND absence.actualout <> "00:00:00"
			AND cast(
				time_to_sec(shift.starttime) / (60 * 60) AS DECIMAL (10, 1)
			) < cast(
				time_to_sec(absence.actualin) / (60 * 60) AS DECIMAL (10, 1)
			)
			GROUP BY position.positionname';
     $latebyposition = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


 	$sql1 = 'SELECT
				COUNT(absence.id) AS id,
				department.departmentname
			FROM
				absence
			INNER JOIN employee ON absence.employeeid = employee.id
			LEFT JOIN department ON employee.departmentid = department.id
			LEFT JOIN shift ON absence.shiftid = shift.id
			WHERE
				absence.holiday <> 1
			AND absence.actualout <> "00:00:00"
			AND cast(
				time_to_sec(shift.starttime) / (60 * 60) AS DECIMAL (10, 1)
			) < cast(
				time_to_sec(absence.actualin) / (60 * 60) AS DECIMAL (10, 1)
			)
			GROUP BY
				department.departmentname';
     $leavebydepartment = DB::table(DB::raw("($sql1) as rs_sql"))->get(); 


    return view ('editor.chartlate.index', compact('latebyposition', 'leavebydepartment'));
  } 
}
