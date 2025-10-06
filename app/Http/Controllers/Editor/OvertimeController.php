<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimeRequest;
use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Employee;
use App\Models\AbsenceType;
use App\Models\OvertimeCategory;
use Validator;
use Response;
use App\Post;
use View;

class OvertimeController extends Controller
{
  /**
   * @var array
   */
  protected $rules =
  [
    'overtimeno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
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
    return view('editor.overtime.index', compact('overtimes'));
  }

  public function data(Request $request)
  {
    if ($request->ajax()) {

      $sql = 'SELECT 
                  overtime.id, 
                  overtime.no_trans,
                  overtime.date_trans,
                  overtime.employee_id,
                  employee.employee_name,
                  employee.nik,
                  employee.identity_no,
                  overtime.date_from,
                  overtime.time_from,
                  overtime.time_to,
                  DATEDIFF(overtime.time_to, overtime.date_from) + 1 AS days, 
                  overtime.attachment,
                  overtime.remark,
                  overtime.status,
                  overtime.category,
                  overtime.total_hour,
                  overtime.total_rate,
                  position.position_name
                FROM
                  `overtime`
                  LEFT JOIN employee ON overtime.employee_id = employee.id
                  LEFT JOIN position ON employee.position_id = position.id
                WHERE
                  overtime.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();


      return DataTables::of($itemdata)

        ->addColumn('action', function ($itemdata) {
          return '<a href="overtime/' . $itemdata->id . '/edit" title="Detail No: ' . "" . $itemdata->no_trans . "" . '"  onclick="edit(' . "'" . $itemdata->id . "'" . ')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-book"></i> Detail</a>&nbsp;<a href="#" onclick="delete_id('.$itemdata->id.')" title="Detail No: ' . "" . $itemdata->no_trans . "" . '" class="btn btn-sm btn-outline-danger d-inline-block"><i class="fas fa-trash-alt"></i> Hapus</a>';
        })

        // ->addColumn('approval', function ($itemdata) {
        //   return '<a  href="javascript:void(0)" title="Approval" class="btn btn-success btn-xs" onclick="approve_id(' . "'" . $itemdata->id . "', '" . $itemdata->no_trans . "'" . ')"><i class="fa fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-warning btn-xs" onclick="not_approve_id(' . "'" . $itemdata->id . "', '" . $itemdata->no_trans . "'" . ')"><i class="fa fa-close"></i> Not Approve</a>';
        // })
        ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function datahistory(Request $request)
  {
    if ($request->ajax()) {

      $sql = 'SELECT
                  overtime.id,
                  overtime.code_trans,
                  overtime.no_trans,
                  overtime.date_trans,
                  overtime.employee_id,
                  DATE_FORMAT(overtime.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(overtime.time_to, "%d-%m-%Y") AS time_to,
                  absence_type.absence_type_name,
                  overtime_category.overtime_category_code,
                  overtime_category.overtime_category_name,
                  employee.employee_name
                FROM
                  overtime
                INNER JOIN absence_type ON overtime.absence_type_id = absence_type.id
                INNER JOIN overtime_category ON overtime.overtime_category_id = overtime_category.id
                INNER JOIN employee ON overtime.employee_id = employee.id,
                 `user`
                WHERE
                  `user`.id = ' . Auth::id() . ' AND overtime.employee_id = user.employee_id
                AND
                  overtime.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

        ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function create()
  {
    $employee_list = Employee::all()->pluck('employee_name', 'id');
    $absence_type_list = AbsenceType::all()->pluck('absence_type_name', 'id');
    $overtime = null;
    $disease_list= null;
    $dockter_list= null;
    $hospital_list = null;
    $overtime_category_list= null;

    return view('editor.overtime.form', compact('overtime','employee_list', 'absence_type_list', 'disease_list', 'dockter_list', 'hospital_list', 'overtime_category_list'));
    
  }

  public function store(Request $request)
  {

    //   DB::insert("INSERT INTO `overtime` (code_trans, no_trans, date_trans)
    //               SELECT 'OVTM',
    //               IFNULL(CONCAT('OVTM','-',DATE_FORMAT(NOW(), '%Y%m%d'),RIGHT((RIGHT(MAX(`overtime`.no_trans),3))+1001,3)), CONCAT('OVTM','-',DATE_FORMAT(NOW(), '%Y%m%d'),'001')), DATE(NOW())  
    //               FROM
    //               `overtime`
    //               WHERE code_trans='OVTM'");
    //  $lastInsertedID = DB::table('overtime')->max('id');  

    $date_array_trans = explode("-", $request->input('date_trans')); // split the array
    $var_day_trans = $date_array_trans[0]; //day seqment
    $var_month_trans = $date_array_trans[1]; //month segment
    $var_year_trans = $date_array_trans[2]; //year segment
    $date_format_trans = "$var_year_trans-$var_month_trans-$var_day_trans"; // join them together

    //  $overtime = Overtime::where('id', $lastInsertedID)->first(); 
    $overtime = new Overtime();
    $overtime->code_trans = $request->input('no_trans');
    $overtime->no_trans = $request->input('no_trans');
    $overtime->employee_id = $request->input('employee_id');
    $overtime->time_from = $request->input('time_from');
    $overtime->time_to = $request->input('time_to');
    $overtime->date_from = $date_format_trans;
    $overtime->date_trans = $date_format_trans;
    $overtime->category = $request->input('category');
    $overtime->total_hour = $request->input('total_hour');
    $overtime->total_rate = $request->input('total_rate');
    $overtime->created_by = Auth::id();
    $overtime->save();

    if ($request->attachment) {
      $overtime = Overtime::FindOrFail($overtime->id);
      $original_directory = "uploads/overtime/";
      if (!File::exists($original_directory)) {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }
      $overtime->attachment = Carbon::now()->format("d-m-Y h-i-s") . $request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $overtime->attachment);
      $overtime->save();
    }
    return redirect('editor/overtime');
  }

  public function edit($id)
  {
    $employee_list = Employee::all()->pluck('employee_name', 'id');
    $absence_type_list = AbsenceType::all()->pluck('absence_type_name', 'id');
    // $overtime = Overtime::Where('id', $id)->first();   
    $sql = 'SELECT
                `overtime`.id ,
                `overtime`.code_trans ,
                `overtime`.no_trans ,
                 date_format(`overtime`.date_trans , "%d-%m-%Y") AS date_trans,
                `overtime`.employee_id ,  
                 date_format(`overtime`.date_from , "%d-%m-%Y") AS date_from,
                 `overtime`.time_from AS time_from, 
                 `overtime`.time_to AS time_to, 
                `overtime`.attachment ,
                `overtime`.remark ,
                `overtime`.`status`,
                `overtime`.category,
                `overtime`.total_hour,
                `overtime`.total_rate
              FROM
                `overtime`
              WHERE `overtime`.id =' . $id . '';
    $overtime = DB::table(DB::raw("($sql) as rs_sql"))->first();

    return view('editor.overtime.form', compact('overtime', 'absence_type_list', 'employee_list'));
  }

  public function update($id, Request $request)
  {

    $date_array_trans = explode("-", $request->input('date_trans')); // split the array
    $var_day_trans = $date_array_trans[0]; //day seqment
    $var_month_trans = $date_array_trans[1]; //month segment
    $var_year_trans = $date_array_trans[2]; //year segment
    $date_format_trans = "$var_year_trans-$var_month_trans-$var_day_trans"; // join them together

    $overtime = Overtime::FindOrFail($id);
    $overtime->no_trans = $request->input('no_trans');
    $overtime->employee_id = $request->input('employee_id');
    $overtime->time_from = $request->input('time_from');
    $overtime->time_to = $request->input('time_to');
    $overtime->date_from = $date_format_trans;
    $overtime->date_trans = $date_format_trans;
    $overtime->category = $request->input('category');
    $overtime->total_hour = $request->input('total_hour');
    $overtime->total_rate = $request->input('total_rate');
    $overtime->created_by = Auth::id();
    $overtime->save();

    if ($request->attachment) {
      $overtime = Overtime::FindOrFail($overtime->id);
      $original_directory = "uploads/overtime/";
      if (!File::exists($original_directory)) {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }
      $overtime->attachment = Carbon::now()->format("d-m-Y h-i-s") . $request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $overtime->attachment);
      $overtime->save();
    }
    return redirect('editor/overtime');
  }

  public function delete($id)
  {
    $post =  Overtime::Find($id);
    $post->delete();

    return response()->json($post); 
  }
}
