<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollRequest;
use App\Http\Controllers\Controller;
use App\Models\BPJSKesDetail;
use App\Models\BPJSKesehatan;
use App\Models\BPJSTK;
use App\Models\BPJSTKDetail;
use App\Models\Payroll;
use App\Models\Period;
use App\Models\Department;
use App\Models\User;
use App\Models\PayrollSetting;
use Carbon\Carbon;
use Validator;
use Response;
use App\Post;
use View;


use App\Models\Overtime;
use App\Models\TotalSalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PayrollController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
        'payroll_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function index()
  {
    $payrolls = Payroll::all();
    $query = '
      CONCAT("Period: ", DATE_FORMAT(period.begin_date,"%d-%m-%Y"), " sampai ", DATE_FORMAT(period.end_date,"%d-%m-%Y"))
    ';
    $period_list = DB::table('period')->select('id', DB::raw("($query) AS description"))->where('deleted_at', null)->get()->pluck('description', 'id');
    // dd($period_list);
    $department_list = Department::all()->pluck('department_name', 'departmentcode');

    return view ('editor.payroll.index', compact('payrolls','period_list','department_list'));
  }

  public function data(Request $request)
  {
    if($request->ajax()){
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
        return '<a href="payroll/'.$itemdata->id.'/edit" title="Detail" class="btn btn-sm btn-outline-primary d-inline-block" onclick="edit('."'".$itemdata->id."'".')"><i class="fas fa-folder"></i> Detail</a> <a href="payroll/'.$itemdata->id.'/report" title="Cetak" class="btn btn-sm btn-outline-secondary d-inline-block"><i class="fas fa-print"></i> Laporan</a> <a href="payroll/'.$itemdata->id.'/slip-print" target="_blank" title="Cetak" class="btn btn-sm btn-outline-warning d-inline-block"><i class="fas fa-print"></i> Slip</a>';
      })
      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })
      ->toJson();
    } else {
      exit("No data available");
    }
  }


  public function absence()
  {
    return view ('editor.payroll.absence');
  }

  public function dataabsence(Request $request)
  {
    if($request->ajax()){
      $sql = 'SELECT
                absence.id,
                absence_type.absence_type_name,
                absence.holiday,
                DATE_FORMAT(absence.date_in, "%d-%m-%Y") AS date_in,
                absence.day_in,
                absence.day_out,
                absence.actual_in,
                absence.actual_out,
                absence.permite_in,
                absence.permite_out,
                absence.overtime_in,
                absence.overtime_out,
                absence.overtime_hour,
                absence.time_overtime,
                employee.employee_name,
                absence.overtime_hour_actual
              FROM
                absence
              LEFT JOIN absence_type ON absence.absence_type_id = absence_type.id
              LEFT JOIN employee ON absence.employee_id = employee.id
              INNER JOIN `user` ON absence.employee_id = `user`.employee_id
              AND absence.period_id = `user`.period_id
              WHERE user.id = '.Auth::id().'';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)
      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function storeabsence(Request $request)
  {

    $post = User::where('id', Auth::id())->first();
    $post->employee_id = $request->employee_id;
    $post->period_id = $request->period_id;
    $post->save();

    return response()->json($post);
  }



  public function datatime(Request $request)
  {
    if($request->ajax()){
      $sql = 'SELECT
                absence.id,
                absence_type.absence_type_name,
                absence.holiday,
                absence.date_in,
                absence.day_in,
                absence.day_out,
                absence.actual_in,
                absence.actual_out
              FROM
                absence
              LEFT JOIN absence_type ON absence.absence_type_id = absence_type.id';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

      ->addColumn('mstatus', function ($itemdata) {
        if ($itemdata->holiday == 1) {
          return '<span class="label label-success"> Yes </span>';
        }else{
         return '<span class="label label-danger"> No </span>';
       };

     })
      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function store($id)
  {
    DB::insert("insert into payroll
                      (employee_id, period_id, department_id)
                select     derivedtbl.employee_id, derivedtbl.period_id, derivedtbl.department_id
                from         (select     employee.id AS employee_id, employee.status, period.id AS period_id, employee.department_id
                                       from          employee cross join
                                                              period
                                       where      (employee.status =0 OR employee.status is null) and period.id = $id) derivedtbl left outer join
                                      payroll on derivedtbl.employee_id = payroll.employee_id and derivedtbl.period_id = payroll.period_id
                where     (payroll.period_id is null)");

    //return response()->json($post);
  }

  public function generate($id)
  {

    $period = Period::where('id', $id)->first();
    /* Untuk meng Update Gaji, Tunjangan, Uang Makan & Tetap, Overtime & Tetap menjadi 0 */
    DB::update("UPDATE payroll a
                SET a.basic = 0,
                 a.meal_trans_all = 0,
                 a.transport_all = 0,
                 a.overtime_all = 0,
                 a.public_holiday = 0,
                 a.meal_trans = 0,
                 a.day_no_permite = 0,
                 a.day_late = 0,
                 a.day_alpha = 0,
                 a.ded_alpha = 0,
                 a.ded_no_permite = 0,
                 a.insentive = 0,
                 a.other_ded = 0,
                 a.total_netto =0,
                 a.total_ded = 0,
                 a.total_bruto = 0,
                 a.total_netto = 0
                WHERE
                a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");


   //get day_job
   DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                absence.employee_id,
                absence.period_id,
                period.day_in ,
                SUM(
                  1
                ) AS public_holiday
              FROM
                absence
              LEFT JOIN period ON absence.period_id = period.id
              LEFT JOIN shift ON absence.shift_id = shift.id
              WHERE shift.shift_code = 'PH'
              GROUP BY
                absence.employee_id,
                absence.period_id) u
                SET a.public_holiday = u.public_holiday
                WHERE
                  a.employee_id = u.employee_id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");



   // /* Untuk mengambil Gaji dari master Employee */
   //  DB::update("UPDATE payroll a
   //              INNER JOIN (SELECT
   //                            employee.id,
   //                            employee.basic,
   //                            employee.meal_trans_all,
   //                            employee.transport_all,
   //                            employee.insentive_all,
   //                            employee.status
   //                          FROM
   //                            employee) u
   //              SET a.basic = u.basic, a.meal_trans_all = 15000, a.transport_all = 0, a.meal_trans = (u.meal_trans_all * CASE WHEN a.day_job < 25 THEN a.day_job ELSE a.day_in END) - (15000 * a.public_holiday), a.transport_all = u.transport_all, a.insentif_all = u.insentive_all
   //              WHERE
   //                a.employee_id = u.id
   //              AND  (u.`status` = 0 OR u.`status` IS NULL)
   //              AND a.period_id = ".$id."");

    /* Untuk mengambil Gaji dari master Employee */
    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                              COUNT(absence.id) AS day_late,
                              absence.employee_id
                            FROM
                              absence
                            LEFT JOIN shift ON absence.shift_id = shift.id
                            WHERE FLOOR(TIME_TO_SEC(TIMEDIFF(absence.actual_in, shift.start_time)) / 60) > 15 AND absence.period_id = ".$id."
                            GROUP BY absence.employee_id) u
                SET a.day_late = u.day_late
                -- SET a.day_late = 0
                WHERE
                  a.employee_id = u.employee_id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");


    /* Untuk mengambil Gaji dari master Employee */
    // DB::update("UPDATE payroll a
    //             INNER JOIN (SELECT
    //                           employee.id,
    //                           employee.basic,
    //                           employee.meal_trans_all,
    //                           employee.transport_all,
    //                           employee.insentive_all,
    //                           employee.status
    //                         FROM
    //                           employee) u
    //             SET a.basic = u.basic, a.meal_trans_all = 15000, a.transport_all = 0, a.meal_trans = (u.meal_trans_all * CASE WHEN a.day_job < 25 THEN a.day_in - (IFNULL(a.day_no_permite,0) + IFNULL(a.day_alpha,0)) ELSE a.day_in END) - (15000 * a.public_holiday) -  (a.day_late * 7500), a.transport_all = u.transport_all, a.insentif_all = u.insentive_all
    //             WHERE
    //               a.employee_id = u.id
    //             AND  (u.`status` = 0 OR u.`status` IS NULL)
    //             AND a.period_id = ".$id."");


    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                              employee.id,
                              employee.basic,
                              employee.meal_trans_all,
                              employee.transport_all,
                              employee.insentive_all,
                              employee.status
                            FROM
                              employee) u
                SET a.basic = u.basic, a.meal_trans_all = 0, a.transport_all = 0,  a.transport_all = u.transport_all, a.insentif_all = u.insentive_all
                WHERE
                  a.employee_id = u.id
                -- AND  (u.`status` = 0 OR u.`status` IS NULL)
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");




    /* Untuk mengambil Gaji dari master Employee */
    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                              COUNT(absence.id) AS day_alpha,
                              absence.employee_id
                            FROM
                              absence
                            LEFT JOIN shift ON absence.shift_id = shift.id
                            WHERE absence.absence_type_id = 9
                            GROUP BY absence.employee_id) u
                SET a.day_alpha = u.day_alpha
                -- SET a.day_alpha = 0
                WHERE
                  a.employee_id = u.employee_id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");

    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                              COUNT(absence.id) AS day_no_permite,
                              absence.employee_id
                            FROM
                              absence
                            LEFT JOIN shift ON absence.shift_id = shift.id
                            WHERE absence.period_id = ".$id." AND (absence.absence_type_id = 3  OR absence.absence_type_id = 4 OR absence.absence_type_id = 5  OR absence.absence_type_id = 6  OR absence.absence_type_id = 9 OR absence.absence_type_id = 10 )
                            GROUP BY absence.employee_id ) u
                SET a.day_no_permite = u.day_no_permite
                -- SET a.day_no_permite = 0
                WHERE
                  a.employee_id = u.employee_id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");

    /* Get overtime */
    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                  payroll.id,
                  payroll.period_id,
                  payroll.employee_id,
                  IFNULL(payroll.day_no_permite,0) AS day_no_permite,
                  payroll.day_alpha,
                  period.day_in,
                  -- payroll.day_job * payroll.meal_trans_all AS meal_trans_all,
                  -- payroll.day_job * payroll.transport_all AS transport_all,
                  -- (payroll.overtime_hour / 173) * payroll.basic AS overtime_all,
                  -- payroll.basic / 173 * payroll.day_job AS absence,
                  -- payroll.basic * 0.02 AS jamsostek,
                  -- payroll.basic * 0.01 AS bpjs

                  0 AS meal_trans_all,
                  0 AS transport_all,
                  0 AS overtime_all,
                  0 AS absence,
                  0 AS jamsostek,
                  0 as bpjs
                FROM
                  payroll
                LEFT JOIN period ON payroll.period_id = period.id) u
                SET a.transport = u.transport_all, a.jamsostek = u.jamsostek, a.bpjs = u.bpjs, a.absence = u.absence,
                a.ded_no_permite =
                CASE WHEN u.day_no_permite  = 1 THEN ((u.day_no_permite * a.basic) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 2 THEN ((a.basic) * 5) /100 + ((a.basic - ((1 * a.basic) * 5) /100) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 3 THEN ((a.basic) * 5) /100 + ((a.basic - ((2 * a.basic) * 5) /100) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 4 THEN ((a.basic) * 5) /100 + ((a.basic - ((3 * a.basic) * 5) /100) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 5 THEN ((a.basic) * 5) /100 + ((a.basic - ((4 * a.basic) * 5) /100) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 6 THEN ((a.basic) * 5) /100 + ((a.basic - ((5 * a.basic) * 5) /100) * 5) /100
                ELSE CASE WHEN u.day_no_permite  = 7 THEN ((a.basic) * 5) /100 + ((a.basic - ((6 * a.basic) * 5) /100) * 5) /100
                END END END END END END END
                , a.day_in = 28
                WHERE
                  a.id = u.id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");

        DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                              employee.id,
                              employee.basic,
                              employee.meal_trans_all,
                              employee.transport_all,
                              employee.insentive_all,
                              employee.join_date,
                              employee.status
                            FROM
                              employee) u
                SET  a.meal_trans =  ((a.day_in - a.day_no_permite) * 15000) - (a.day_late * 7500) - (15000 * a.public_holiday)
                -- , a.basic = (u.basic /25) * a.day_job
                WHERE
                  a.employee_id = u.id
                AND  (u.`status` = 0 OR u.`status` IS NULL)
                AND a.period_id = ".$id."  AND (a.check IS NULL OR a.check = 0)");

    //get aovertime amount for driver
   DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                absence.employee_id,
                absence.period_id,
                SUM(absence.overime_amount) AS overime_amount
              FROM
                absence WHERE absence.position_id = 69
              GROUP BY
                absence.employee_id,
                absence.period_id) u
                SET a.overtime = u.overime_amount
                WHERE
                  a.employee_id = u.employee_id
                AND a.period_id = ".$id." AND (a.check IS NULL OR a.check = 0)");


    /* Get Payroll Variable for Persekot*/
    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                  tarif FROM tarif WHERE description = 'Persekot') u
                SET a.persekot = u.tarif
                WHERE
                   a.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = 1
                )");

    /* Get Payroll Variable for Persekot */
    DB::update("UPDATE payroll a
                INNER JOIN (SELECT
                  tarif FROM tarif WHERE description = 'Persekot') u
                SET a.persekot = u.tarif
                WHERE
                   a.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = 1
                )");


    /* Get Serikat SPSI*/
    DB::update("UPDATE payroll
                INNER JOIN (SELECT id FROM employee WHERE confederation ='SPSI') AS employee
                ON payroll.employee_id = employee.id
                SET serikat = 25000
                WHERE
                   payroll.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = 1
                )");


    /* Get Serikat SPMKB*/
    DB::update("UPDATE payroll
                INNER JOIN (SELECT id, basic FROM employee WHERE confederation ='SPMKB') AS employee
                ON payroll.employee_id = employee.id
                SET serikat = employee.basic * 0.1
                WHERE
                   payroll.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = 1
                )");


    /* Get BPJS */
    DB::update("UPDATE payroll
                SET serikat = bpjs = basic * 0.04
                WHERE
                   payroll.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = 1
                )");


    /* Get llowance */
    DB::update("UPDATE payroll a
    INNER JOIN (SELECT
      payroll.id,
      payroll.period_id,
      payroll.employee_id,
      (IFNULL(payroll.basic,0) + IFNULL(payroll.meal_trans_all,0) + IFNULL(payroll.overtime_all,0) + IFNULL(payroll.insentif_all,0) + IFNULL(payroll.transport_all,0) + IFNULL(payroll.adjustment,0)) - (IFNULL(payroll.jamsostek,0) + IFNULL(payroll.bpjs,0) + IFNULL(payroll.pph_21, 0) + IFNULL(payroll.other_ded,0)) AS thp
    FROM
      payroll) u
    SET a.total_netto = u.thp
    WHERE
      a.id = u.id
    AND a.period_id = ".$id."");

  }


  public function edit($id)
  {

    $sql = 'SELECT
              period.id,
              period.description,
              period.date_period,
              period.begin_date,
              period.end_date,
              period.pay_date,
              period.`month`,
              period.`year`
            FROM
              period
            WHERE period.id = '.$id.'';
    $payroll = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql_detail = 'SELECT
                  payroll.id,
                  payroll.check,
                  employee.nik,
                  employee.employee_name,
                  employee.email,
                  employee.bank_account,
                  employee.bank_name,
                  employee.bank_branch,
                  employee.bank_an,
                  department.department_name,
                  payroll.employee_id,
                  payroll.period_id,
                  payroll.day_job,
                  payroll.day_in,
                  payroll.day_late,
                  position.position_name,
                  payroll.day_alpha,
                  payroll.day_no_permite,
                  payroll.ded_alpha,
                  payroll.ded_no_permite,
                  payroll.meal_trans_all AS meal_trans_all,
                  payroll.meal_trans AS meal_trans,
                  payroll.transport_all AS transport_all,
                  payroll.insentif_all AS insentif_all,
                  payroll.transport AS transport,
                  payroll.overtime_hour AS overtime_hour,
                  payroll.public_holiday AS public_holiday,
                  payroll.overtime_hour_actual AS overtime_hour_actual,
                  payroll.overtime_all AS overtime_all,
                  payroll.overtime AS overtime,
                  payroll.overtime_hour_holiday AS overtime_hour_holiday,
                  payroll.overtime_holiday AS overtime_holiday,
                  payroll.premi_sunday AS premi_sunday,
                  payroll.premi_production AS premi_production,
                  payroll.insentive AS insentive,
                  payroll.jamsostek AS jamsostek,
                  payroll.absence AS absence,
                  payroll.bpjs AS bpjs,
                  payroll.total_loan AS total_loan,
                  payroll.pph_21 AS pph_21,
                  payroll.other_ded AS other_ded,
                  payroll.total_ded AS total_ded,
                  payroll.total_bruto AS total_bruto,
                  payroll.total_netto AS total_netto,
                  payroll.pot_jamsostek AS pot_jamsostek,
                  payroll.pot_bpjs AS pot_bpjs,
                  payroll.basic
                FROM
                  payroll
                LEFT JOIN employee ON payroll.employee_id = employee.id
                LEFT JOIN department ON employee.department_id = department.id
                LEFT JOIN position ON employee.position_id = position.id
                WHERE payroll.period_id = '.$id.' AND employee.deleted_at IS NULL';
    $payroll_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->orderBy('employee_name', 'ASC')->get();

    // dd($payroll_detail);

    return view ('editor.payroll.form', compact('payroll', 'payroll_detail'));
  }

  public function report($id)
  {

    $sql = 'SELECT
              period.id,
              period.description,
              period.date_period,
              period.begin_date,
              period.end_date,
              period.pay_date,
              period.`month`,
              period.`year`
            FROM
              period
            WHERE period.id = '.$id.'';
    $payroll = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql_detail = 'SELECT
                  payroll.id,
                  payroll.check,
                  employee.nik,
                  employee.employee_name,
                  department.department_name,
                  payroll.employee_id,
                  payroll.period_id,
                  payroll.day_job,
                  payroll.day_late,
                  payroll.basic,
                  position.position_name,
                  payroll.day_alpha,
                  payroll.day_no_permite,
                  payroll.ded_alpha,
                  payroll.ded_no_permite,
                  FORMAT(payroll.meal_trans_all, 0) AS meal_trans_all,
                  FORMAT(payroll.meal_trans, 0) AS meal_trans,
                  FORMAT(payroll.transport_all, 0) AS transport_all,
                  FORMAT(payroll.transport, 0) AS transport,
                  FORMAT(payroll.insentif_all, 0) AS insentif_all,
                  FORMAT(payroll.overtime_hour, 0) AS overtime_hour,
                  FORMAT(payroll.overtime_hour_actual, 0) AS overtime_hour_actual,
                  payroll.overtime_hour_holiday AS overtime_hour_holiday,
                  FORMAT(payroll.overtime_holiday, 0) AS overtime_holiday,
                  FORMAT(payroll.overtime_all, 0) AS overtime_all,
                  FORMAT(payroll.overtime, 0) AS overtime,
                  FORMAT(payroll.premi_night, 0) AS premi_night,
                  FORMAT(payroll.premi_sunday, 0) AS premi_sunday,
                  FORMAT(payroll.premi_production, 0) AS premi_production,
                  FORMAT(payroll.insentive, 0) AS insentive,
                  FORMAT(payroll.jamsostek, 0) AS jamsostek,
                  FORMAT(payroll.absence, 0) AS absence,
                  FORMAT(payroll.bpjs, 0) AS bpjs,
                  FORMAT(payroll.total_loan, 0) AS total_loan,
                  FORMAT(payroll.pph_21, 0) AS pph_21,
                  FORMAT(payroll.adjustment, 0) AS adjustment,
                  FORMAT(payroll.total_bruto, 0) AS total_bruto,
                  FORMAT(payroll.total_netto,0) AS total_netto,
                  FORMAT(payroll.other_ded, 0) AS other_ded
                FROM
                  payroll
                LEFT JOIN employee ON payroll.employee_id = employee.id
                LEFT JOIN department ON employee.department_id = department.id
                LEFT JOIN position ON employee.position_id = position.id
                WHERE payroll.period_id = '.$id.' AND employee.deleted_at IS NULL';
    $payroll_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->orderBy('employee_name', 'ASC')->get();

    // dd($payroll_detail);

    return view ('editor.payroll.report', compact('payroll', 'payroll_detail'));
  }

  public function report_print($id)
  {

    $sql = 'SELECT
              period.id,
              period.description,
              period.date_period,
              period.begin_date,
              period.end_date,
              period.pay_date,
              period.`month`,
              period.`year`
            FROM
              period
            WHERE period.id = '.$id.'';
    $payroll = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql_detail = 'SELECT
                  payroll.id,
                  payroll.check,
                  employee.nik,
                  employee.employee_name,
                  department.department_name,
                  payroll.employee_id,
                  payroll.period_id,
                  payroll.day_in,
                  payroll.day_job,
                  payroll.day_late,
                  payroll.public_holiday,
                  payroll.basic,
                  position.position_name,
                  payroll.day_alpha,
                  payroll.day_no_permite,
                  payroll.ded_alpha,
                  payroll.ded_no_permite,
                  FORMAT(payroll.meal_trans_all, 0) AS meal_trans_all,
                  FORMAT(payroll.meal_trans, 0) AS meal_trans,
                  FORMAT(payroll.transport_all, 0) AS transport_all,
                  FORMAT(payroll.insentif_all, 0) AS insentif_all,
                  FORMAT(payroll.transport, 0) AS transport,
                  FORMAT(payroll.overtime_hour, 0) AS overtime_hour,
                  FORMAT(payroll.overtime_hour_actual, 0) AS overtime_hour_actual,
                   payroll.overtime_hour_holiday AS overtime_hour_holiday,
                  FORMAT(payroll.overtime_holiday, 0) AS overtime_holiday,
                  FORMAT(payroll.overtime_all, 0) AS overtime_all,
                  FORMAT(payroll.overtime, 0) AS overtime,
                  FORMAT(payroll.premi_night, 0) AS premi_night,
                  FORMAT(payroll.premi_sunday, 0) AS premi_sunday,
                  FORMAT(payroll.premi_production, 0) AS premi_production,
                  FORMAT(payroll.insentive, 0) AS insentive,
                  FORMAT(payroll.jamsostek, 0) AS jamsostek,
                  FORMAT(payroll.absence, 0) AS absence,
                  FORMAT(payroll.bpjs, 0) AS bpjs,
                  FORMAT(payroll.total_loan, 0) AS total_loan,
                  FORMAT(payroll.pph_21, 0) AS pph_21,
                  FORMAT(payroll.adjustment, 0) AS adjustment,
                  FORMAT(payroll.other_ded,0) AS other_ded,
                  FORMAT(payroll.total_bruto, 0) AS total_bruto,
                  FORMAT(payroll.total_netto,0) AS total_netto,
                  FORMAT(payroll.total_ded, 0) AS total_ded
                FROM
                  payroll
                LEFT JOIN employee ON payroll.employee_id = employee.id
                LEFT JOIN department ON employee.department_id = department.id
                LEFT JOIN position ON employee.position_id = position.id
                WHERE payroll.period_id = '.$id.' AND employee.deleted_at IS NULL';
    $payroll_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->orderBy('employee_name', 'ASC')->get();

    // dd($payroll_detail);

    return view ('editor.payroll.report_print', compact('payroll', 'payroll_detail'));
  }

  public function datadetail(Request $request, $id)
  {

    // if($request->ajax()){
      $sql = 'SELECT
                  employee.employee_name,
                  department.department_name,
                  payroll.other_ded,
                  payroll.others_all,
                  payroll.vehicle_loan,
                  payroll.home_loan,
                  Payroll.id
                FROM
                  payroll
                INNER JOIN employee ON payroll.employee_id = employee.id
                INNER JOIN department ON payroll.department_id = department.id
                WHERE payroll.period_id = '.$id.' AND employee.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

      ->make(true);
    // } else {
    //   exit("No data available");
    // }
  }


  public function update($id, Request $request)
  {

    foreach($request->input('detail') as $key => $detail_data)
    {
      if( isset($detail_data['check'])){
        $check = 1;
      }else{
        $check = 0;
      };

      // dd($check);

      $payroll_detail = Payroll::Find($key);
      $payroll_detail->check = $check;
      // $payroll_detail->public_holiday = $detail_data['public_holiday'];
      $payroll_detail->day_alpha = str_replace("","",$detail_data['day_alpha']);
      $payroll_detail->day_late =str_replace("","",$detail_data['day_late']);
      $payroll_detail->basic = str_replace(",", "", $detail_data['basic']);
      $payroll_detail->meal_trans_all = str_replace(",", "", $detail_data['meal_trans_all']);
      // $payroll_detail->insentif_all = str_replace(",", "", $detail_data['insentif_all']);
      // $payroll_detail->transport_all = str_replace(",", "", $detail_data['transport_all']);
      $payroll_detail->overtime_all = str_replace(",", "", $detail_data['overtime_all']);
      $payroll_detail->jamsostek = str_replace(",", "", $detail_data['jamsostek']);
      $payroll_detail->bpjs = str_replace(",", "", $detail_data['bpjs']);
      $payroll_detail->pph_21 = str_replace(",", "", $detail_data['pph_21']);
      $payroll_detail->other_ded = str_replace(",", "", $detail_data['other_ded']);
      $payroll_detail->total_ded = str_replace(",","",$detail_data['total_ded']);
      $payroll_detail->total_bruto = str_replace(",","",$detail_data['total_bruto']);
      $payroll_detail->total_netto = str_replace(",","",$detail_data['total_netto']);
      $payroll_detail->save();
    }

    /* create function convert rupiah to number*/
    function convert_to_number($rupiah){
      return intval(preg_replace("/,.*|[^0-9]/", '', $rupiah));
    }

    $count = TotalSalary::where('period_id', $id)->count();
    // dd($count);
    if($count > 0){
      // update data
      $item = TotalSalary::where('period_id', $id)->first();
      $item->period_id = $id;
      $item->total_gapok = convert_to_number($request->totalGapok);
      $item->total_lembur = convert_to_number($request->totalOvertime);
      $item->total_meal_transport = convert_to_number($request->totalMealTrans);
      $item->total_bpjstk = convert_to_number($request->totalJamsostek);
      $item->total_bpjskes = convert_to_number($request->totalJamkes);
      $item->total_pph21 = convert_to_number($request->totalPph);
      $item->total_pot_lain = convert_to_number($request->totalOtherDed);
      $item->total_bruto = convert_to_number($request->totalBruto);
      $item->total_potongan = convert_to_number($request->totalPotongan);
      $item->total_thp = convert_to_number($request->totalNetto);
      $item->save();

    } else {
      // insert
      $item = new TotalSalary;
      $item->period_id = $id;
      $item->total_gapok = convert_to_number($request->totalGapok);
      $item->total_lembur = convert_to_number($request->totalOvertime);
      $item->total_meal_transport = convert_to_number($request->totalMealTrans);
      $item->total_bpjstk = convert_to_number($request->totalJamsostek);
      $item->total_bpjskes = convert_to_number($request->totalJamkes);
      $item->total_pph21 = convert_to_number($request->totalPph);
      $item->total_pot_lain = convert_to_number($request->totalOtherDed);
      $item->total_bruto = convert_to_number($request->totalBruto);
      $item->total_potongan = convert_to_number($request->totalPotongan);
      $item->total_thp = convert_to_number($request->totalNetto);
      $item->save();

    }
    // return redirect()->action('Editor\PayrollController@index');
    return back();
  }

  public function store_absence(Request $request)
  {

    $post = User::where('id', Auth::id())->first();
    $post->employee_id = $request->employee_id;
    $post->period_id = $request->period_id;
    $post->save();

    return response()->json($post);
  }


  public function slip($id)
    {


        $sql = 'SELECT
                  payroll.id,
                  payroll.period_id,
                  employee.employee_name,
                  employee.nik,
                  employee.address,
                  employee.identity_no,
                  date_format(employee.join_date, "%d/%m/%Y") AS join_date,
                  payroll.basic,
                  date_format(period.begin_date, "%d") AS begin_date,
                  date_format(period.end_date, "%d/%m/%Y") AS end_date,
                  payroll.day_job,
                  payroll.jamsostek,
                  payroll.bpjs,
                  payroll.total_loan,
                  payroll.pph_21_all,
                  payroll.day_in,
                  payroll.overtime,
                  payroll.adjustment,
                  payroll.ded_no_permite,
                  payroll.overtime_holiday,
                  payroll.meal_trans,
                  payroll.overtime_all,
                  payroll.transport_all,
                  payroll.meal_trans_all,
                  payroll.insentive,
                  payroll.absence,
                  payroll.pot_jamsostek,
                  payroll.pot_bpjs,
                  payroll.pph_21,
                  payroll.other_ded,
                  payroll.dt_pot_jamsostek_karyawan,
                  payroll.dt_pot_jamsostek_perusahaan,
                  payroll.dt_pot_bpjs_karyawan,
                  payroll.dt_pot_bpjs_perusahaan,
                  payroll.total_bpjs_perusahaan,
                  payroll.total_jamsostek_perusahaan,
                  payroll.total_bruto,
                  payroll.total_ded,
                  payroll.total_netto,
                  employee.npwp,
                  employee.bank_account,
                  employee.bank_name,
                  employee.bank_branch,
                  employee.bank_an,
                  position.position_name,
                  period.description,
                  employee.bpjs_kesehatan_no
                FROM
                  payroll
                INNER JOIN employee ON payroll.employee_id = employee.id
                LEFT JOIN period ON payroll.period_id = period.id
                LEFT JOIN position ON employee.position_id = position.id
                WHERE payroll.id = '.$id.' ';
        $payroll = DB::table(DB::raw("($sql) as rs_sql"))->first();
        $payrollSetting = PayrollSetting::Find(1);
        // dd(json_decode($payroll->dt_pot_bpjs));
        $detail_bpjs_karyawan = json_decode($payroll->dt_pot_bpjs_karyawan);
        $detail_bpjs_perusahaan = json_decode($payroll->dt_pot_bpjs_perusahaan);
        $detail_jamsostek_karyawan = json_decode($payroll->dt_pot_jamsostek_karyawan);
        $detail_jamsostek_perusahaan = json_decode($payroll->dt_pot_jamsostek_perusahaan);

      return view ('editor.payroll.slip', compact('payroll', 'detail_bpjs_karyawan', 'detail_bpjs_perusahaan', 'detail_jamsostek_karyawan', 'detail_jamsostek_perusahaan', 'payrollSetting'));
    }


    public function slip_print($id)
  {

     $sql = 'SELECT
                payroll.id,
                payroll.period_id,
                employee.employee_name,
                employee.nik,
                employee.address,
                employee.identity_no,
                date_format(employee.join_date, "%d/%m/%Y") AS join_date,
                payroll.basic,
                date_format(period.begin_date, "%d") AS begin_date,
                date_format(period.end_date, "%d/%m/%Y") AS end_date,
                payroll.day_job,
                payroll.jamsostek,
                payroll.bpjs,
                payroll.total_loan,
                payroll.pph_21_all,
                payroll.pph_21,
                payroll.other_ded,
                payroll.day_in,
                payroll.overtime,
                payroll.adjustment,
                payroll.ded_no_permite,
                payroll.overtime_holiday,
                payroll.meal_trans,
                payroll.overtime_all,
                payroll.transport_all,
                payroll.meal_trans_all,
                payroll.total_netto,
                payroll.insentive,
                payroll.absence,
                payroll.total_ded,
                payroll.total_bruto,
                employee.npwp,
                employee.bank_account,
                employee.bank_name,
                employee.bank_branch,
                employee.bank_an,
                position.position_name,
                period.description,
                employee.bpjs_kesehatan_no
              FROM
                payroll
              INNER JOIN employee ON payroll.employee_id = employee.id
              LEFT JOIN period ON payroll.period_id = period.id
              LEFT JOIN position ON employee.position_id = position.id
              WHERE payroll.period_id = '.$id.' ';
      $payrolls = DB::table(DB::raw("($sql) as rs_sql"))->get();


    return view ('editor.payroll.slip_print', compact('payrolls'));
  }

  public function create_calc_bpjs(Request $request)
  {
    $detail_jaminan_karyawan = [];
    $detail_jaminan_perusahaan = [];
    $datas = $request->input("data_table");
    $id = $request->input("payroll_id");
    $total_bpjs = $request->input("total_bpjs");
    $total_bpjs_perusahaan = $request->input("total_bpjs_perusahaan");
    $kategori = $request->input("kategori");

    for($i = 0; $i < count($datas); $i++){
      $tunjangan_karyawan = [
        'nama_jaminan'=> $datas[$i]["nama_jaminan"],
        'nominal_jaminan_karyawan' => $datas[$i]["bpjs_ditanggung_karyawan_rp"] + $datas[$i]["bpjs_ditanggung_perusahaan_rp"]
        ];

      $tunjangan_perusahaan = [
        'nama_jaminan'=> $datas[$i]["nama_jaminan"],
        'nominal_jaminan_perusahaan' => $datas[$i]["bpjs_ditanggung_perusahaan_rp"]
        ];

        array_push($detail_jaminan_karyawan, $tunjangan_karyawan);
        array_push($detail_jaminan_perusahaan, $tunjangan_perusahaan);
      }

    $payroll_detail = Payroll::find($id);

    if($kategori == 'Ketenagakerjaan'){
      $payroll_detail->jamsostek = $total_bpjs;
      $payroll_detail->total_jamsostek_perusahaan = $total_bpjs_perusahaan;
      $payroll_detail->dt_pot_jamsostek_karyawan = json_encode($detail_jaminan_karyawan);
      $payroll_detail->dt_pot_jamsostek_perusahaan = json_encode($detail_jaminan_perusahaan);
      $payroll_detail->save();
    }else{

      $payroll_detail = Payroll::find($id);
      $payroll_detail->bpjs = $total_bpjs;
      $payroll_detail->total_bpjs_perusahaan = $total_bpjs_perusahaan;
      $payroll_detail->dt_pot_bpjs_karyawan = json_encode($detail_jaminan_karyawan);
      $payroll_detail->dt_pot_bpjs_perusahaan = json_encode($detail_jaminan_perusahaan);
      $payroll_detail->save();
    }

    $data = [
      'success' => true,
      'message' => 'Berhasil disimpan'
    ];

    return response()->json($data, 200);
  }

  public function say_hello()
  {
      $data = [
        "success" => true,
        "message" => "Hello coders... Are u okay?",
        'url' => url('/api/payroll/say_hello')
    ];

    return response()->json($data, 200);
  }

  public function search_overtime(Request $request)
  {
    $search = $request->get("search");
    $data = Overtime::join('employee', 'employee.id', '=', 'overtime.employee_id')
              ->where('overtime.no_trans', 'like', '%' . $search . '%')
              ->orWhere('overtime.date_trans', $search)
              ->get();

    $results = array();
    foreach ($data as $value) {
      $results[] = [
        'value' => $value->total_rate,
        'label'=> 'No. dan tanggal lembur: '.$value->no_trans.' dan '.$value->date_trans.' - '. $value->employee_name
      ];
    }
    return response()->json($results);
  }

  public function create_calc_overtime(Request $request)
  {
    $id = $request->input('payroll_id');
    $total_overtime = $request->input('total_overtime');

    $payroll = Payroll::find($id);
    $payroll->overtime_all = $total_overtime;
    $payroll->save();

    $data = [
      'success' => true,
      'message' => 'Berhasil disimpan'
    ];

    return response()->json($data, 200);
  }

  public function search_schema(Request $request)
  {
    $term = $request->get("term");
    $type_bpjs = $request->get("type_bpjs");

    switch($type_bpjs) {
      case 'Ketenagakerjaan':
        $data = BPJSTK::where('schema_name', 'like', '%' . $term . '%')
              ->get();
        break;
      case 'Kesehatan':
        $data = BPJSKesehatan::where('schema_name', 'like', '%' . $term . '%')
              ->get();
        break;
      default:
        $data = [];
        break;
    }


    $results = array();
    foreach ($data as $value) {
      // $results[] = array(
      //   'value' => $value->schema_name,
      //   'label' => $value->schema_name
      // );
      $results[] = $value;
    }
    return response()->json($results);
  }

  public function bpjs_details(Request $request)
  {
    $name = $request->get('name');
    $type_bpjs = $request->get("type_bpjs");

    switch($type_bpjs) {
      case 'Ketenagakerjaan':
        $bpjs = BPJSTK::where('schema_name', $name)->first();
        $data = BPJSTKDetail::where('bpjstk_id', $bpjs->id)
              ->get();
        break;
      case 'Kesehatan':
        $bpjs = BPJSKesehatan::where('schema_name', $name)->first();
        $data = BPJSKesDetail::where('bpjs_kesehatan_id', $bpjs->id)
              ->get();
        break;
      default:
        $data = [];
        break;
    }

    $results = array();
    foreach ($data as $value) {
      $results[] = $value;
    }
    return response()->json($results);
  }

  function send_receipt(Request $request)
  {
    try {
        $validator = FacadesValidator::make($request->all(), [
            'employee_id' => 'required',
            'periode_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee_id = $request->employee_id;
        $periode_id = $request->periode_id;

        $sql = 'SELECT
                payroll.id,
                payroll.period_id,
                employee.employee_name,
                employee.nik,
                employee.address,
                employee.identity_no,
                date_format(employee.join_date, "%d/%m/%Y") AS join_date,
                payroll.basic,
                date_format(period.begin_date, "%d") AS begin_date,
                date_format(period.end_date, "%d/%m/%Y") AS end_date,
                payroll.day_job,
                payroll.jamsostek,
                payroll.bpjs,
                payroll.total_loan,
                payroll.pph_21_all,
                payroll.pph_21,
                payroll.other_ded,
                payroll.day_in,
                payroll.overtime,
                payroll.adjustment,
                payroll.ded_no_permite,
                payroll.overtime_holiday,
                payroll.meal_trans,
                payroll.overtime_all,
                payroll.transport_all,
                payroll.meal_trans_all,
                payroll.total_netto,
                payroll.insentive,
                payroll.absence,
                payroll.total_ded,
                payroll.total_bruto,
                employee.npwp,
                employee.bank_account,
                employee.bank_name,
                employee.bank_branch,
                employee.bank_an,
                position.position_name,
                period.description,
                employee.bpjs_kesehatan_no
              FROM
                payroll
              INNER JOIN employee ON payroll.employee_id = employee.id
              LEFT JOIN period ON payroll.period_id = period.id
              LEFT JOIN position ON employee.position_id = position.id
              WHERE payroll.period_id = '.$periode_id.'
              AND payroll.employee_id = '.$employee_id.' ';
      $payrolls = DB::table(DB::raw("($sql) as rs_sql"))->get();

        if (empty($payrolls)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $pdf = Pdf::loadView('editor.payroll.slip_print_employee', compact('payrolls'))
            ->setPaper('A4', 'landscape')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('margin-top', '0mm');

        // return response()->json([
        //     'pdf_url' => base64_encode($pdf->output()),
        // ]);

        // Simpan file PDF sementara di server
        $fileName = 'slip-payroll-' . now()->timestamp . '.pdf';
        $filePath = storage_path('app/public/' . $fileName);
        $pdf->save($filePath);

        return response()->json([
            'pdf_url' => asset('storage/' . $fileName),
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Internal Server Error',
            'error' => $th->getMessage(),
            'file' => $th->getFile(),
        ], 500);
    }
  }

  public function listSlipGaji(Request $request)
  {
    try {
        $validator = FacadesValidator::make($request->all(), [
            'employee_id' => 'required',
            'periode_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee_id = $request->employee_id;
        $periode_id = $request->periode_id;

        $sql = 'SELECT
                payroll.id,
                payroll.period_id,
                employee.employee_name,
                employee.nik,
                employee.address,
                employee.identity_no,
                date_format(employee.join_date, "%d/%m/%Y") AS join_date,
                payroll.basic,
                date_format(period.begin_date, "%d") AS begin_date,
                date_format(period.end_date, "%d/%m/%Y") AS end_date,
                payroll.day_job,
                payroll.jamsostek,
                payroll.bpjs,
                payroll.total_loan,
                payroll.pph_21_all,
                payroll.pph_21,
                payroll.other_ded,
                payroll.day_in,
                payroll.overtime,
                payroll.adjustment,
                payroll.ded_no_permite,
                payroll.overtime_holiday,
                payroll.meal_trans,
                payroll.overtime_all,
                payroll.transport_all,
                payroll.meal_trans_all,
                payroll.total_netto,
                payroll.insentive,
                payroll.absence,
                payroll.total_ded,
                payroll.total_bruto,
                employee.npwp,
                employee.bank_account,
                employee.bank_name,
                employee.bank_branch,
                employee.bank_an,
                position.position_name,
                period.description,
                employee.bpjs_kesehatan_no
              FROM
                payroll
              INNER JOIN employee ON payroll.employee_id = employee.id
              LEFT JOIN period ON payroll.period_id = period.id
              LEFT JOIN position ON employee.position_id = position.id
              WHERE payroll.period_id = '.$periode_id.'
              AND payroll.employee_id = '.$employee_id.' ';

      $payrolls = DB::table(DB::raw("($sql) as rs_sql"))->get();

        if (empty($payrolls)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        // Inisialisasi array untuk menyimpan URL slip gaji
        $payrollSlipUrls = [];

        // Loop untuk setiap payroll, generate file PDF individu
        foreach ($payrolls as $payroll) {
            $pdf = Pdf::loadView('editor.payroll.slip_print_employee', compact('payroll'))
                ->setPaper('A4', 'landscape')
                ->setOption('margin-left', '10mm')
                ->setOption('margin-right', '10mm')
                ->setOption('margin-top', '0mm');

            $fileName = 'slip-payroll-' . $payroll->id . '-' . now()->timestamp . '.pdf'; // Gunakan ID payroll untuk unik
            $filePath = storage_path('app/public/' . $fileName);
            $pdf->save($filePath);

            // Tambahkan URL file ke array
            $payrollSlipUrls[] = [
                'employee_name' => $payroll->employee_name, // Nama karyawan (ganti sesuai field data Anda)
                'payroll_id' => $payroll->id, // ID payroll (ganti sesuai field data Anda)
                'download_url' => asset('storage/' . $fileName), // URL unduhan
            ];
        }

        // Return daftar URL slip gaji
        return response()->json([
            'success' => true,
            'message' => 'Payroll slips generated successfully',
            'data' => $payrollSlipUrls, // Daftar slip gaji
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Internal Server Error',
            'error' => $th->getMessage(),
        ], 500);
    }
  }

  public function detailSlipGaji($id)
  {
    $sql = 'SELECT
            payroll.id,
            payroll.period_id,
            employee.employee_name,
            employee.nik,
            employee.address,
            employee.identity_no,
            date_format(employee.join_date, "%d/%m/%Y") AS join_date,
            payroll.basic,
            date_format(period.begin_date, "%d") AS begin_date,
            date_format(period.end_date, "%d/%m/%Y") AS end_date,
            payroll.day_job,
            payroll.jamsostek,
            payroll.bpjs,
            payroll.total_loan,
            payroll.pph_21_all,
            payroll.day_in,
            payroll.overtime,
            payroll.adjustment,
            payroll.ded_no_permite,
            payroll.overtime_holiday,
            payroll.meal_trans,
            payroll.overtime_all,
            payroll.transport_all,
            payroll.meal_trans_all,
            payroll.insentive,
            payroll.absence,
            payroll.pot_jamsostek,
            payroll.pot_bpjs,
            payroll.pph_21,
            payroll.other_ded,
            payroll.dt_pot_jamsostek_karyawan,
            payroll.dt_pot_jamsostek_perusahaan,
            payroll.dt_pot_bpjs_karyawan,
            payroll.dt_pot_bpjs_perusahaan,
            payroll.total_bpjs_perusahaan,
            payroll.total_jamsostek_perusahaan,
            payroll.total_bruto,
            payroll.total_ded,
            payroll.total_netto,
            employee.npwp,
            employee.bank_account,
            employee.bank_name,
            employee.bank_branch,
            employee.bank_an,
            position.position_name,
            period.description,
            employee.bpjs_kesehatan_no
        FROM
            payroll
        INNER JOIN employee ON payroll.employee_id = employee.id
        LEFT JOIN period ON payroll.period_id = period.id
        LEFT JOIN position ON employee.position_id = position.id
        WHERE payroll.id = '.$id.' ';
    $payroll = DB::table(DB::raw("($sql) as rs_sql"))->first();

    if (empty($payroll)) {
        return response()->json([
            'status' => false,
            'message' => 'Data not found'
        ], 404);
    }

    $payrollSetting = PayrollSetting::Find(1);

    $detail_bpjs_karyawan = json_decode($payroll->dt_pot_bpjs_karyawan);
    $detail_bpjs_perusahaan = json_decode($payroll->dt_pot_bpjs_perusahaan);
    $detail_jamsostek_karyawan = json_decode($payroll->dt_pot_jamsostek_karyawan);
    $detail_jamsostek_perusahaan = json_decode($payroll->dt_pot_jamsostek_perusahaan);

    return response()->json([
        'success' => true,
        'message' => 'Data found',
        'data' => [
            'payroll' => $payroll,
            'payroll_setting' => $payrollSetting,
            'detail_bpjs_karyawan' => $payroll->dt_pot_bpjs_karyawan,
            'detail_bpjs_perusahaan' => $payroll->dt_pot_bpjs_perusahaan,
            'detail_jamsostek_karyawan' => $payroll->dt_pot_jamsostek_karyawan,
            'detail_jamsostek_perusahaan' => $payroll->dt_pot_jamsostek_perusahaan
        ]
    ]);
  }
}
