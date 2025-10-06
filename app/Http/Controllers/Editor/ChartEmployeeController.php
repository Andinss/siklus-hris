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

class ChartemployeeController extends Controller
{
  
  public function index()
  {  

  	$sql = 'SELECT
				position.positionname,
				COUNT(employee.id) AS id
			FROM
				employee
			INNER JOIN position ON employee.positionid = position.id
			GROUP BY
				position.positionname';
     $employeebyposition = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


 	$sql_dept = 'SELECT
					department.departmentname,
					COUNT(employee.id) AS id
				FROM
					employee
				INNER JOIN department ON employee.departmentid = department.id
				GROUP BY
					department.departmentname';
     $employeebydept = DB::table(DB::raw("($sql_dept) as rs_sql"))->get();

     $sql_sex = 'SELECT
				COUNT(employee.id) AS id,
					CASE
				WHEN employee.sex = 1 THEN
					"Laki-laki"
				ELSE
					CASE
				WHEN employee.sex = 2 THEN
					"Perempuan"
				END
				END AS sex
				FROM
					employee
				GROUP BY
					employee.sex';
     $employeebysex = DB::table(DB::raw("($sql_sex) as rs_sql"))->get(); 

     $sql_edu = 'SELECT
					educationlevel.educationlevelname,
					COUNT(employee.id) AS id
				FROM
					employee
				INNER JOIN educationlevel ON employee.educationlevelid = educationlevel.id
				GROUP BY
					educationlevel.educationlevelname';
     $employeebyedu = DB::table(DB::raw("($sql_edu) as rs_sql"))->get(); 

    return view ('editor.chartemployee.index', compact('employeebyposition', 'employeebydept', 'employeebysex', 'employeebyedu'));
  } 
}
