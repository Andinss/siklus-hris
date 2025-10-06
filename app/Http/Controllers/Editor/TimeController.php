<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TimeRequest;
use App\Http\Controllers\Controller;
use App\Models\Time;
use App\Models\Period;
use App\Models\Department;
use App\Models\AbsenceType;
use App\Models\Shiftgroup;
use App\Models\Absencelog;
use App\Models\Attlog;
use App\Models\User;
use App\Models\Workcalendar;
use App\Models\Shift;
use Validator;
use Response;
use App\Post;
use View;

//Editor
use
    App\Editor,
    App\Editor\Field,
    App\Editor\Format,
    App\Editor\Mjoin,
    App\Editor\Options,
    App\Editor\Upload,
    App\Editor\Validate;
use App\Models\AbsenceLocation;
use App\Models\AbsencePeriod;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('user_copy')->delete();
        })->everyMinute();
    }
}


class TimeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
        'timename' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function index(Request $request)
  {


    // $times = Time::all();
    // $period_list = Period::all()->pluck('description', 'id');
    $shift_list = Shift::all();
    // $sql_period = 'SELECT
    //           CONCAT(
    //             "Period: ",
    //             DATE_FORMAT(
    //               period.begin_date,
    //               "%d-%m-%Y"
    //             ),
    //             " sampai ",
    //             DATE_FORMAT(
    //               period.end_date,
    //               "%d-%m-%Y"
    //             )
    //           ) AS description,
    //           period.id
    //         FROM
    //           period
    //         WHERE period.status = 0 AND period.deleted_at IS NULL';
    // $period_list = DB::table(DB::raw("($sql_period) as rs_sql"))->get()->pluck('description', 'id');
    $sql_period = 'SELECT
              CONCAT(
                "Period: ",
                DATE_FORMAT(
                  absence_period.begin_date,
                  "%d-%m-%Y"
                ),
                " sampai ",
                DATE_FORMAT(
                  absence_period.end_date,
                  "%d-%m-%Y"
                )
              ) AS description,
              absence_period.id
            FROM
              absence_period
            WHERE absence_period.status = 0 AND absence_period.deleted_at IS NULL';
    $period_list = DB::table(DB::raw("($sql_period) as rs_sql"))->get()->pluck('description', 'id');
    $department_list = Department::all()->pluck('department_name', 'departmentcode');


    return view ('editor.time.index', compact('period_list','department_list', 'shift_list'), [
        'period' => strtoupper($request->input('period'))
    ]);
  }


  public function indexview(Request $request)
  {

    $times = Time::all();
    // $period_list = Period::all()->pluck('description', 'id');
    $sql_period = 'SELECT
          CONCAT(
            "Period: ",
            DATE_FORMAT(
              period.begin_date,
              "%d-%m-%Y"
            ),
            " to ",
            DATE_FORMAT(
              period.end_date,
              "%d-%m-%Y"
            )
          ) AS description,
          period.id
        FROM
          period
        WHERE period.status = 0';
    $period_list = DB::table(DB::raw("($sql_period) as rs_sql"))->get()->pluck('description', 'id');
    $department_list = Department::all()->pluck('department_name', 'departmentcode');


    return view ('editor.time_view.index', compact('times','period_list','department_list'), [
        'period' => strtoupper($request->input('period'))
    ]);
  }

  public function data(Request $request)
  {
    if($request->ajax()){
      $sql = 'SELECT
                employee.id,
                employee.nik,
                employee.identity_no,
                employee.employee_name,
                employee.email,
                employee.position_id,
                position.position_name,
                employee.department_id,
                department.department_name,
                -- period.description,
                absence_period.id AS period_id,
                shift_group.shift_group_name
              FROM
                employee
              LEFT JOIN position ON employee.position_id = position.id
              LEFT JOIN department ON employee.department_id = department.id
              INNER JOIN (
                SELECT
                  absence.employee_id,
                  absence.period_id
                FROM
                  absence
                WHERE absence.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = "'.Auth::id().'"
                )
                GROUP BY
                  absence.employee_id,
                  absence.period_id
              ) AS absence ON employee.id = absence.employee_id
              INNER JOIN absence_period ON absence.period_id = absence_period.id
              LEFT JOIN shift_group ON employee.shift_group_id = shift_group.id
              WHERE employee.deleted_at IS NULL';

      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)

      ->addColumn('action', function ($itemdata) {
        return '
          <a href="time/'.$itemdata->period_id.'/'.$itemdata->id.'/edit" title="Detail" class="btn btn-primary btn-xs btn-flat mr-2" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-folder"></i> Detail</a>
          <a href="time/'.$itemdata->period_id.'/'.$itemdata->id.'/print" title="Download PDF" class="btn btn-secondary btn-xs btn-flat" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-download"></i> Download PDF</a>
          ';
      })

      ->toJson();
    } else {
      exit("No data available");
    }
  }


  public function dataview(Request $request)
  {
    if($request->ajax()){
      $sql = 'SELECT
                employee.id,
                employee.nik,
                employee.employee_name,
                employee.position_id,
                position.position_name,
                employee.department_id,
                department.department_name,
                period.description,
                period.id AS period_id,
                shift_group.shift_group_name
              FROM
                employee
              LEFT JOIN position ON employee.position_id = position.id
              LEFT JOIN department ON employee.department_id = department.id
              INNER JOIN (
                SELECT
                  absence.employee_id,
                  absence.period_id
                FROM
                  absence
                WHERE absence.period_id = (
                  SELECT
                    user.period_id
                  FROM
                    `user`
                  WHERE
                    user.id = "'.Auth::id().'"
                )
                GROUP BY
                  absence.employee_id,
                  absence.period_id
              ) AS absence ON employee.id = absence.employee_id
              INNER JOIN period ON absence.period_id = period.id
              LEFT JOIN shift_group ON employee.shift_group_id = shift_group.id';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

      ->addColumn('action', function ($itemdata) {
        return '<a href="time_view/'.$itemdata->period_id.'/'.$itemdata->id.'/edit" title="Detail" class="btn btn-primary btn-xs btn-flat" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-folder"></i> Detail</a>';
      })

      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  {

    // //update user
    DB::insert("UPDATE user AS A INNER JOIN (SELECT
        absence_period.id,
        absence_period.begin_date,
        absence_period.end_date
        FROM absence_period
        WHERE absence_period.id='".$request->period_id."') AS U SET A.period_id = U.id, A.begin_date = U.begin_date, A.end_date = U.end_date WHERE A.id='".Auth::id()."'");

    //update work calendar
    DB::insert("DELETE FROM work_calendar");
    DB::insert("set @i = -1");
    DB::insert("INSERT INTO work_calendar
        (`date`)
        SELECT DATE(ADDDATE(user.begin_date, INTERVAL @i:=@i+1 DAY)) AS date FROM privilege join user
        WHERE user.id='".Auth::id()."'
        HAVING
        @i < DATEDIFF((SELECT end_date FROM user WHERE id='".Auth::id()."'), (SELECT begin_date FROM user WHERE id='".Auth::id()."'))");

    // insert to time
    DB::insert("INSERT INTO absence
        (employee_id, nik, date_in, period_id)
        SELECT
          derivedtbl.id,
          derivedtbl.nik,
          derivedtbl.`date`,
          ".$request->period_id."
        FROM
          (
            SELECT
              employee.id,
              employee.nik,
              work_calendar.`date`
            FROM
              employee
            INNER JOIN work_calendar ON employee.join_date <= work_calendar.`date`
            JOIN `user`
            WHERE
              (
                work_calendar.`date` BETWEEN user.begin_date
                AND user.end_date
              )
            AND user.id = '".Auth::id()."'
          ) derivedtbl
        LEFT JOIN holiday ON derivedtbl.`date` = holiday.holiday_date
        LEFT JOIN absence ON absence.employee_id = derivedtbl.id
        AND absence.date_in = derivedtbl.`date`
        WHERE
          (
            derivedtbl.id,
            derivedtbl.`date`,
            ".$request->period_id."
          ) NOT IN (
            SELECT
              absence.employee_id,
              absence.date_in,
              absence.period_id
            FROM
              absence
          )
        GROUP BY
          derivedtbl.id,
          derivedtbl.nik,
          derivedtbl.`date`");



    // insert to time
    DB::insert("INSERT INTO shift_schedule
        (employee_id, nik, date_in, period_id, shift_id, remark, status)
        SELECT
          derivedtbl.id,
          derivedtbl.nik,
          derivedtbl.`date`,
          ".$request->period_id.",
          '0',
          '',
          '0'
        FROM
          (
            SELECT
              employee.id,
              employee.nik,
              work_calendar.`date`
            FROM
              employee, work_calendar
            JOIN `user`
            WHERE
              (
                work_calendar.`date` BETWEEN user.begin_date
                AND user.end_date
              )
            AND user.id = '".Auth::id()."' AND employee.deleted_at IS NULL
          ) derivedtbl
        LEFT JOIN holiday ON derivedtbl.`date` = holiday.holiday_date
        LEFT JOIN shift_schedule ON shift_schedule.employee_id = derivedtbl.id
        AND shift_schedule.date_in = derivedtbl.`date`
        WHERE
          (
            derivedtbl.id,
            derivedtbl.`date`,
            ".$request->period_id."
          ) NOT IN (
            SELECT
              shift_schedule.employee_id,
              shift_schedule.date_in,
              shift_schedule.period_id
            FROM
              shift_schedule
          )
        GROUP BY
          derivedtbl.id,
          derivedtbl.nik,
          derivedtbl.`date`");

  }

  public function generate($id, Request $request)
  {

      //dif date period
      $date_period = '(
                        SELECT
                          user.begin_date
                        FROM
                          user
                        WHERE
                          user.id ='.Auth::id().'
                      )
                      AND (
                        SELECT
                          user.end_date
                        FROM
                          user
                        WHERE
                          user.id ='.Auth::id().')';
      $period = DB::table('absence_period')->where('id', $id)->first();

      // $fingerspot = DB::connection('mysql2')->select('SELECT
      //                                                   att_log.pin AS nik,
      //                                                   DATE_FORMAT(att_log.scan_date, "%Y-%m-%d") AS date_in,
      //                                                   MIN(TIME_FORMAT(att_log.scan_date, "%H:%I:%S")) AS actual_in,
      //                                                   MAX(TIME_FORMAT(att_log.scan_date, "%H:%I:%S")) AS actual_out
      //                                                 FROM
      //                                                   att_log
      //                                                 WHERE DATE_FORMAT(att_log.scan_date, "%Y-%m-%d") BETWEEN "'.$period->begin_date.'" AND  "'.$period->end_date.'"
      //                                                 GROUP BY
      //                                                   att_log.pin,
      //                                                   DATE_FORMAT(att_log.scan_date, "%Y-%m-%d")');

      // foreach ($fingerspot as $key => $fingerspots) {
      //     $time = Time::where('nik', $fingerspots->nik)->where('date_in', $fingerspots->date_in)->first();
      //     if(isset($time)){
      //       $time->actual_in = $fingerspots->actual_in;
      //       $time->actual_out = $fingerspots->actual_out;
      //       $time->save();
      //     }
      // };


     /* Update value to 0 */
      DB::update("UPDATE absence
                  SET absence.absence_type_id = NULL,
                   absence.work_hour = 0,
                   absence.meal_trans = 0,
                   absence.shift_id = NULL,
                   absence.overtime_in = NULL,
                   absence.overtime_out = NULL,
                   absence.day_in = NULL,
                   absence.day_out = NULL,
                   absence.holiday = NULL,
                   absence.holiday_overtime = NULL,
                   absence.overtime_hour = NULL
                  WHERE absence.period_id = (
                    SELECT
                      `user`.period_id
                    FROM
                      `user`
                    WHERE
                      `user`.id = ".Auth::id()."
                  )  AND (absence.check IS NULL OR absence.check = 0)");

      //Auto alpha
      DB::update("UPDATE absence
                  SET absence.absence_type_id = 5
                  WHERE
                    (absence.actual_in = '00:00:00' OR absence.actual_out = '00:00:00')
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

      //Get data from employee master
      DB::update("UPDATE absence
                  INNER JOIN (
                   SELECT
                    employee.id,
                    employee.nik,
                    work_calendar.`date`,
                    employee.shift_group_id
                  FROM
                    employee
                  INNER JOIN work_calendar ON employee.join_date <= work_calendar.`date`
                  JOIN `user`
                  WHERE
                    (
                      work_calendar.`date` BETWEEN `user`.begin_date
                      AND `user`.end_date
                    )
                  AND `user`.id = ".Auth::id()."
                  ) AS employee
                  SET absence.shift_group_id = employee.shift_group_id
                  WHERE
                    absence.employee_id = employee.id
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");


      //Get data from employee master
      DB::update("UPDATE absence
                  INNER JOIN (
                   SELECT
                      absence.id,
                      absence.employee_id,
                      employee.meal_trans_all
                    FROM
                      absence
                    LEFT JOIN shift ON absence.shift_id = shift.id
                    LEFT JOIN employee ON absence.employee_id = employee.id
                    WHERE FLOOR(TIME_TO_SEC(TIMEDIFF(absence.actual_in, shift.start_time)) / 60) > 15
                  ) AS employee
                  SET absence.meal_trans = employee.meal_trans_all  / 2
                  WHERE
                    absence.id = employee.id
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

       //Shift
      DB::update("UPDATE absence
                  INNER JOIN (
                  SELECT
                    absence.id,
                    absence.period_id,
                    absence.employee_id,
                    shift_group_detail.shift_id
                  FROM
                    absence
                    JOIN employee ON absence.employee_id = employee.id
                    JOIN shift_group_detail ON employee.shift_group_id = shift_group_detail.shift_group_id
                    JOIN absence_period ON absence.period_id = absence_period.id
                    JOIN period_shift ON absence_period.id = period_shift.period_id
                  WHERE
                    absence.period_id = ".$period->id."
                    AND period_shift.`day` <= shift_group_detail.`day`
                    ) AS tbl
                    SET absence.shift_id = tbl.shift_id
                  WHERE
                    absence.id = tbl.id AND (absence.check IS NULL OR absence.check = 0)");


      DB::update("UPDATE absence
                  INNER JOIN (
                  SELECT
                    shift_schedule.period_id,
                    shift_schedule.date_in,
                    shift_schedule.employee_id,
                    shift_schedule.shift_id
                  FROM
                    shift_schedule
                  WHERE
                    shift_schedule.period_id = ".$period->id."
                    ) AS tbl
                    SET absence.shift_id = tbl.shift_id
                  WHERE
                    absence.period_id = tbl.period_id AND absence.date_in = tbl.date_in AND absence.employee_id = tbl.employee_id AND (absence.check IS NULL OR absence.check = 0)");


      //holiday by nationality calendar
      DB::update("UPDATE absence
                  SET absence.holiday = 1
                  WHERE
                    absence.date_in IN (
                          SELECT
                            holiday.holiday_date
                          FROM
                            holiday
                    )
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

       DB::update("UPDATE work_calendar
                  SET work_calendar.holiday = 1
                  WHERE
                    work_calendar.date IN (
                          SELECT
                            holiday.holiday_date
                          FROM
                            holiday
                    )
                  AND work_calendar.date BETWEEN ".$date_period."");

      $shift_group = DB::connection('mysql')->select('SELECT * FROM shift_group');

      //holiday by shift group schedule (saturday)
     DB::update("UPDATE absence
                INNER JOIN (
                  SELECT
                    shift_group.id,
                    shift_group.off_friday,
                    shift_group.off_saturday,
                    shift_group.off_sunday
                  FROM
                    shift_group
                  WHERE
                    off_friday = 1
                ) shift_group
                SET absence.holiday = 1
                WHERE
                  absence.shift_group_id = shift_group.id
                AND (
                  DAYNAME(absence.date_in) = 'Friday'
                ) AND
                absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

       //training
       DB::update("UPDATE absence
                  INNER JOIN (
                    SELECT
                      training.id,
                      training.training_from,
                      training.training_to,
                      training.employee_id
                    FROM
                      training
                    WHERE
                      training. STATUS = 1
                  ) AS training
                  SET absence.absence_type_id =  6
                  WHERE
                    absence.employee_id = training.employee_id
                  AND absence.date_in BETWEEN training.training_from AND training.training_to
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");


      //Leave
      DB::update("UPDATE absence
                  INNER JOIN (
                    SELECT
                      `leave`.id,
                      `leave`.employee_id,
                      `leave`.leave_from,
                      `leave`.leave_to,
                      `leave`.absence_type_id
                    FROM
                      `leave`
                  ) AS `leave`
                  SET absence.absence_type_id =  `leave`.absence_type_id
                  WHERE
                    absence.employee_id = `leave`.employee_id AND absence.actual_in = '00:00:00' AND absence.actual_out = '00:00:00'
                  AND absence.date_in BETWEEN `leave`.leave_from AND `leave`.leave_to
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");


      //Overtime
      DB::update("UPDATE absence
                  INNER JOIN (
                    SELECT
                      *
                    FROM
                      overtime
                  ) AS overtime
                  SET absence.overtime_in =  overtime.time_from, absence.overtime_out =  overtime.time_to
                  WHERE
                    absence.employee_id = overtime.employee_id
                  AND absence.date_in = overtime.date_from
                  AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

      // //Overtime
      // DB::update("UPDATE absence
      //             INNER JOIN (
      //               SELECT
      //                 overtime.id,
      //                 overtime.date_from,
      //                 overtime.date_to,
      //                 overtime.time_from,
      //                 overtime.time_to,
      //                 overtime_det.employee_id,
      //                 TIMESTAMPDIFF(
      //                   HOUR,
      //                   overtime.time_from,
      //                   overtime.time_to
      //                 ) AS ot_hour

      //               FROM
      //                 overtime
      //               INNER JOIN overtime_det ON overtime.id = overtime_det.trans_id
      //             ) AS overtime
      //             SET absence.overtime_in =  overtime.time_from, absence.overtime_out =  overtime.time_to, absence.overtime_hour = overtime.ot_hour + (overtime.ot_hour/2), absence.overtime_hour_actual = overtime.ot_hour
      //             WHERE
      //               absence.employee_id = overtime.employee_id
      //             AND absence.date_in BETWEEN overtime.date_from AND overtime.date_to
      //             AND absence.date_in BETWEEN ".$date_period."  AND (absence.check IS NULL OR absence.check = 0)");

  }


  public function generateshiftschedule($id, Request $request)
  {

    $period = DB::table('period')->where('id', $id)->first();

    /* Get shift schedule from upload */
    for ($x = 10; $x <= 31; $x++) {
      DB::update("UPDATE absence
                  INNER JOIN  uploadshiftschedule ON absence.nik = uploadshiftschedule.nik
                  SET absence.shift_id = uploadshiftschedule.".$x."
                  WHERE
                    DATE_FORMAT(absence.date_in,'%d') = ".$x." AND absence.period_id = ".$period."
                  AND (absence.check IS NULL OR absence.check = 0)");
    };

    for ($x = 1; $x <= 10; $x++) {
      DB::update("UPDATE absence
                  INNER JOIN uploadshiftschedule ON absence.nik = uploadshiftschedule.nik
                  SET absence.shift_id = uploadshiftschedule.".$x."
                  WHERE
                    DATE_FORMAT(absence.date_in,'%d') = ".$x." AND absence.period_id = ".$period."
                  AND (absence.check IS NULL OR absence.check = 0)");
    };

  }


public function edit($id, $id2)
  {

    $absence_type_list = AbsenceType::all();
    $shift_list = Shift::all();

    $sql = 'SELECT
              absence_period.id,
              absence_period.begin_date,
              absence_period.end_date,
              absence_period.absence_group_name,
              absence_period.day_in,
              employee.nik,
              employee.id AS employee_id,
              employee.employee_name,
              employee.email,
              position.position_name,
              department.department_name
            FROM
              absence_period, employee
            LEFT JOIN position ON position.id = employee.position_id
            LEFT JOIN department ON employee.department_id = department.id
            WHERE absence_period.id = '.$id.' AND employee.id = '.$id2.'';
    $time = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql_detail = 'SELECT
                  absence.id,
                  DAYNAME(absence.date_in) AS date_in_day,
                  DATE_FORMAT(absence.date_in, "%d-%m-%Y") AS date_in,
                  DATE_FORMAT(absence.date_out, "%d-%m-%Y") AS date_out,
                  absence.date_in AS date_in_short,
                  absence.day_type_id,
                  absence.absence_type_id,
                  absence.holiday,
                  absence.holiday_overtime,
                  IFNULL(absence.day_in, "00:00:00") AS day_in,
                  IFNULL(absence.day_out, "00:00:00") AS day_out,
                  absence.actual_in,
                  absence.actual_out,
                  absence.permite_in,
                  absence.permite_out,
                  absence.work_hour,
                  absence.shift_id,
                  holiday.holiday_name AS holiday_name,
                  absence.check,
                  CONCAT(MOD(HOUR(TIMEDIFF(absence.actual_out, absence.actual_in)), 24), ".",
                  MINUTE(TIMEDIFF(absence.actual_out, absence.actual_in))) AS diff_actual,
                  FLOOR(TIME_TO_SEC(TIMEDIFF(absence.actual_in, shift.start_time)) / 60) AS diff_late_in,
                  FLOOR(TIME_TO_SEC(TIMEDIFF(shift.end_time, absence.actual_out)) / 60) AS diff_late_out,
                  absence.overtime_in,
                  absence.overtime_out,
                  CONCAT(MOD(HOUR(TIMEDIFF(absence.overtime_out, absence.overtime_in)), 24), ".",
                  MINUTE(TIMEDIFF(absence.overtime_out, absence.overtime_in))) AS diff_overtime_in,
                  absence.overtime_hour,
                  absence.overtime_hour_actual,
                  absence.remark,
                  shift.shift_name,
                  TIME_FORMAT(shift.start_time, "%H:%i") AS start_time,
                  TIME_FORMAT(shift.end_time, "%H:%i") AS end_time,
                  absence.photo_path_in,
                  absence.photo_path_out,
                  absence.location_latitude_in,
                  absence.location_longitude_in,
                  absence.location_latitude_out,
                  absence.location_longitude_out,
                  CASE WHEN absence_type.absence_type_name IS NULL AND absence.holiday = 0 THEN "Masuk" ELSE absence_type.absence_type_name END AS absence_type_name
                FROM
                  absence
                LEFT JOIN absence_type ON absence.absence_type_id = absence_type.id
                LEFT JOIN holiday ON absence.date_in = holiday.holiday_date
                LEFT JOIN shift ON absence.shift_id = shift.id
                WHERE absence.period_id = '.$id.' AND absence.employee_id = '.$id2.'
                ORDER BY absence.date_in DESC';
    $time_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->orderBy('date_in_short', 'ASC')->get();

    $absenceLocations= AbsenceLocation::all();

    // $absence_type_list = AbsenceType::all()->pluck('absence_typename', 'id');

    return view ('editor.time.form', compact('time', 'time_detail', 'absence_type_list', 'shift_list', 'absenceLocations'));
  }


  public function update($id, $id2, Request $request)
  {
    // dd($request->all());
    foreach($request->input('detail') as $key => $detail_data)
    {

      if( isset($detail_data['check'])){
        $check = 1;
      }else{
        $check = 0;
      };

      // Menyimpan file ke folder 'absence' di storage
    if ($request->hasFile('photo_path_in')) {
        $photo_in_path = $request->file('photo_path_in')->store('absence');
    } else {
        $photo_in_path = $detail_data['photo_path_in'];  // Jika file tidak ada, gunakan path lama
    }

    if ($request->hasFile('photo_path_out')) {
        $photo_out_path = $request->file('photo_path_out')->store('absence');
    } else {
        $photo_out_path = $detail_data['photo_path_out'];  // Jika file tidak ada, gunakan path lama
    }

      $time_detail = Time::where('id',$key)->first();
      $time_detail->day_in = $detail_data['day_in'];
      $time_detail->day_out = $detail_data['day_out'];
      $time_detail->actual_in = $detail_data['actual_in'];
      $time_detail->actual_out = $detail_data['actual_out'];
      $time_detail->photo_path_in = $photo_in_path;
      $time_detail->photo_path_out = $photo_out_path;
      $time_detail->overtime_in = $detail_data['overtime_in'];
      $time_detail->overtime_out = $detail_data['overtime_out'];
      $time_detail->shift_id = $detail_data['shift_id'];
      $time_detail->remark = $detail_data['remark'];
      $time_detail->check = $check;
      $time_detail->save();
    }

    // return redirect()->action('Editor\TimeController@index');
    return back();
  }



}
