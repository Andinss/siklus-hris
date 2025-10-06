<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PayrollReport;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Post;
use View;

class PayrollReportController extends Controller
{
  public function index()
  {
    return view('editor.payroll_report.index');
  }

  public function get_basic_salary_by_period(Request $request)
  {
    $year = $request->input('year');
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.basic) AS 'total' FROM payroll INNER JOIN period ON
    payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_bruto_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.total_bruto) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_thp_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.total_netto) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_overtime_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.overtime_all) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND payroll.deleted_at IS NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_meal_trans_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.meal_trans_all) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND payroll.deleted_at IS NULL  AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_jamsostek_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.jamsostek) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND payroll.deleted_at IS NULL  AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_bpjs_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.bpjs) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND payroll.deleted_at IS NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }

  public function get_pph21_by_period(Request $request)
  {
    $year = $request->year;
    $sql = "SELECT MAX(period.description) AS 'description', SUM(payroll.pph_21) AS 'total' FROM payroll INNER JOIN period ON payroll.period_id = period.id INNER JOIN employee ON payroll.employee_id = employee.id
    WHERE employee.status = 0 AND employee.deleted_at IS NULL AND payroll.deleted_at IS NULL AND payroll.deleted_at is NULL AND period.deleted_at IS NULL AND DATE_FORMAT(period.begin_date, '%Y') = '".$year."' GROUP BY payroll.period_id";

    $data = DB::table(DB::raw("($sql) AS rs_sql"))->get();

    return response()->json($data, 200);
  }
}
