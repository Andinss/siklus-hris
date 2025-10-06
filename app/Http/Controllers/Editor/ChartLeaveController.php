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

class ChartleaveController extends Controller
{
  
  public function index()
  {  

  	$sql = 'SELECT
				COUNT(leaving.id) AS id,
				absencetype.absencetypename
			FROM
				leaving
			INNER JOIN absencetype ON leaving.absencetypeid = absencetype.id
			GROUP BY
				absencetype.absencetypename';
     $leavebylesvetype = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


 	$sql_date = 'SELECT
					Count(leaving.id) AS id,
					DATE_FORMAT(leaving.datetrans, "%d-%m-%Y") AS datetrans
				FROM
					leaving
				GROUP BY
					leaving.datetrans';
     $leavebydate = DB::table(DB::raw("($sql_date) as rs_sql"))->get(); 

     // dd($leavebylesvetype);

    return view ('editor.chartleave.index', compact('leavebylesvetype', 'leavebydate'));
  } 
}
