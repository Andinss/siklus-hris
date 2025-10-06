<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\AbsenceType;
use App\Models\LeaveCategory;
use Validator;
use Response;
use App\Post;
use View;

class LeaveController extends Controller
{
  /**
   * @var array
   */
  protected $rules =
  [
    'leaveno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'leavename' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $leaves = Leave::all();
    return view('editor.leave.index', compact('leaves'));
  }

  public function data(Request $request)
  {
    if ($request->ajax()) {

      $sql = 'SELECT 
                  leave.id,
                  leave.code_trans,
                  leave.no_trans,
                  leave.date_trans,
                  leave.employee_id,
                  employee.employee_name,
                  leave.leave_from,
                  leave.leave_to,
                  DATEDIFF(leave.leave_to, leave.leave_from) + 1 AS days,
                  leave.used,
                  leave.plafond,
                  leave.absence_type_id,
                  absence_type.absence_type_name,
                  leave_category.leave_category_code,
                  leave_category.leave_category_name,
                  leave.attachment,
                  leave.remark,
                  leave.status
                FROM
                  `leave`
                  LEFT JOIN employee ON leave.employee_id = employee.id
                  LEFT JOIN absence_type ON leave.absence_type_id = absence_type.id
                  LEFT JOIN leave_category ON leave.leave_category_id = leave_category.id
                WHERE
                  leave.deleted_at IS NULL ORDER BY leave.no_trans DESC';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();


      return DataTables::of($itemdata)
        ->addColumn('action', function ($itemdata) {
          return '<a href="leave/' . $itemdata->id . '/edit" title="Detail No: ' . "" . $itemdata->no_trans . "" . '"  onclick="edit(' . "'" . $itemdata->id . "'" . ')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-book"></i> Detail</a> <a href="#" onclick="delete_id(' . $itemdata->id . ')" title="Detail No: LB20240322001" class="btn btn-sm btn-outline-danger d-inline-block"><i class="fas fa-trash-alt"></i> Hapus</a>';
        })
        ->addColumn('approval', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-success" onclick="approve_id(' . "'" . $itemdata->id . "', '" . $itemdata->no_trans . "'" . ')"><i class="fas fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-warning" onclick="not_approve_id(' . "'" . $itemdata->id . "', '" . $itemdata->no_trans . "'" . ')"><i class="fas fa-times"></i> Not Approve</a>';
        })
        ->addColumn('btn_attachment', function ($itemdata) {
          if ($itemdata->attachment == "") {
            return 'No Attachment';
          } else {
            return '<a href="' . asset("assets/uploads/leave/" . $itemdata->attachment) . '" target="_blank"><i class="fa fa-download"></i> Download </a>';
          };
        })
        ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function datahistory(Request $request)
  {
    if ($request->ajax()) {

      $sql = 'SELECT
                  leave.id,
                  leave.code_trans,
                  leave.no_trans,
                  leave.date_trans,
                  leave.employee_id,
                  DATE_FORMAT(leave.leave_from, "%d-%m-%Y") AS leave_from,
                  DATE_FORMAT(leave.leave_to, "%d-%m-%Y") AS leave_to,
                  absence_type.absence_type_name,
                  leave_category.leave_category_code,
                  leave_category.leave_category_name,
                  employee.employee_name
                FROM
                  leave
                INNER JOIN absence_type ON leave.absence_type_id = absence_type.id
                INNER JOIN leave_category ON leave.leave_category_id = leave_category.id
                INNER JOIN employee ON leave.employee_id = employee.id,
                 `user`
                WHERE
                  `user`.id = ' . Auth::id() . ' AND leave.employee_id = user.employee_id
                AND
                  leave.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

        ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function create()
  {
    $employee_list = Employee::all()->pluck('employee_name', 'id');
    $absence_type_list = AbsenceType::all()->pluck('absence_type_name', 'id');

    return view('editor.leave.form', compact('employee_list', 'absence_type_list'));
  }

  public function generate_leave_number()
  {
    $date = date('Ymd');
    $row = DB::table('leave')->
    select(DB::raw('COUNT(no_trans) AS count'))
    ->where('no_trans', 'LIKE', "%$date%")
    ->whereNull('deleted_at')
    ->get();
    $count = $row[0]->count;
    $leave_count = $count + 1;
    return "LEAVE-".$date.str_pad($leave_count, 3, '0', STR_PAD_LEFT);
  }

  public function store(Request $request)
  {
      $no_trans = $this->generate_leave_number();
      DB::insert("INSERT INTO `leave` (code_trans, no_trans, leave_category_id, medicine, remark, status)
                VALUES('LEAVE','$no_trans','0', '', '', '0')");

    $lastInsertedID = DB::table('leave')->max('id');

    $date_trans_array = explode('-', $request->input('date_trans')); // split the array
    $var_day_trans = $date_trans_array[0]; // day segment
    $var_month_trans = $date_trans_array[1]; // month segment
    $var_year_trans = $date_trans_array[2]; // year segment
    $date_trans_format = "$var_year_trans-$var_month_trans-$var_day_trans";

    $date_array_from = explode("-", $request->input('leave_from')); // split the array
    $var_day_from = $date_array_from[0]; //day seqment
    $var_month_from = $date_array_from[1]; //month segment
    $var_year_from = $date_array_from[2]; //year segment
    $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together

    $date_array_to = explode("-", $request->input('leave_to')); // split the array
    $var_day_to = $date_array_to[0]; //day seqment
    $var_month_to = $date_array_to[1]; //month segment
    $var_year_to = $date_array_to[2]; //year segment
    $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together


    $leave = Leave::where('id', $lastInsertedID)->first();
    $leave->employee_id = $request->input('employee_id');
    $leave->absence_type_id = $request->input('absence_type_id');
    $leave->date_trans = $date_trans_format;
    $leave->leave_from = $date_format_from;
    $leave->leave_to = $date_format_to;
    $leave->created_by = Auth::id();
    $leave->save();

    if ($request->attachment) {
      $leave = Leave::FindOrFail($leave->id);
      $original_directory = "uploads/leave/";
      if (!File::exists($original_directory)) {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }
      $leave->attachment = Carbon::now()->format("d-m-Y h-i-s") . $request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $leave->attachment);
      $leave->save();
    }
    return redirect('editor/leave');
  }

  public function edit($id)
  {
    $employee_list = Employee::all()->pluck('employee_name', 'id');
    $absence_type_list = AbsenceType::all()->pluck('absence_type_name', 'id');
    // $leave = Leave::Where('id', $id)->first();   
    $sql = 'SELECT
                `leave`.id ,
                `leave`.code_trans ,
                `leave`.no_trans ,
                 date_format(`leave`.date_trans , "%d-%m-%Y") AS date_trans,
                `leave`.employee_id ,
                `leave`.disease_id ,
                `leave`.dockter_id ,
                `leave`.hospital_id ,
                 date_format(`leave`.leave_from , "%d-%m-%Y") AS leave_from,
                 date_format(`leave`.leave_to , "%d-%m-%Y") AS leave_to,
                DATEDIFF(`leave`.leave_from, `leave`.leave_to) AS days,
                `leave`.used ,
                `leave`.plafond ,
                `leave`.absence_type_id ,
                `leave`.leave_category_id ,
                `leave`.attachment ,
                `leave`.medicine ,
                `leave`.remark ,
                `leave`.`status`
              FROM
                `leave`
              WHERE `leave`.id =' . $id . '';
    $leave = DB::table(DB::raw("($sql) as rs_sql"))->first();

    return view('editor.leave.form', compact('leave', 'absence_type_list', 'employee_list'));
  }

  public function update($id, Request $request)
  {

    $date_trans_array = explode('-', $request->input('date_trans')); // split the array
    $var_day_trans = $date_trans_array[0]; // day segment
    $var_month_trans = $date_trans_array[1]; // month segment
    $var_year_trans = $date_trans_array[2]; // year segment
    $date_trans_format = "$var_year_trans-$var_month_trans-$var_day_trans";

    $date_array_from = explode("-", $request->input('leave_from')); // split the array
    $var_day_from = $date_array_from[0]; //day seqment
    $var_month_from = $date_array_from[1]; //month segment
    $var_year_from = $date_array_from[2]; //year segment
    $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together

    $date_array_to = explode("-", $request->input('leave_to')); // split the array
    $var_day_to = $date_array_to[0]; //day seqment
    $var_month_to = $date_array_to[1]; //month segment
    $var_year_to = $date_array_to[2]; //year segment
    $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together

    $leave = Leave::FindOrFail($id);
    $leave->employee_id = $request->input('employee_id');
    $leave->absence_type_id = $request->input('absence_type_id');
    $leave->date_trans = $date_trans_format;
    $leave->leave_from = $date_format_from;
    $leave->leave_to = $date_format_to;
    $leave->created_by = Auth::id();
    $leave->save();

    if ($request->attachment) {
      $leave = Leave::FindOrFail($leave->id);
      $original_directory = "uploads/leave/";
      if (!File::exists($original_directory)) {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }
      $leave->attachment = Carbon::now()->format("d-m-Y h-i-s") . $request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $leave->attachment);
      $leave->save();
    }
    return redirect('editor/leave');
  }

  public function delete($id)
  {
    $post =  Leave::Find($id);
    $post->delete();

    return response()->json($post);
  }
}
