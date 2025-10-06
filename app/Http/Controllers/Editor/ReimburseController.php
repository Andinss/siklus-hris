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
use App\Models\Period;
use App\Models\ReimburseType;
use Validator;
use Response;
use App\Modelss\Post;
use View;

class ReimburseController extends Controller
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
    return view('editor.reimburse.index', compact('reimburses'));
  }

  public function data(Request $request)
  {
    if ($request->ajax()) {

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
                  reimburse_type.reimburse_type_name,
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
                LEFT JOIN reimburse_type ON reimburse.reimburse_type_id = reimburse_type.id
                LEFT JOIN period ON reimburse.period_id = period.id';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)
        ->addColumn('action', function ($itemdata) {
          return '<a href="reimburse/detail/' . $itemdata->id . '" title="' . "'" . $itemdata->no_trans . "'" . '" class="btn btn-sm btn-outline-primary d-inline-block" onclick="edit(' . "'" . $itemdata->id . "'" . ')"><i class="fas fa-book"></i> Detail</a> <a href="#" onclick="delete_id(' . $itemdata->id . ')" class="btn btn-sm btn-outline-danger d-inline-block"><i class="fas fa-trash-alt"></i> Hapus</a>';
        })
        ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status == 0) {
            return '<span class="label label-success"> Open </span>';
          } else {
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
    $reimburse_type_list = ReimburseType::all()->pluck('reimburse_type_name', 'id');
    $month_list = Month::all()->pluck('monthname', 'id');
    $year_list = Year::all()->pluck('yearname', 'yearname');
    $department_list = Department::all()->pluck('department_name', 'id');
    $period_list = Period::all()->pluck('description', 'id');

    $sql_day_work = 'SELECT
                          DATEDIFF(
                            reimburse.date_trans,
                            employee.join_date
                          ) AS day_work
                        FROM
                          employee
                        INNER JOIN reimburse ON employee.id = reimburse.employee_id
                        WHERE
                          reimburse.id = ' . $id . '';
    $day_work = DB::table(DB::raw("($sql_day_work) as rs_sql"))->first();

    // $reimburse = Reimburse::Find($id); 
    $sql = 'SELECT
                reimburse.id,
                reimburse.code_trans,
                reimburse.no_trans,
                date_format(reimburse.date_trans, "%d-%m-%Y") AS date_trans,
                reimburse.employee_id,
                reimburse.department_id,
                reimburse.medical_type_id,
                reimburse.period_id,
                reimburse.patient_name,
                FORMAT(reimburse.plafond,0) AS plafond,
                FORMAT(reimburse.used,0) AS used,
                FORMAT(reimburse.remain,0) AS remain,
                FORMAT(reimburse.claim_amount,0) AS claim_amount,
                reimburse.remain AS remain_val,
                reimburse.remark,
                reimburse.`status`
              FROM
                reimburse
              WHERE reimburse.id =' . $id . '';
    $reimburse = DB::table(DB::raw("($sql) as rs_sql"))->first();
    return view('editor.reimburse.form', compact('employee_list', 'reimburse', 'reimburse_type_list', 'month_list', 'year_list', 'department_list', 'period_list', 'day_work'));
  }

  public function slip($id)
  {
    $reimburse = \DB::select(\DB::raw("
           SELECT
              reimburse.id,
              reimburse.code_trans,
              reimburse.no_trans,
              reimburse.date_trans,
              reimburse.department_id,
              reimburse.departmentcode,
              reimburse.datefrom,
              reimburse.dateto,
              employee.employee_name,
              department.department_name,
              reimburse.time_from,
              reimburse.time_to,
              reimburse.reimburse_in,
              reimburse.reimburse_out,
              reimburse.period_id,
              reimburse.remark,
              reimburse.planwork,
              reimburse.actualwork,
              reimburse.location
            FROM
              reimburse
            INNER JOIN reimburse_detail ON reimburse.id = reimburse_detail.trans_id
            INNER JOIN employee ON reimburse_detail.employee_id = employee.id
            INNER JOIN department ON employee.department_id = department.id WHERE reimburse.id = " . $id . "

        "));


    return view('editor.reimburse.slip', compact('reimburse'));
  }



  public function store(Request $request)
  {

    $userid = Auth::id();
    $code_trans = $request->input('code_trans');

    DB::insert("INSERT INTO reimburse (code_trans, no_trans, date_trans, created_by, created_at)
      SELECT '" . $code_trans . "',
      IFNULL(CONCAT('" . $code_trans . "','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(RIGHT(reimburse.no_trans,5)),5))+100001,5)), CONCAT('" . $code_trans . "','-',DATE_FORMAT(NOW(), '%d%m%y'),'00001')), DATE(NOW()), '" . $userid . "', DATE(NOW()) 
      FROM
      reimburse
      WHERE code_trans= '" . $code_trans . "'");

    $lastInsertedID = DB::table('reimburse')->max('id');
    //return redirect()->action('Editor\ReimburseController@edit', $lastInsertedID->id);
    return redirect('editor/reimburse/detail/' . $lastInsertedID . '');
  }

  public function saveheader($id, Request $request)
  {
    $post = Reimburse::Find($id);
    $post->reimburse_type_id = $request->reimburse_type_id;
    $post->employee_id = $request->employee_id;
    $post->department_id = $request->department_id;
    $post->patient_name = $request->patient_name;
    $post->plafond = $request->plafond;
    $post->used = $request->used;
    $post->remain = $request->remain;
    $post->period_id = $request->period_id;
    $post->remark = $request->remark;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post);
  }


  public function generate($id, Request $request)
  {

    $post = Reimburse::Find($id);
    $post->reimburse_type_id = $request->reimburse_type_id;
    $post->employee_id = $request->employee_id;
    $post->department_id = $request->department_id;
    $post->patient_name = $request->patient_name;
    $post->plafond = $request->plafond;
    $post->used = $request->used;
    $post->remain = $request->remain;
    $post->period_id = $request->period_id;
    $post->remark = $request->remark;
    $post->updated_by = Auth::id();
    $post->save();

    DB::update("UPDATE reimburse
                  INNER JOIN (
                    SELECT
                      sum(reimburse_detail.amount) AS amount
                    FROM
                      reimburse_detail
                    WHERE
                      reimburse_detail.trans_id = " . $id . "
                  ) AS reimburse_detail
                  SET reimburse.claim_amount = reimburse_detail.amount
                  WHERE
                    reimburse.id = " . $id . "");

    $sql_year_work = 'SELECT
                    YEAR (reimburse.date_trans) - YEAR (employee.join_date) AS year_work
                  FROM
                    employee
                  INNER JOIN reimburse ON employee.id = reimburse.employee_id
                  WHERE
                    reimburse.id = ' . $id . '';
    $year_work = DB::table(DB::raw("($sql_year_work) as rs_sql"))->first();


    $sql_plafond = 'SELECT
                        employee.id,
                        employee.basic,
                        MONTH (employee.join_date) AS dateemp
                      FROM
                        employee
                      INNER JOIN reimburse ON employee.id = reimburse.employee_id
            WHERE
              reimburse.id = ' . $id . '';
    $plafond = DB::table(DB::raw("($sql_plafond) as rs_sql"))->first();


    if ($year_work->year_work >= 183 && $year_work->year_work <= 136) {
      $plafond_val = $plafond->basic * (12 - ($plafond->dateemp) + 1) / 12;
    } else {
      $plafond_val = $plafond->basic;
    };


    DB::update("UPDATE reimburse
                  INNER JOIN (
                    SELECT
                      YEAR (reimburse.date_trans) AS `year`,
                      sum(reimburse_detail.amount) AS used,
                      reimburse.employee_id
                    FROM
                      reimburse
                    INNER JOIN reimburse_detail ON reimburse.id = reimburse_detail.trans_id
                    INNER JOIN employee ON reimburse.employee_id = employee.id
                    WHERE reimburse_detail.deleted_at IS NULL
                    GROUP BY
                      YEAR (reimburse.date_trans),
                      reimburse.employee_id
                  ) AS reimburse_detail
                  SET reimburse.plafond = " . $plafond_val . ", reimburse.used = reimburse_detail.used, reimburse.remain = " . $plafond_val . " - reimburse_detail.used
                  WHERE
                    reimburse.id = " . $id . " AND reimburse.employee_id = reimburse_detail.employee_id AND YEAR(reimburse.date_trans) = reimburse_detail.year");
  }

  public function update($id, Request $request)
  {
    $post = Reimburse::Find($id);
    $post->reimburse_type_id = $request->input('reimburse_type_id');
    $post->employee_id = $request->input('employee_id');
    $post->period_id = str_replace(",", "", $request->input('period_id'));
    $post->remark = $request->input('remark');
    $post->updated_by = Auth::id();
    $post->save();

    return redirect('editor/reimburse');
  }


  public function savedetail($id, Request $request)
  {

    // $date_array = explode("-",$request->dateclaim); // split the array
    // $var_day = $date_array[0]; //day seqment
    // $var_month = $date_array[1]; //month segment
    // $var_year = $date_array[2]; //year segment
    // $new_date_format = "$var_year-$var_month-$var_day"; // join them together

    $post = new ReimburseDetail;
    $post->trans_id = $id;
    $post->description = $request->description;
    $post->quantity = $request->quantity;
    // $post->date_claim = $new_date_format;   
    $post->no_ref = $request->no_ref;
    $post->amount = $request->amount;
    $post->save();

    return response()->json($post);
  }

  public function deletedet($id)
  {
    $post =  ReimburseDetail::where('id', $id);
    $post->delete();

    return response()->json($post);
  }

  public function deletebulk(Request $request)
  {

    $idkey = $request->idkey;

    foreach ($idkey as $key => $id) {
      // $post =  Reimburse::where('id', $id["1"])->get();
      $post = Reimburse::Find($id["1"]);
      $post->delete();
    }

    echo json_encode(array("status" => TRUE));
  }
  public function datadetail(Request $request, $id)
  {

    if ($request->ajax()) {

      $sql = 'SELECT
                  reimburse_detail.id AS id,
                  reimburse_detail.trans_id,
                  reimburse_detail.description,
                  reimburse_detail.date_claim,
                  reimburse_detail.quantity,
                  FORMAT(reimburse_detail.amount,0) AS amount,
                  reimburse_detail.no_ref
                FROM
                  reimburse_detail
                WHERE reimburse_detail.trans_id = ' . $id . ' AND reimburse_detail.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)

        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger" onclick="delete_id(' . "'" . $itemdata->id . "', '" . $itemdata->description . "'" . ')"><i class="fas fa-trash-alt"></i></a>';
        })

        ->make(true);
    } else {
      exit("No data available");
    }
  }
  public function delete($id)
  {
    $post = Reimburse::Find($id);
    $post->delete();
    $detail = ReimburseDetail::where('trans_id', $id);
    if($detail){
      $detail->delete();
    }

    return response()->json($post);
  }
}
