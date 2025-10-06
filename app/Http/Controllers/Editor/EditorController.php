<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Popup;
use App\Models\TotalSalary;

class EditorController extends Controller
{
	public function index()
	{

		$sql_count = 'SELECT
							COUNT(employee.id) AS employee_count 
						FROM
							employee 
						WHERE
							employee.deleted_at IS NULL';
		$employee_count = DB::table(DB::raw("($sql_count) as rs_sql"))->first();

		$sql_birthday = 'SELECT
							employee.employee_name ,
							position.position_name ,
							DATE_FORMAT(employee.date_birth , "%d-%m-%Y") AS date_birth
						FROM
							employee
						INNER JOIN position ON position.id = employee.position_id
						WHERE
							employee.deleted_at IS NULL
						AND employee.deleted_at IS NULL
						ORDER BY
							DATEDIFF(NOW() , employee.date_birth) ASC
						LIMIT 4';
		$employee_birthday = DB::table(DB::raw("($sql_birthday) as rs_sql"))->get();


		$sql_new_employee = 'SELECT
							employee.employee_name ,
							position.position_name ,
							DATE_FORMAT(employee.date_birth , "%d-%m-%Y") AS date_birth
						FROM
							employee
						INNER JOIN position ON position.id = employee.position_id
						WHERE
							employee.deleted_at IS NULL
						AND employee.deleted_at IS NULL
						ORDER BY
							DATEDIFF(NOW() , employee.date_birth) ASC
						LIMIT 4';
		$employee_new_employee = DB::table(DB::raw("($sql_new_employee) as rs_sql"))->get();


		$sql_leave = 'SELECT
							employee.employee_name ,
							position.position_name ,
							DATE_FORMAT(employee.date_birth , "%d-%m-%Y") AS date_birth
						FROM
							employee
						INNER JOIN position ON position.id = employee.position_id
						WHERE
							employee.deleted_at IS NULL
						AND employee.deleted_at IS NULL
						ORDER BY
							DATEDIFF(NOW() , employee.date_birth) ASC
						LIMIT 4';
		$employee_leave = DB::table(DB::raw("($sql_leave) as rs_sql"))->get();
		$query = '
			concat("Period :", DATE_FORMAT(period.begin_date , "%d-%m-%Y"), " sampai ", DATE_FORMAT(period.end_date , "%d-%m-%Y") )
		';
		$period_list = DB::table('period')
			->select('id', DB::raw("$query AS description"))
			->where('deleted_at', null)
			->get();
		return view('editor.index', compact('employee_birthday', 'employee_new_employee', 'employee_leave', 'employee_count', 'period_list'));
	}

	public function get_total_salary_by_period(Request $request)
	{
		$period_id = $request->get('period_id');
		$data_salary = TotalSalary::where('period_id', $period_id)->first();
		$result = [
			'data' => $data_salary
		];

		return response()->json($result, 200);
	}

	public function notif()
	{
		$notif = [];
		return view('editor.notif.index', compact('notif'));
	}

	public function get_total_attendances(Request $request)
	{
		$date_in = date('Y-m-d', strtotime($request->input('date_in')));
		$sql = "SELECT COUNT(absence.employee_id) AS total_attendances FROM absence INNER JOIN employee ON absence.employee_id = employee.id WHERE absence.date_in = '".$date_in."' AND absence.actual_in <> '00:00:00' AND absence.deleted_at IS NULL AND employee.`status` = 0 AND employee.deleted_at IS NULL";

		$result = DB::table(DB::raw("($sql) as rs_sql"))->get();

		return response()->json($result, 200);
	}

	public function get_number_of_genders()
	{
		
		$sql = "SELECT sex AS sex_id, (SELECT sex.sex_name FROM sex WHERE sex.id = employee.sex) AS 'sex_name', COUNT(employee.sex) AS sum_sex FROM employee WHERE employee.status = 0 AND employee.deleted_at IS NULL GROUP BY employee.sex";
		$result = DB::table(DB::raw("($sql) as rs_sql"))->get();

		return response()->json($result, 200);
	}

	public function get_employee_level()
	{
		$sql = "SELECT employee.staff_status_id, (SELECT staff_status.staff_status_name FROM staff_status WHERE staff_status.id = employee.staff_status_id) AS 'staff_status_name', COUNT(employee.staff_status_id) AS 'sum_staff_status' FROM employee WHERE employee.status = 0 AND employee.deleted_at IS NULL GROUP BY employee.staff_status_id";

		$rows = DB::table(DB::raw("($sql) as rs_sql"))->get();
		return response()->json($rows, 200);
	}

	public function search_employee_birth_data(Request $request)
	{
		$date_from = date('m-d', strtotime($request->input('birth_date_from')));
		$date_to = date('m-d', strtotime($request->input('birth_date_to')));
		
		if(empty($date_from) || empty($date_to)){
			$sql = "SELECT employee.employee_name, employee.image, DATE_FORMAT(employee.date_birth, '%m-%d-%Y') AS date_birth, TIMESTAMPDIFF(YEAR, employee.date_birth, CURDATE()) AS 'age', staff_status.staff_status_name FROM employee INNER JOIN staff_status ON employee.staff_status_id = staff_status.id WHERE staff_status.deleted_at IS NULL AND employee.date_birth = NULL";
		} else{
			$sql = "SELECT employee.employee_name, employee.image, DATE_FORMAT(employee.date_birth, '%m-%d-%Y') AS date_birth, TIMESTAMPDIFF(YEAR, employee.date_birth, CURDATE()) AS 'age', staff_status.staff_status_name FROM employee INNER JOIN staff_status ON employee.staff_status_id = staff_status.id WHERE staff_status.deleted_at IS NULL AND employee.status = 0 AND employee.deleted_at IS NULL AND (DATE_FORMAT(employee.date_birth, '%m-%d') BETWEEN '".$date_from."' AND '".$date_to."')";
		}
		
		$rows = DB::table(DB::raw("($sql) as rs_sql"))->get();

		return response()->json($rows, 200);
	}

	public function search_employee_leave_data(Request $request)
	{
		$date_trans = date('m', strtotime($request->input('date_trans')));

		if(empty($date_trans)){
			$sql = "SELECT employee.employee_name, employee.image, DATE_FORMAT(employee.date_birth, '%d-%m-%Y') AS date_birth, staff_status.staff_status_name, DATE_FORMAT(leave.leave_from, '%d-%m-%Y') AS leave_from, DATE_FORMAT(leave.leave_to, '%d-%m-%Y') AS leave_to
			FROM `leave` INNER JOIN employee ON leave.employee_id = employee.id
			INNER JOIN staff_status ON employee.staff_status_id = staff_status.id WHERE leave.date_from = NULL AND leave.date_from = NULL AND leave.deleted_at IS NULL AND staff_status.deleted_at IS NULL";
		} else {
			$sql = "SELECT employee.employee_name, employee.image, DATE_FORMAT(employee.date_birth, '%d-%m-%Y') AS date_birth, staff_status.staff_status_name, DATE_FORMAT(leave.leave_from, '%d-%m-%Y') AS leave_from, DATE_FORMAT(leave.leave_to, '%d-%m-%Y') AS leave_to
			FROM `leave` INNER JOIN employee ON leave.employee_id = employee.id
			INNER JOIN staff_status ON employee.staff_status_id = staff_status.id WHERE (DATE_FORMAT(leave.date_trans, '%m') = ".$date_trans.") AND leave.deleted_at IS NULL AND staff_status.deleted_at IS NULL";
		}

		$rows = DB::table(DB::raw("($sql) as rs_sql"))->get();
		return response()->json($rows, 200);
	}
}
