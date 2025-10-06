<?php

use App\Http\Controllers\Api\AbsenceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Editor\ActionController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Editor\EmployeeController;
use App\Http\Controllers\Editor\ModuleController;
use App\Http\Controllers\Editor\PayrollController;
use App\Http\Controllers\Editor\PayrollReportController;
use App\Http\Controllers\Editor\PopupController;
use App\Http\Controllers\Editor\PrivilegeController;
use App\Http\Controllers\Editor\UserFilterController;
use App\Http\Controllers\Editor\UserLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Editor\HolidayController;
use App\Http\Controllers\Editor\ShiftController;
use App\Http\Controllers\Editor\UserController;
use App\Models\PayrollReport;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/payroll/create_calc_bpjs',[PayrollController::class, 'create_calc_bpjs']);
Route::get('/payroll/search_overtime', [PayrollController::class, 'search_overtime']);
Route::post('/payroll/create_calc_overtime', [PayrollController::class, 'create_calc_overtime']);
Route::get('/user', [UserFilterController::class, 'dataUser'])->name('api.user.data');
Route::get('/privilege', [PrivilegeController::class, 'data'])->name('api.privilege.data');
Route::get('/module', [ModuleController::class, 'data'])->name('editor.module.data');
Route::get('/action', [ActionController::class, 'data'])->name('editor.action.data');
//Popup
Route::get('/popup', [PopupController::class, 'data'])->name('editor.popup.data');
Route::get('/check/popup', [PopupController::class, 'checkPopUp'])->name('editor.popup.checkpopup');

//userlog
Route::get('/userlog', [UserLogController::class , 'dataApi'])->name('editor.userlog.dataApi');

Route::get('/payroll/search-schema', [PayrollController::class, 'search_schema']);
Route::get('/payroll/bpjs-details', [PayrollController::class, 'bpjs_details']);
Route::post('/payroll/slip-print-employee', [PayrollController::class, 'send_receipt']);

Route::get('/total-salary', [EditorController::class, 'get_total_salary_by_period'])->name('api.total-salary');

Route::get('/total-genders', [EditorController::class, 'get_number_of_genders'])->name('api.total-genders');
Route::get('/employee-level', [EditorController::class, 'get_employee_level'])->name('api.employee-level');
Route::post('/total-attendances', [EditorController::class, 'get_total_attendances'])->name('api.total-attendances');

// search employee birth data
Route::post('/search-employee-birth-data', [EditorController::class, 'search_employee_birth_data'])->name('api.search-employee-birth-data');
// search employee leave data
Route::post('/search-employee-leave-data', [EditorController::class, 'search_employee_leave_data'])->name('api.search-employee-leave-data');

/* api tinjauan gaji */
Route::post('/payroll-report/data-basic', [PayrollReportController::class, 'get_basic_salary_by_period'])->name('api.payroll-report.data-basic');
Route::post('/payroll-report/data-bruto', [PayrollReportController::class, 'get_bruto_by_period'])->name('api.payroll-report.data-bruto');
Route::post('/payroll-report/data-thp', [PayrollReportController::class, 'get_thp_by_period'])->name('api.payroll-report.data-thp');
Route::post('/payroll-report/data-overtime', [PayrollReportController::class, 'get_overtime_by_period'])->name('api.payroll-report.data-overtime');
Route::post('/payroll-report/data-meal-trans', [PayrollReportController::class, 'get_meal_trans_by_period'])->name('api.payroll-report.data-meal-trans');
Route::post('/payroll-report/data-jamsostek', [PayrollReportController::class, 'get_jamsostek_by_period'])->name('api.payroll-report.data-jamsostek');
Route::post('/payroll-report/data-bpjs', [PayrollReportController::class, 'get_bpjs_by_period'])->name('api.payroll-report.data-bpjs');
Route::post('/payroll-report/data-pph21', [PayrollReportController::class, 'get_pph21_by_period'])->name('api.payroll-report.data-pph21');

Route::get('/absence/list', [AbsenceController::class, 'data'])->name('api-absence-list');
Route::post('/absence/clock-in', [AbsenceController::class, 'clockIn'])->name('api-absence-clock-in');
Route::post('/absence/clock-out', [AbsenceController::class, 'clockOut'])->name('api-absence-clock-out');
Route::get('/absence/detail-profile/{id}', [AbsenceController::class, 'detailProfile'])->name('api-absence-detail-profile');
Route::post('/absence/riwayat/{id}', [AbsenceController::class, 'riwayatAbsensi'])->name('api-riwayat-absensi');

Route::get('employee/department/', [EmployeeController::class, 'getEmployeebyDepartment']);
Route::get('employee/search/', [EmployeeController::class, 'searchByName']);
Route::get('/employees', [EmployeeController::class, 'getEmployees']);

Route::get('/employee/check-shift-employee/{id}', [ShiftController::class, 'shiftKaryawan'])->middleware('auth:api');
Route::get('/user/profile/{id}', [UserController::class, 'getUser'])->middleware('auth:api');

Route::post('/payroll/slip-gaji', [PayrollController::class, 'listSlipGaji'])->name('api-payroll-slip-gaji');
Route::get('/payroll/detail-slip-gaji/{id}', [PayrollController::class, 'detailSlipGaji'])->name('api-payroll-detail-slip-gaji');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('change-password', 'changePassword');
    Route::post('user-change-password', 'userChangePassword');
});

Route::get('/shift/list', [ShiftController::class, 'list'])->name('api-shift-list');

Route::controller(HolidayController::class)->prefix('holiday')->name('holiday.')->group(function () {
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/update/{id}', 'update')->name('edit');
    Route::delete('/delete/{id}', 'delete')->name('delete');
})->middleware('auth:api');
