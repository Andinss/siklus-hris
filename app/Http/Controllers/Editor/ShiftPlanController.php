<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShiftScheduleRequest;
use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use App\Models\Employee;
use App\Models\AbsenceType;
use App\Models\ShiftScheduleCategory;
use App\Models\Period;
use App\Models\Time;
use App\Models\Shift;
use Validator;
use Response;
use App\Post;
use View;

class ShiftPlanController extends Controller
{
  /**
   * @var array
   */
  protected $rules =
  [
    'shift_scheduleno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'shift_schedulename' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $shift_schedules = ShiftSchedule::all();
    return view('editor.shift_plan.index', compact('shift_schedules'));
  }

  public function data(Request $request)
  {
    if ($request->ajax()) {

      $sql = 'SELECT
                  period.id,
                  period.description,
                  period.date_period,
                  period.begin_date,
                  period.end_date,
                  period.pay_date,
                  period.`status`,
                  period.`month`,
                  period.`year`,
                  payroll_type.payroll_type_name
                FROM
                  period
                LEFT JOIN payroll_type ON period.payroll_type_id = payroll_type.id
                WHERE period.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)
        ->addColumn('action', function ($itemdata) {
          return '<a href="shift-plan/' . $itemdata->id . '/edit" title="Detail" class="btn btn-sm btn-outline-primary d-inline-block" onclick="edit(' . "'" . $itemdata->id . "'" . ')"><i class="fa fa-folder"></i> Detail</a> <a href="shift-plan/' . $itemdata->id . '/slip" title="Cetak" class="btn btn-sm btn-outline-secondary d-inline-block" onclick="edit(' . "'" . $itemdata->id . "'" . ')"><i class="fa fa-print"></i> Cetak</a>';
        })
        ->toJson();
    } else {
      exit("No data available");
    }
  }


  public function data_form($id)
  {
    $employee_list = Employee::all();
    $shift_list = Shift::all()->pluck('shift_name', 'id');
    $attendance = Time::where('period_id', $id)->get();

    $sql_date = 'SELECT 
                shift_schedule.date_in,
                shift_schedule.employee_id,
                shift_schedule.period_id
              FROM
                shift_schedule
              WHERE `shift_schedule`.period_id =' . $id . '
              GROUP BY shift_schedule.date_in';
    $shift_schedule_date = DB::table(DB::raw("($sql_date) as rs_sql"))->get();

    $data = [];
    foreach ($employee_list as $key => $employee_list_value) {
      $data['shift_id'] = ShiftSchedule::where('employee_id', $employee_list_value->id)->where('date_in', $shift_schedule_date->date_in)->first();
    };

    $response = Response::make($data, 200);
    $response->header('Content-Type', 'application/json');
    return $response;


    // return view ('editor.shift_schedule.form', compact('shift_schedule','shift_list', 'employee_list', 'shift_schedule_category_list', 'period', 'attendance', 'shift_schedule_date'));
  }

  public function edit($id)
  {
    $employee_list = Employee::orderBy('id', 'ASC')->get(); 
    // $shift_list = Shift::all(); 
    $shift_list = Shift::all(); 
    $period = Period::where('id', $id)->first();

    $sql_date = 'SELECT shift_schedule.date_in, shift_schedule.period_id FROM shift_schedule WHERE `shift_schedule`.period_id ='.$id.' GROUP BY shift_schedule.date_in ORDER BY shift_schedule.date_in ASC';

    $shift_schedule_date = DB::table(DB::raw("($sql_date) as rs_sql"))->get(); 

    $sql_schedule = "SELECT shift_schedule.date_in, shift_schedule.employee_id, shift_schedule.shift_id, shift_schedule.period_id, shift.shift_name,
    employee.employee_name FROM shift_schedule
    LEFT JOIN  shift ON shift_schedule.shift_id = shift.id
    LEFT JOIN employee ON shift_schedule.employee_id = employee.id
    WHERE shift_schedule.deleted_at IS NULL AND shift_schedule.period_id = '".$id."'
    ORDER BY shift_schedule.employee_id, shift_schedule.date_in ASC";
    $shift_schedule_detail= DB::table(DB::raw("($sql_schedule) as rs_sql"))->get(); 

    //dd($shift_schedule_detail);

    return view ('editor.shift_plan.form', compact('shift_list', 'employee_list', 'period', 'shift_schedule_date', 'shift_schedule_detail'));
  }

  public function lookup()
  {

    $shifts = DB::table('shift')
      ->select('id as value', 'shift_name as text')
      ->orderBy('shift_name', 'asc')
      ->where('deleted_at', null)
      ->get();
    echo json_encode($shifts);
  }

  public function store(Request $request)
  {

    $name = $request->name;

    $pk = $request->pk;
    $pk_val = explode("_", $pk);

    // print_r($pk_val[0]);
    // print_r($pk_val[1]);

    $shift_schedule = ShiftSchedule::where('employee_id', $pk_val[0])->where('date_in', $pk_val[1])->where('period_id', $pk_val[2])->first();
    $shift_schedule->shift_id = $request->value;
    return $shift_schedule->save();
    // dd($shift_plan->id);

    // print_r($request->value);
    // $shift_plan->shift_id = $request->value;
    // return $shift_plan->save();
  }

  public function slip($id)
  {
    $employee_list = Employee::all();
    // $shift_list = Shift::all(); 
    $shift_list = Shift::all();
    $period = Period::where('id', $id)->first();

    $sql_date = 'SELECT shift_schedule.date_in FROM shift_schedule
    WHERE `shift_schedule`.period_id = '.$id.'
    GROUP BY shift_schedule.date_in ORDER BY shift_schedule.date_in ASC';
    $shift_schedule_date = DB::table(DB::raw("($sql_date) as rs_sql"))->get();

    $sql_schedule = 'SELECT 
                shift_schedule.date_in,
                shift_schedule.employee_id,
                shift_schedule.shift_id,
                shift_schedule.period_id,
                shift.shift_name,
                CONCAT(TIME_FORMAT(shift.start_time, "%H:%i"), "-", TIME_FORMAT(shift.end_time, "%H:%i")) AS shift_time
              FROM
                shift_schedule
              INNER JOIN employee ON shift_schedule.employee_id = employee.id
              LEFT JOIN shift ON shift_schedule.shift_id = shift.id
              WHERE `shift_schedule`.period_id =' . $id . ' AND employee.deleted_at IS NULL';
    $shift_schedule_detail = DB::table(DB::raw("($sql_schedule) as rs_sql"))->get();

    //  dd($shift_schedule_date);

    return view('editor.shift_plan.slip', compact('shift_list', 'employee_list', 'period', 'shift_schedule_date', 'shift_schedule_detail'));
  }


  public function slip_print($id)
  {
    $employee_list = Employee::all();
    // $shift_list = Shift::all(); 
    $shift_list = Shift::all();
    $period = Period::where('id', $id)->first();

    $sql_date = 'SELECT shift_schedule.date_in FROM shift_schedule
    WHERE `shift_schedule`.period_id = '.$id.'
    GROUP BY shift_schedule.date_in ORDER BY shift_schedule.date_in ASC';
    $shift_schedule_date = DB::table(DB::raw("($sql_date) as rs_sql"))->get();

    $sql_schedule = 'SELECT 
                shift_schedule.date_in,
                shift_schedule.employee_id,
                shift_schedule.shift_id,
                shift_schedule.period_id,
                shift.shift_name,
                CONCAT(TIME_FORMAT(shift.start_time, "%H:%i"), "-", TIME_FORMAT(shift.end_time, "%H:%i")) AS shift_time
              FROM
                shift_schedule
              INNER JOIN employee ON shift_schedule.employee_id = employee.id
              LEFT JOIN shift ON shift_schedule.shift_id = shift.id
              WHERE `shift_schedule`.period_id =' . $id . ' AND employee.deleted_at IS NULL';
    $shift_schedule_detail = DB::table(DB::raw("($sql_schedule) as rs_sql"))->get();

    //  dd($shift_schedule_date);


    return view('editor.shift_plan.slip_print', compact('shift_list', 'employee_list', 'period', 'shift_schedule_date', 'shift_schedule_detail'));
  }

  public function update($id, Request $request)
  {
    foreach ($request->input('detail') as $key => $detail_data) {
      $get_data = explode('_', $key);
      // dd($get_data[1]);

      $shift_schedule_detail = ShiftSchedule::where('employee_id', $get_data[0])->where('date_in', $get_data[1])->first();
      // dd($detail_data['shift_id']);   
      $shift_schedule_detail->shift_id = $detail_data['shift_id'];
      $shift_schedule_detail->save();
    }
    // return redirect('editor/shift-schedule');  
    return back();
  }

  public function delete($id)
  {
    $post =  ShiftSchedule::Find($id);
    $post->delete();

    return response()->json($post);
  }
}
