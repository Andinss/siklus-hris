<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Editor\AbsenceTypeController;
use App\Http\Controllers\Editor\AbsencePeriodController;
use App\Http\Controllers\Editor\AbsenceLocationController;
use App\Http\Controllers\Editor\AbsenceAccountController;
use App\Http\Controllers\Editor\ActionController;
use App\Http\Controllers\Editor\CashPaymentController;
use App\Http\Controllers\Editor\CashReceiveController;
use App\Http\Controllers\Editor\DepartmentController;
use App\Http\Controllers\Editor\DocumentController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Editor\EducationLevelController;
use App\Http\Controllers\Editor\EducationMajorController;
use App\Http\Controllers\Editor\EmployeeController;
use App\Http\Controllers\Editor\EmployeeStatusController;
use App\Http\Controllers\Editor\EventController;
use App\Http\Controllers\Editor\FaqController;
use App\Http\Controllers\Editor\HolidayController;
use App\Http\Controllers\Editor\LeaveController;
use App\Http\Controllers\Editor\LoanTypeController;
use App\Http\Controllers\Editor\LocationController;
use App\Http\Controllers\Editor\ManualBookController;
use App\Http\Controllers\Editor\ModuleController;
use App\Http\Controllers\Editor\OvertimeController;
use App\Http\Controllers\Editor\OvertimeTypeController;
use App\Http\Controllers\Editor\PayrollController;
use App\Http\Controllers\Editor\PayrollComponentController;
use App\Http\Controllers\Editor\PayrollSlipController;
use App\Http\Controllers\Editor\PayrollTypeController;
use App\Http\Controllers\Editor\PayrollReportController;
use App\Http\Controllers\Editor\BPJSTKController;
use App\Http\Controllers\Editor\BPJSKesehatanController;
use App\Http\Controllers\Editor\PeriodController;
use App\Http\Controllers\Editor\PopupController;
use App\Http\Controllers\Editor\PositionController;
use App\Http\Controllers\Editor\PreferenceController;
use App\Http\Controllers\Editor\PrivilegeController;
use App\Http\Controllers\Editor\ProfileController;
use App\Http\Controllers\Editor\PtkpController;
use App\Http\Controllers\Editor\PunishmentController;
use App\Http\Controllers\Editor\ReimburseApprovalController;
use App\Http\Controllers\Editor\ReimburseController;
use App\Http\Controllers\Editor\ReimburseTypeController;
use App\Http\Controllers\Editor\ReportLedgerController;
use App\Http\Controllers\Editor\RewardController;
use App\Http\Controllers\Editor\ShiftController;
use App\Http\Controllers\Editor\ShiftGroupController;
use App\Http\Controllers\Editor\ShiftPlanController;
use App\Http\Controllers\Editor\ShiftScheduleController;
// use App\Http\Controllers\Editor\TarifController;
use App\Http\Controllers\Editor\TelegramController;
use App\Http\Controllers\Editor\TimeController;
use App\Http\Controllers\Editor\TrainingController;
use App\Http\Controllers\Editor\TrainingProviderController;
use App\Http\Controllers\Editor\UserController;
use App\Http\Controllers\Editor\UserLogController;
use App\Http\Controllers\EmployeeInviteController;
use App\Models\EducationMajor;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
Route::group(['middleware' => 'auth', 'namespace' => 'Editor'], function () {
    Route::get('/', [EditorController::class, 'index'])->name('editor.index');
});

//Absence
Route::get('/attendance/clock-in', [EmployeeInviteController::class, 'getGeolocation']);

//Invite Employee
Route::get('/invite', [EmployeeInviteController::class, 'showRegistrationFormEmployee']);
Route::post('/invite', [EmployeeInviteController::class, 'registerEmployee'])->name('registerEmployee');

//User Management
Route::group(['prefix' => 'editor', 'middleware' => 'auth'], function () {
    //Home
    Route::get('/', [EditorController::class, 'index'])->name('editor.index');
    //Notif
    Route::get('/notif', [EditorController::class, 'notif'])->name('editor.notif.index');
    //Profile
    //detail
    Route::get('/profile', [ProfileController::class, 'show'])->name('editor.profile.show');
    //edit
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('editor.profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('editor.profile.update');
    //edit password
    Route::get('/profile/password', [ProfileController::class, 'edit_password'])->name('editor.profile.edit_password');
    Route::put('/profile/password', [ProfileController::class, 'update_password'])->name('editor.profile.update_password');

    // telegram
    Route::get('/send-telegram-message/{notifiable}', [TelegramController::class, 'index'])->name('editor.send-telegram-message.index');

    Route::PUT('/send-telegram-message/{notifiable}', [TelegramController::class, 'TelegramController@send_message'])->name('editor.send-telegram-message.update');

    //Period
    //index
    Route::get('/period', [PeriodController::class, 'index'])->name('editor.period.index');
    Route::get('/period/data', [PeriodController::class, 'data'])->name('editor.period.data');
    //create
    Route::get('/period/create', [PeriodController::class, 'create'])->name('editor.period.create');
    Route::post('/period/create', [PeriodController::class, 'store'])->name('editor.period.store');
    //edit
    Route::get('/period/edit/{id}', [PeriodController::class, 'edit'])->name('editor.period.edit');
    Route::put('/period/edit/{id}', [PeriodController::class, 'update'])->name('editor.period.update');
    //delete
    Route::delete('/period/delete/{id}', [PeriodController::class, 'delete'])->name('editor.period.delete');
    Route::post('/period/deletebulk', [PeriodController::class, 'deletebulk'])->name('editor.period.deletebulk');

    //detail
    Route::get('/period/{id}/detail', [PeriodController::class, 'detail'])->name('editor.period.detail');
    // detailitem
    Route::get('/period/data-detail/{id}', [PeriodController::class, 'data_detail'])->name('editor.period.data-detail');
    Route::put('/period/save-detail/{id}', [PeriodController::class, 'save_detail'])->name('editor.period.save-detail');
    Route::delete('/period/delete-detail/{id}', [PeriodController::class, 'delete_detail'])->name('editor.period.delete-detail');

    //Filter
    Route::post('/datefilter', [UserController::class, 'datefilter'])->name('editor.datefilter');
    Route::post('/employeefilter', [UserController::class, 'employeefilter'])->name('editor.employeefilter');
    Route::post('/periodfilter', [UserController::class, 'periodfilter'])->name('editor.periodfilter');
    Route::post('/periodfilterthr', [UserController::class, 'periodfilterthr'])->name('editor.periodfilterthr');
    Route::post('/periodfilteronly', [UserController::class, 'periodfilteronly'])->name('editor.periodfilteronly');
    Route::post('/periodfilteremp', [UserController::class, 'periodfilteremp'])->name('editor.periodfilteremp');

    //User
    //index
    Route::get('/user', [UserController::class, 'index'])->name('editor.user.index')->middleware(['role:user|read']);
    //create
    Route::get('/user/create', [UserController::class, 'create'])->name('editor.user.create')->middleware(['role:user|create']);
    Route::post('/user/create', [UserController::class, 'store'])->name('editor.user.store')->middleware(['role:user|create']);
    //edit
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('editor.user.edit')->middleware(['role:user|update']);
    Route::put('/user/{id}/edit', [UserController::class, 'update'])->name('editor.user.update')->middleware(['role:user|update']);
    //delete
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('editor.user.delete')->middleware(['role:user|delete']);

    //User
    //index
    Route::get('/userbranch', ['as' => 'editor.userbranch.index', 'uses' => 'UserbranchController@index'])->middleware(['role:userbranch|read']);
    //create
    Route::get('/userbranch/create', ['as' => 'editor.userbranch.create', 'uses' => 'UserbranchController@create'])->middleware(['role:userbranch|create']);
    Route::post('/userbranch/create', ['as' => 'editor.userbranch.store', 'uses' => 'UserbranchController@store'])->middleware(['role:userbranch|create']);
    //edit
    Route::get('/userbranch/{id}/edit', ['as' => 'editor.userbranch.edit', 'uses' => 'UserbranchController@edit'])->middleware(['role:userbranch|update']);
    Route::put('/userbranch/{id}/edit', ['as' => 'editor.userbranch.update', 'uses' => 'UserbranchController@update'])->middleware(['role:userbranch|update']);
    //delete
    Route::delete('/userbranch/{id}/delete', ['as' => 'editor.userbranch.delete', 'uses' => 'UserbranchController@delete'])->middleware(['role:userbranch|delete']);


    //Module
    //index
    Route::get('/module', [ModuleController::class, 'index'])->name('editor.module.index')->middleware(['role:module|read']);
    //create
    Route::get('/module/create', [ModuleController::class, 'create'])->name('editor.module.create')->middleware(['role:module|create']);
    Route::post('/module/create', [ModuleController::class, 'store'])->name('editor.module.store')->middleware(['role:module|create']);
    //edit
    Route::get('/module/{id}/edit', [ModuleController::class, 'edit'])->name('editor.module.edit')->middleware(['role:module|update']);
    Route::put('/module/{id}/edit', [ModuleController::class, 'update'])->name('editor.module.update')->middleware(['role:module|update']);
    //delete
    Route::delete('/module/{id}/delete', [ModuleController::class, 'delete'])->name('editor.module.delete')->middleware(['role:module|delete']);
    //delete
    Route::delete('/module/delete/{id}', [ModuleController::class, 'delete'])->name('editor.module.delete')->middleware(['role:module|delete']);

    //Action
    //index
    Route::get('/action', [ActionController::class, 'index'])->name('editor.action.index');
    //create
    Route::get('/action/create', [ActionController::class, 'create'])->name('editor.action.create');
    Route::post('/action/create', [ActionController::class, 'store'])->name('editor.action.store');
    //edit
    Route::get('/action/{id}/edit', [ActionController::class, 'edit'])->name('editor.action.edit');
    Route::put('/action/{id}/edit', [ActionController::class, 'update'])->name('editor.action.update');
    //delete
    Route::delete('/action/delete/{id}', [ActionController::class, 'delete'])->name('editor.action.delete');

    //Privilege
    //index
    Route::get('/privilege', [PrivilegeController::class, 'index'])->name('editor.privilege.index');
    //create
    Route::get('/privilege/create', [PrivilegeController::class, 'create'])->name('editor.privilege.create');
    Route::post('/privilege/create', [PrivilegeController::class, 'store'])->name('editor.privilege.store');
    //edit
    Route::get('/privilege/{id}/edit', [PrivilegeController::class, 'edit'])->name('editor.privilege.edit');
    Route::put('/privilege/{id}/edit', [PrivilegeController::class, 'update'])->name('editor.privilege.update');
    //delete
    Route::delete('/privilege/{id}/delete', [PrivilegeController::class, 'delete'])->name('editor.privilege.delete');

    //Employee Status
    //index
    Route::get('/employee-status', [EmployeeStatusController::class, 'index'])->name('editor.employee-status.index');
    Route::get('/employee-status/data', [EmployeeStatusController::class, 'data'])->name('editor.employee-status.data');
    //create
    Route::get('/employee-status/create', [EmployeeStatusController::class, 'create'])->name('editor.employee-status.create');
    Route::post('/employee-status/create', [EmployeeStatusController::class, 'store'])->name('editor.employee-status.store');
    //edit
    Route::get('/employee-status/edit/{id}', [EmployeeStatusController::class, 'edit'])->name('editor.employee-status.edit');
    Route::put('/employee-status/edit/{id}', [EmployeeStatusController::class, 'update'])->name('editor.employee-status.update');
    //delete
    Route::delete('/employee-status/delete/{id}', [EmployeeStatusController::class, 'delete'])->name('editor.employee-status.delete');
    Route::post('/employee-status/deletebulk', [EmployeeStatusController::class, 'deletebulk'])->name('editor.employee-status.deletebulk');

    //Division
    //index
    Route::get('/department', [DepartmentController::class, 'index'])->name('editor.department.index');
    Route::get('/department/data', [DepartmentController::class, 'data'])->name('editor.department.data');
    //create
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('editor.department.create');
    Route::post('/department/create', [DepartmentController::class, 'store'])->name('editor.department.store');
    //edit
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('editor.department.edit');
    Route::put('/department/edit/{id}', [DepartmentController::class, 'update'])->name('editor.department.update');
    //delete
    Route::delete('/department/delete/{id}', [DepartmentController::class, 'delete'])->name('editor.department.delete');
    Route::post('/department/deletebulk', [DepartmentController::class, 'deletebulk'])->name('editor.department.deletebulk');


    //Ptkp
    //index
    Route::get('/ptkp', [PtkpController::class, 'index'])->name('editor.ptkp.index');
    Route::get('/ptkp/data', [PtkpController::class, 'data'])->name('editor.ptkp.data');
    //create
    Route::get('/ptkp/create', [PtkpController::class, 'create'])->name('editor.ptkp.create');
    Route::post('/ptkp/create', [PtkpController::class, 'store'])->name('editor.ptkp.store');
    //edit
    Route::get('/ptkp/edit/{id}', [PtkpController::class, 'edit'])->name('editor.ptkp.edit');
    Route::put('/ptkp/edit/{id}', [PtkpController::class, 'update'])->name('editor.ptkp.update',);
    //delete
    Route::delete('/ptkp/delete/{id}', [PtkpController::class, 'delete'])->name('editor.ptkp.delete');
    Route::post('/ptkp/deletebulk', [PtkpController::class, 'deletebulk'])->name('editor.ptkp.deletebulk');

    //Position
    //index
    Route::get('/position', [PositionController::class, 'index'])->name('editor.position.index');
    Route::get('/position/data', [PositionController::class, 'data'])->name('editor.position.data');
    //create
    Route::get('/position/create', [PositionController::class, 'create']);
    Route::post('/position/create', [PositionController::class, 'store'])->name('editor.position.store',);
    //edit
    Route::get('/position/edit/{id}', [PositionController::class, 'edit'])->name('editor.position.edit');
    Route::put('/position/edit/{id}', [PositionController::class, 'update'])->name('editor.position.update');
    //delete
    Route::delete('/position/delete/{id}', [PositionController::class, 'delete'])->name('editor.position.delete');
    Route::post('/position/deletebulk', [PositionController::class, 'deletebulk'])->name('editor.position.deletebulk');

    //Location
    //index
    Route::get('/location', [LocationController::class, 'index'])->name('editor.location.index');
    Route::get('/location/data', [LocationController::class, 'data'])->name('editor.location.data');
    //create
    Route::get('/location/create', [LocationController::class, 'create'])->name('editor.location.create');
    Route::post('/location/create', [LocationController::class, 'store'])->name('editor.location.store');
    //edit
    Route::get('/location/edit/{id}', [LocationController::class, 'edit'])->name('editor.location.edit');
    Route::put('/location/edit/{id}', [LocationController::class, 'update'])->name('editor.location.update');
    //delete
    Route::delete('/location/delete/{id}', [LocationController::class, 'delete'])->name('editor.location.delete');
    Route::post('/location/deletebulk', [LocationController::class, 'deletebulk'])->name('editor.location.deletebulk');

    //Education Level
    //index
    Route::get('/education-level', [EducationLevelController::class, 'index'])->name('editor.education-level.index');
    Route::get('/education-level/data', [EducationLevelController::class, 'data'])->name('editor.education-level.data');
    //create
    Route::get('/education-level/create', [EducationLevelController::class, 'create'])->name('editor.education-level.create');
    Route::post('/education-level/create', [EducationLevelController::class, 'store'])->name('editor.education-level.store');
    //edit
    Route::get('/education-level/edit/{id}', [EducationLevelController::class, 'edit'])->name('editor.education-level.edit');
    Route::put('/education-level/edit/{id}', [EducationLevelController::class, 'update'])->name('editor.education-level.update');
    //delete
    Route::delete('/education-level/delete/{id}', [EducationLevelController::class, 'delete'])->name('editor.education-level.delete');
    Route::post('/education-level/deletebulk', [EducationLevelController::class, 'deletebulk'])->name('editor.education-level.deletebulk');

    //Shift Group
    //index
    Route::get('/shift-group', [ShiftGroupController::class, 'index'])->name('editor.shift-group.index')->middleware(['role:pengaturan_absensi|read']);
    Route::get('/shift-group/data', [ShiftGroupController::class, 'data'])->name('editor.shift-group.data');
    //create
    Route::get('/shift-group/create', [ShiftGroupController::class, 'create'])->name('editor.shift-group.create')->middleware(['role:pengaturan_absensi|create']);
    Route::post('/shift-group/create', [ShiftGroupController::class, 'store'])->name('editor.shift-group.store')->middleware(['role:pengaturan_absensi|create']);
    //edit
    Route::get('/shift-group/edit/{id}', [ShiftGroupController::class, 'edit'])->name('editor.shift-group.edit')->middleware(['role:pengaturan_absensi|update']);
    Route::put('/shift-group/edit/{id}', [ShiftGroupController::class, 'uses' => 'ShiftGroupController@update'])->middleware(['role:pengaturan_absensi|update']);
    //delete
    Route::delete('/shift-group/delete/{id}', [ShiftGroupController::class, 'delete'])->name('editor.shift-group.delete')->middleware(['role:pegaturan_absensi|delete']);
    Route::post('/shift-group/deletebulk', [ShiftGroupController::class, 'deletebulk'])->name('editor.shift-group.deletebulk')->middleware(['role:pengaturan_absensi|delete']);

    //detail
    Route::get('/shift-group/{id}/detail', [ShiftGroupController::class, 'detail'])->name('editor.shift-group.detail')->middleware(['role:pengaturan_absensi|update']);
    // detailitem
    Route::get('/shift-group/data-detail/{id}', [ShiftGroupController::class, 'data_detail'])->name('editor.shift-group.data-detail');
    Route::put('/shift-group/save-detail/{id}', [ShiftGroupController::class, 'save_detail'])->name('editor.shift-group.update')->middleware(['role:pengaturan_absensi|update']);
    Route::delete('/shift-group/delete-detail/{id}', [ShiftGroupController::class, 'delete_detail']);

    //Shift
    //index
    Route::get('/shift', [ShiftController::class, 'index'])->name('editor.shift.index')->middleware(['role:pengaturan_absensi|read']);
    Route::get('/shift/data', [ShiftController::class, 'data'])->name('editor.shift.data');
    //create
    Route::get('/shift/create', [ShiftController::class, 'create'])->name('editor.shift.create')->middleware(['role:pengaturan_absensi|create']);
    Route::post('/shift/create', [ShiftController::class, 'store'])->name('editor.shift.store')->middleware(['role:pengaturan_absensi|create']);
    //edit
    Route::get('/shift/edit/{id}', [ShiftController::class, 'edit'])->name('editor.shift.edit')->middleware(['role:pengaturan_absensi|update']);
    Route::put('/shift/edit/{id}', [ShiftController::class, 'update'])->name('editor.shift.update')->middleware(['role:pengaturan_absensi|update']);
    //delete
    Route::delete('/shift/delete/{id}', [ShiftController::class, 'delete'])->name('editor.shift.delete')->middleware(['role:pengaturan_absensi|delete']);
    Route::post('/shift/deletebulk', [ShiftController::class, 'deletebulk'])->name('editor.shift.deletebulk');

    //Education Major
    //index
    Route::get('/education-major', [EducationMajorController::class, 'index'])->name('editor.education-major.index');
    Route::get('/education-major/data', [EducationMajorController::class, 'data'])->name('editor.education-major.data');
    //create
    Route::get('/education-major/create', [EducationMajorController::class, 'create'])->name('editor.education-major.create');
    Route::post('/education-major/create', [EducationMajorController::class, 'store'])->name('editor.education-major.store');
    //edit
    Route::get('/education-major/edit/{id}', [EducationMajorController::class, 'edit'])->name('editor.education-major.edit');
    Route::put('/education-major/edit/{id}', [EducationMajorController::class, 'update'])->name('editor.education-major.update');
    //delete
    Route::delete('/education-major/delete/{id}', [EducationMajorController::class, 'delete'])->name('editor.education-major.delete');
    Route::post('/education-major/deletebulk', [EducationMajorController::class, 'deletebulk'])->name('editor.education-major.deletebulk');

    //Employee
    //index
    Route::get('/employee', [EmployeeController::class, 'index'])->name('editor.employee.index');
    Route::get('/employee/data', [EmployeeController::class, 'data'])->name('editor.employee.data');
    //create
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('editor.employee.create')->middleware(['role:karyawan|create']);
    Route::post('/employee/create', [EmployeeController::class, 'store'])->name('editor.employee.store');
    //edit
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('editor.employee.edit')->middleware(['role:karyawan|update']);
    Route::put('/employee/{id}/edit', [EmployeeController::class, 'update'])->name('editor.employee.update');
    Route::put('/employee/edit/{id}', [EmployeeController::class, 'update'])->name('editor.employee.update');
    //view
    Route::get('/employee/{id}/view', [EmployeeController::class, 'view'])->name('editor.employee.view');
    //delete
    Route::delete('/employee/delete/{id}', [EmployeeController::class, 'delete'])->name('editor.employee.delete')->middleware(['role:karyawan|delete']);
    Route::post('/employee/deletebulk', [EmployeeController::class, 'deletebulk'])->name('editor.employee.deletebulk');
    //lookup
    Route::get('/employee/datalookup/{id}', ['as' => 'editor.employee.datalookup', 'uses' => 'EmployeeController@datalookup']);
    //resign
    Route::get('/employee/resign/{id}', ['as' => 'editor.employee.resign', 'uses' => 'EmployeeController@resign']);
    Route::post('/employee/resign/{id}', ['as' => 'editor.employee.storeresign', 'uses' => 'EmployeeController@storeresign']);
    Route::get('/employee/dataresign', ['as' => 'editor.employee.dataresign', 'uses' => 'EmployeeController@dataresign']);
    //import
    Route::post('/employee/storeimport', ['as' => 'editor.employee.storeimport', 'uses' => 'EmployeeController@storeimport']);
    //export
    Route::get('/employee/storeexport/{type}', ['as' => 'editor.employee.storeexport', 'uses' => 'EmployeeController@storeexport']);
    //import
    Route::post('/employee/updateimport', ['as' => 'editor.employee.updateimport', 'uses' => 'EmployeeController@updateimport']);
    //export
    Route::get('/employee/updateexport/{type}', ['as' => 'editor.employee.updateexport', 'uses' => 'EmployeeController@updateexport']);

    //Training Provider
    //index
    Route::get('/training-provider', [TrainingProviderController::class, 'index'])->name('editor.training-provider.index');
    Route::get('/training-provider/data', [TrainingProviderController::class, 'data'])->name('editor.training-provider.data');
    //create
    Route::get('/training-provider/create', [TrainingProviderController::class, 'create'])->name('editor.training-provider.create');
    Route::post('/training-provider/create', [TrainingProviderController::class, 'store'])->name('editor.training-provider.store');
    //edit
    Route::get('/training-provider/edit/{id}', [TrainingProviderController::class, 'edit'])->name('editor.training-provider.edit');
    Route::put('/training-provider/edit/{id}', [TrainingProviderController::class, 'update'])->name('editor.training-provider.update');
    //delete
    Route::delete('/training-provider/delete/{id}', [TrainingProviderController::class, 'delete'])->name('editor.training-provider.delete');
    Route::post('/training-provider/deletebulk', [TrainingProviderController::class, 'deletebulk'])->name('editor.training-provider.deletebulk');

    //Absence Type
    //index
    Route::get('/absence-type', [AbsenceTypeController::class, 'index'])->name('editor.absence-type.index');
    Route::get('/absence-type/data', [AbsenceTypeController::class, 'data'])->name('editor.absence-type.data');
    //create
    Route::get('/absence-type/create', [AbsenceTypeController::class, 'create'])->name('editor.absence-type.create');
    Route::post('/absence-type/create', [AbsenceTypeController::class, 'store'])->name('editor.absence-type.store');
    //edit
    Route::get('/absence-type/edit/{id}', [AbsenceTypeController::class, 'edit']);
    Route::put('/absence-type/edit/{id}', [AbsenceTypeController::class, 'update']);
    //delete
    Route::delete('/absence-type/delete/{id}', [AbsenceTypeController::class, 'delete'])->name('editor.absence-type.delete');
    Route::post('/absence-type/deletebulk', [AbsenceTypeController::class, 'deletebulk'])->name('editor.absence-type.deletebulk');

    //Absence Period
    Route::get('/absence-period', [AbsencePeriodController::class, 'index'])->name('editor.absence-period.index');
    Route::get('/absence-period/data', [AbsencePeriodController::class, 'data'])->name('editor.absence-period.data');
    Route::post('/absence-period/store', [AbsencePeriodController::class, 'store'])->name('editor.absence-period.store');
    Route::get('/absence-period/edit/{id}', [AbsencePeriodController::class, 'edit'])->name('editor.absence-period.edit');
    Route::post('/absence-period/update/{id}', [AbsencePeriodController::class, 'update'])->name('editor.absence-period.update');
    Route::delete('absence-period/delete/{id}', [AbsencePeriodController::class, 'delete'])->name('editor.absence-period.delete');

    //Absence Location
    Route::get('/absence-location', [AbsenceLocationController::class, 'index'])->name('editor.absence-location.index');
    Route::get('/absence-location/data', [AbsenceLocationController::class, 'data'])->name('editor.absence-location.data');
    Route::get('/absence-location/create', [AbsenceLocationController::class, 'create'])->name('editor.absence-location.create');
    Route::post('/absence-location/store', [AbsenceLocationController::class, 'store'])->name('editor.absence-location.store');
    Route::get('/absence-location/edit/{id}', [AbsenceLocationController::class, 'edit'])->name('editor.absence-location.edit');
    Route::post('/absence-location/update/{id}', [AbsenceLocationController::class, 'update'])->name('editor.absence-location.update');
    Route::delete('/absence-location/delete/{id}', [AbsenceLocationController::class, 'delete'])->name('editor.absence-location.delete');

    //Overtime Type
    //index
    Route::get('/overtime-type', [OvertimeTypeController::class, 'index'])->name('editor.overtime-type.index');
    Route::get('/overtime-type/data', [OvertimeTypeController::class, 'data'])->name('editor.overtime-type.data');
    //create
    Route::get('/overtime-type/create', [OvertimeTypeController::class, 'create'])->name('editor.overtime-type.create');
    Route::post('/overtime-type/create', [OvertimeTypeController::class, 'store'])->name('editor.overtime-type.store');
    //edit
    Route::get('/overtime-type/edit/{id}', [OvertimeTypeController::class, 'edit'])->name('editor.overtime-type.edit');
    Route::put('/overtime-type/edit/{id}', [OvertimeTypeController::class, 'update'])->name('editor.overtime-type.update');
    //delete
    Route::delete('/overtime-type/delete/{id}', [OvertimeTypeController::class, 'delete'])->name('editor.overtime-type.delete');
    Route::post('/overtime-type/deletebulk', [OvertimeTypeController::class, 'deletebulk'])->name('editor.overtime-type.deletebulk');


    //Payroll Type
    //index
    Route::get('/payroll-type', [PayrollTypeController::class, 'index'])->name('editor.payroll-type.index');
    Route::get('/payroll-type/data', [PayrollTypeController::class, 'data'])->name('editor.payroll-type.data');
    //create
    Route::get('/payroll-type/create', [PayrollTypeController::class, 'create'])->name('editor.payroll-type.create');
    Route::post('/payroll-type/create', [PayrollTypeController::class, 'store'])->name('editor.payroll-type.store');
    //edit
    Route::get('/payroll-type/edit/{id}', [PayrollTypeController::class, 'edit'])->name('editor.payroll-type.edit');
    Route::put('/payroll-type/edit/{id}', [PayrollTypeController::class, 'update'])->name('editor.payroll-type.update');
    //delete
    Route::delete('/payroll-type/delete/{id}', [PayrollTypeController::class, 'delete'])->name('editor.payroll-type.delete');
    Route::post('/payroll-type/deletebulk', [PayrollTypeController::class, 'deletebulk'])->name('editor.payroll-type.deletebulk');

    // Payroll Slip
    // Route::view('/payroll-slip', 'editor.payroll-slip.index');
    Route::get('/payroll-slip', [PayrollSlipController::class, 'index'])->name('editor.payroll-slip.index');
    Route::post('/payroll-slip', [PayrollSlipController::class, 'store'])->name('editor.payroll-slip.store');

    // Payroll Component
    Route::get('/payroll-component', [PayrollComponentController::class, 'index'])->name('editor.payroll-component.index');
    Route::get('/payroll-component/data', [PayrollComponentController::class, 'data'])->name('editor.payroll-component.data');
    Route::get('/payroll-component/create', [PayrollComponentController::class, 'create'])->name('editor.payroll-component.create');
    Route::post('/payroll-component/store', [PayrollComponentController::class, 'store'])->name('editor.payroll-component.store');
    Route::get('/payroll-component/edit/{id}', [PayrollComponentController::class, 'edit'])->name('editor.payroll-component.edit');
    Route::put('/payroll-component/update/{id}', [PayrollComponentController::class, 'update'])->name('editor.payroll-component.update');
    Route::delete('/payroll-component/delete/{id}', [PayrollComponentController::class, 'delete'])->name('editor.payroll-component.delete');

    // BPJS TK
    Route::get('/bpjs-tk', [BPJSTKController::class, 'index'])->name('editor.bpjs-tk.index');
    //create
    Route::get('/bpjs-tk/create', [BPJSTKController::class, 'create'])->name('editor.bpjs-tk.create');
    //edit
    Route::get('/bpjs-tk/edit/{id}', [BPJSTKController::class, 'edit'])->name('editor.bpjs-tk.edit');
    //data
    Route::get('/bpjs-tk/data', [BPJSTKController::class, 'data'])->name('editor.bpjs-tk.data');
    //store
    Route::post('/bpjs-tk/create', [BPJSTKController::class, 'store'])->name('editor.bpjs-tk.store');
    //update
    Route::post('/bpjs-tk/edit/{id}', [BPJSTKController::class, 'update'])->name('editor.bpjs-tk.update');
    //delete
    Route::delete('/bpjs-tk/delete/{id}', [BPJSTKController::class, 'delete'])->name('editor.bpjs-tk.delete');

    // BPJS Kesehatan
    Route::get('/bpjs-kesehatan', [BPJSKesehatanController::class, 'index'])->name('editor.bpjs-kesehatan.index');
    //create
    Route::get('/bpjs-kesehatan/create', [BPJSKesehatanController::class, 'create'])->name('editor.bpjs-kesehatan.create');
    //edit
    Route::get('/bpjs-kesehatan/edit/{id}', [BPJSKesehatanController::class, 'edit'])->name('editor.bpjs-kesehatan.edit');
    //data
    Route::get('/bpjs-kesehatan/data', [BPJSKesehatanController::class, 'data'])->name('editor.bpjs-kesehatan.data');
    //store
    Route::post('/bpjs-kesehatan/create', [BPJSKesehatanController::class, 'store'])->name('editor.bpjs-kesehatan.store');
    //update
    Route::post('/bpjs-kesehatan/edit/{id}', [BPJSKesehatanController::class, 'update'])->name('editor.bpjs-kesehatan.update');
    //delete
    Route::delete('/bpjs-kesehatan/delete/{id}', [BPJSKesehatanController::class, 'delete'])->name('editor.bpjs-kesehatan.delete');

    //Loan Type
    //index
    Route::get('/loan-type', [LoanTypeController::class, 'index'])->name('editor.loan-type.index');
    Route::get('/loan-type/data', [LoanTypeController::class, 'data'])->name('editor.loan-type.data');
    //create
    Route::get('/loan-type/create', [LoanTypeController::class, 'create'])->name('editor.loan-type.create');
    Route::post('/loan-type/create', [LoanTypeController::class, 'store'])->name('editor.loan-type.store');
    //edit
    Route::get('/loan-type/edit/{id}', [LoanTypeController::class, 'edit'])->name('editor.loan-type.edit');
    Route::put('/loan-type/edit/{id}', [LoanTypeController::class, 'update'])->name('editor.loan-type.update');
    //delete
    Route::delete('/loan-type/delete/{id}', [LoanTypeController::class, 'delete'])->name('editor.loan-type.delete');
    Route::post('/loan-type/deletebulk', [LoanTypeController::class, 'deletebulk'])->name('editor.loan-type.deletebulk');

    //Tarif
    // //index
    // Route::get('/tarif', [TarifController::class, 'index'])->name('editor.tarif.index');
    // Route::get('/tarif/data', [TarifController::class, 'data'])->name('editor.tarif.data');
    // //create
    // Route::get('/tarif/create', [TarifController::class, 'create'])->name('editor.tarif.create');
    // Route::post('/tarif/create', [TarifController::class, 'store'])->name('editor.tarif.store');
    // //edit
    // Route::get('/tarif/edit/{id}', [TarifController::class, 'edit'])->name('editor.tarif.edit');
    // Route::put('/tarif/edit/{id}', [TarifController::class, 'update'])->name('editor.tarif.update');
    // //delete
    // Route::delete('/tarif/delete/{id}', [TarifController::class, 'delete'])->name('editor.tarif.delete');
    // Route::post('/tarif/deletebulk', [TarifController::class, 'deletebulk'])->name('editor.tarif.deletebulk');

    //Holiday
    //index
    Route::get('/holiday', [HolidayController::class, 'index'])->name('editor.holiday.index');
    Route::get('/holiday/data', [HolidayController::class, 'data'])->name('editor.holiday.data');
    //create
    Route::get('/holiday/create', [HolidayController::class, 'create'])->name('editor.holiday.create');
    Route::post('/holiday/create', [HolidayController::class, 'store'])->name('editor.holiday.store');
    //edit
    Route::get('/holiday/edit/{id}', [HolidayController::class, 'edit'])->name('editor.holiday.edit');
    Route::put('/holiday/edit/{id}', [HolidayController::class, 'update'])->name('editor.holiday.update');
    //delete
    Route::delete('/holiday/delete/{id}', [HolidayController::class, 'delete'])->name('editor.holiday.delete');
    Route::post('/holiday/deletebulk', [HolidayController::class, 'deletebulk'])->name('editor.holiday.deletebulk');

    //User filter
    //index
    Route::get('/userfilter', ['as' => 'editor.userfilter.index', 'uses' => 'UserFilterController@index'])->middleware(['role:userfilter|read']);
    Route::get('/userfilter/data', ['as' => 'editor.userfilter.data', 'uses' => 'UserFilterController@data']);
    //create
    Route::get('/userfilter/create', ['as' => 'editor.userfilter.create', 'uses' => 'UserFilterController@create'])->middleware(['role:userfilter|create']);
    Route::post('/userfilter/create', ['as' => 'editor.userfilter.store', 'uses' => 'UserFilterController@store'])->middleware(['role:userfilter|create']);
    //edit
    Route::get('/userfilter/edit/{id}', ['as' => 'editor.userfilter.edit', 'uses' => 'UserFilterController@edit'])->middleware(['role:userfilter|update']);
    Route::put('/userfilter/edit/{id}', ['as' => 'editor.userfilter.update', 'uses' => 'UserFilterController@update'])->middleware(['role:userfilter|update']);
    //delete
    Route::delete('/userfilter/delete/{id}', ['as' => 'editor.userfilter.delete', 'uses' => 'UserFilterController@delete'])->middleware(['role:userfilter|delete']);
    Route::post('/userfilter/deletebulk', ['as' => 'editor.userfilter.deletebulk', 'uses' => 'UserFilterController@deletebulk'])->middleware(['role:userfilter|delete']);

    //Leave
    //index
    Route::get('/leave', [LeaveController::class, 'index'])->name('editor.leave.index')->middleware(['role:ijin|read']);
    Route::get('/leave/data', [LeaveController::class, 'data'])->name('editor.leave.data');
    Route::get('/leave/datahistory', [LeaveController::class, 'datahistory'])->name('editor.leave.datahistory');
    //create
    Route::get('/leave/create', [LeaveController::class, 'create'])->name('editor.leave.create')->middleware(['role:ijin|create']);
    Route::post('/leave/create', [LeaveController::class, 'store'])->name('editor.leave.store')->middleware(['role:ijin|create']);
    //edit
    Route::get('/leave/{id}/edit', [LeaveController::class, 'edit'])->name('editor.leave.edit')->middleware(['role:ijin|update']);
    Route::put('/leave/{id}/edit', [LeaveController::class, 'update'])->name('editor.leave.update')->middleware(['role:ijin|update']);
    //delete
    Route::delete('/leave/delete/{id}', [LeaveController::class, 'delete'])->name('editor.leave.delete')->middleware(['role:ijin|delete']);
    Route::post('/leave/deletebulk', [LeaveController::class, 'deletebulk'])->name('editor.leave.deletebulk');


    //ShiftSchedule
    //index
    Route::get('/shift-schedule', [ShiftScheduleController::class, 'index'])->name('editor.shift-schedule.index');
    Route::get('/shift-schedule/data', [ShiftScheduleController::class, 'data'])->name('editor.shift-schedule.data');
    //create
    Route::get('/shift-schedule/create', [ShiftScheduleController::class, 'create'])->name('editor.shift-schedule.create');
    Route::post('/shift-schedule/create', [ShiftScheduleController::class, 'store'])->name('editor.shift-schedule.store');
    //edit
    Route::get('/shift-schedule/{id}/edit', [ShiftScheduleController::class, 'edit'])->name('editor.shift-schedule.edit');
    Route::put('/shift-schedule/{id}/edit', [ShiftScheduleController::class, 'update'])->name('editor.shift-schedule.update');
    Route::get('/shift-schedule/{id}/slip', [ShiftScheduleController::class, 'slip'])->name('editor.shift-schedule.slip');
    Route::get('/shift-schedule/{id}/slip-print', [ShiftScheduleController::class, 'slip_print'])->name('editor.shift-schedule.slip-print');
    //delete
    Route::delete('/shift-schedule/delete/{id}', [ShiftScheduleController::class, 'delete'])->name('editor.shift-schedule.delete');
    Route::post('/shift-schedule/deletebulk', [ShiftScheduleController::class, 'deletebulk'])->name('editor.shift-schedule.deletebulk');

    //ShiftPlan
    //index
    Route::get('/shift-plan', [ShiftPlanController::class, 'index'])->name('editor.shift-plan.index')->middleware(['role:jadwal_shift|read']);
    Route::get('/shift-plan/data', [ShiftPlanController::class, 'data'])->name('editor.shift-plan.data');
    //create
    Route::get('/shift-plan/create', [ShiftPlanController::class, 'create'])->name('editor.shift-plan.create')->middleware(['role:jadwal_shift|create']);
    Route::post('/shift-plan/create', [ShiftPlanController::class, 'store'])->name('editor.shift-plan.store')->middleware(['role:jadwal_shift|create']);
    //edit
    Route::get('/shift-plan/{id}/edit', [ShiftPlanController::class, 'edit'])->name('editor.shift-plan.edit')->middleware(['role:jadwal_shift|update']);
    Route::post('/shift-plan/edit', [ShiftPlanController::class, 'update'])->name('editor.shift-plan.update')->middleware(['role:jadwal_shift|update']);
    Route::get('/shift-plan/{id}/slip', [ShiftPlanController::class, 'slip'])->name('editor.shift-plan.slip');
    Route::get('/shift-plan/{id}/slip-print', [ShiftPlanController::class, 'slip_print'])->name('editor.shift-plan.slip-print');
    //delete
    Route::delete('/shift-plan/delete/{id}', [ShiftPlanController::class, 'delete'])->name('editor.shift-plan.delete')->middleware(['role:jadwal_shift|delete']);
    Route::post('/shift-plan/deletebulk', [ShiftPlanController::class, 'deletebulk'])->name('editor.shift-plan.deletebulk');
    //lookup
    Route::get('/shift-plan/lookup', [ShiftPlanController::class, 'lookup'])->name('editor.shift-plan.lookup');


    //Overtime
    //index
    Route::get('/overtime', [OvertimeController::class, 'index'])->name('editor.overtime.index')->middleware(['role:lembur|read']);
    Route::get('/overtime/data', [OvertimeController::class, 'data'])->name('editor.overtime.data');
    Route::get('/overtime/datahistory', [OvertimeController::class, 'datahistory'])->name('editor.overtime.datahistory');
    //create
    Route::get('/overtime/create', [OvertimeController::class, 'create'])->name('editor.overtime.create')->middleware(['role:lembur|create']);
    Route::post('/overtime/create', [OvertimeController::class, 'store'])->name('editor.overtime.store')->middleware(['role:lembur|create']);
    //edit
    Route::get('/overtime/{id}/edit', [OvertimeController::class, 'edit'])->name('editor.overtime.edit')->middleware(['role:lembur|update']);
    Route::put('/overtime/{id}/edit', [OvertimeController::class, 'update'])->name('editor.overtime.update')->middleware(['role:lembur|update']);
    //delete
    Route::delete('/overtime/delete/{id}', [OvertimeController::class, 'delete'])->name('editor.overtime.delete')->middleware(['role:lembur|delete']);
    Route::post('/overtime/deletebulk', [OvertimeController::class, 'deletebulk'])->name('editor.overtime.deletebulk');

    //Training
    //index
    Route::get('/training', [TrainingController::class, 'index'])->name('editor.training.index')->middleware(['role:pelatihan|read']);
    Route::get('/training/data', [TrainingController::class, 'data'])->name('editor.training.data');
    Route::get('/training/datahistory', [TrainingController::class, 'datahistory'])->name('editor.training.datahistory');
    Route::get('/training/dataparticipant/{id}', [TrainingController::class, 'dataparticipant'])->name('editor.training.dataparticipant');
    //create
    Route::get('/training/create', [TrainingController::class, 'create'])->name('editor.training.create')->middleware(['role:pelatihan|create']);
    Route::post('/training/create', [TrainingController::class, 'store'])->name('editor.training.store')->middleware(['role:pelatihan|create']);
    //edit
    Route::get('/training/{id}/edit', [TrainingController::class, 'edit'])->name('editor.training.edit')->middleware(['role:pelatihan|update']);
    Route::put('/training/{id}/edit', [TrainingController::class, 'update'])->name('editor.training.update')->middleware(['role:pelatihan|update']);
    //delete
    Route::delete('/training/delete/{id}', [TrainingController::class, 'delete'])->name('editor.training.delete')->middleware(['role:pelatihan|delete']);
    Route::put('/training/cancel/{id}', [TrainingController::class, 'cancel'])->name('editor.training.cancel');
    // save detail
    Route::put('/training/savedetail/{id}', [TrainingController::class, 'savedetail'])->name('editor.training.savedetail');
    Route::delete('/training/deletedet/{id}', [TrainingController::class, 'deletedet'])->name('editor.training.deletedet');

    //Punishment
    //index
    Route::get('/punishment', [PunishmentController::class, 'index'])->name('editor.punishment.index')->middleware(['role:teguran|read']);
    Route::get('/punishment/data', [PunishmentController::class, 'data'])->name('editor.punishment.data');
    //create
    Route::get('/punishment/create', [PunishmentController::class, 'create'])->name('editor.punishment.create')->middleware(['role:teguran|create']);
    Route::post('/punishment/create', [PunishmentController::class, 'store'])->name('editor.punishment.store')->middleware(['role:teguran|create']);
    //edit
    Route::get('/punishment/{id}/edit', [PunishmentController::class, 'edit'])->name('editor.punishment.edit')->middleware(['role:teguran|update']);
    Route::put('/punishment/{id}/edit', [PunishmentController::class, 'update'])->name('editor.punishment.update')->middleware(['role:teguran|update']);
    //delete
    Route::delete('/punishment/delete/{id}', [PunishmentController::class, 'delete'])->name('editor.punishment.delete')->middleware(['role:teguran|delete']);
    Route::put('/punishment/cancel/{id}', [PunishmentController::class, 'cancel'])->name('editor.punishment.cancel');

    //Event
    //index
    Route::get('/event', [EventController::class, 'index'])->name('editor.event.index')->middleware(['role:acara|read']);
    Route::get('/event/data', [EventController::class, 'data'])->name('editor.event.data');
    //create
    Route::get('/event/create', [EventController::class, 'create'])->name('editor.event.create')->middleware(['role:acara|create']);
    Route::post('/event/create', [EventController::class, 'store'])->name('editor.event.store')->middleware(['role:acara|create']);
    //edit
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('editor.event.edit')->middleware(['role:acara|update']);
    Route::put('/event/{id}/edit', [EventController::class, 'update'])->name('editor.event.update')->middleware(['role:acara|update']);
    //qrcode
    Route::get('/event/{id}/qrcode', [EventController::class, 'qrcode'])->name('editor.event.qrcode');
    //delete
    Route::delete('/event/delete/{id}', [EventController::class, 'delete'])->name('editor.event.delete')->middleware(['role:acara|delete']);

    //Reward
    //index
    Route::get('/reward', [RewardController::class, 'index'])->name('editor.reward.index')->middleware(['role:penghargaan|read']);
    Route::get('/reward/data', [RewardController::class, 'data'])->name('editor.reward.data');
    //create
    Route::get('/reward/create', [RewardController::class, 'create'])->name('editor.reward.create')->middleware(['role:penghargaan|create']);
    Route::post('/reward/create', [RewardController::class, 'store'])->name('editor.reward.store')->middleware(['role:penghargaan|create']);
    //edit
    Route::get('/reward/{id}/edit', [RewardController::class, 'edit'])->name('editor.reward.edit')->middleware(['role:penghargaan|update']);
    Route::put('/reward/{id}/edit', [RewardController::class, 'update'])->name('editor.reward.update')->middleware(['role:penghargaan|update']);
    //delete
    Route::delete('/reward/delete/{id}', [RewardController::class, 'delete'])->name('editor.reward.delete')->middleware(['role:penghargaan|delete']);
    Route::put('/reward/cancel/{id}', [RewardController::class, 'cancel'])->name('editor.reward.cancel');

    //Document
    //index
    Route::get('/document', [DocumentController::class, 'index'])->name('editor.document.index')->middleware(['role:dokumen|read']);
    Route::get('/document/data', [DocumentController::class, 'data'])->name('editor.document.data');
    //create
    Route::get('/document/create', [DocumentController::class, 'create'])->name('editor.document.create')->middleware(['role:dokumen|create']);
    Route::post('/document/create', [DocumentController::class, 'store'])->name('editor.document.store')->middleware(['role:dokumen|create']);
    //edit
    Route::get('/document/{id}/edit', [DocumentController::class, 'edit'])->name('editor.document.edit')->middleware(['role:dokumen|update']);
    Route::put('/document/{id}/edit', [DocumentController::class, 'update'])->name('editor.document.update')->middleware(['role:dokumen|update']);
    //delete
    Route::delete('/document/delete/{id}', [DocumentController::class, 'delete'])->name('editor.document.delete')->middleware(['role:dokumen|delete']);
    Route::post('/document/deletebulk', [DocumentController::class, 'deletebulk'])->name('editor.document.deletebulk');


    //Preference
    //index
    Route::get('/preference', [PreferenceController::class, 'index'])->name('editor.preference.index');
    Route::get('/preference/data', [PreferenceController::class, 'data'])->name('editor.preference.data');
    //create
    Route::get('/preference/create', [PreferenceController::class, 'create'])->name('editor.preference.create');
    Route::post('/preference/create', [PreferenceController::class, 'store'])->name('editor.preference.store');
    //edit
    Route::get('/preference/{id}/edit', [PreferenceController::class, 'edit'])->name('editor.preference.edit');
    Route::put('/preference/{id}/edit', [PreferenceController::class, 'update'])->name('editor.preference.update');
    //delete
    Route::delete('/preference/delete/{id}', [PreferenceController::class, 'delete'])->name('editor.preference.delete');
    Route::post('/preference/deletebulk', [PreferenceController::class, 'deletebulk']);

    //Cash receive
    //index
    Route::get('/cash-receive', [CashReceiveController::class, 'index'])->name('editor.cash-receive.index');
    Route::get('/cash-receive/data', [CashReceiveController::class, 'data'])->name('editor.cash-receive.data');
    //slip
    Route::get('/cash-receive/slip/{id}', [CashReceiveController::class, 'slip'])->name('editor.cash-receive.slip');
    //create
    Route::get('/cash-receive/create', [CashReceiveController::class, 'create'])->name('editor.cash-receive.create');
    Route::post('/cash-receive/create', [CashReceiveController::class, 'store'])->name('editor.cash-receive.store');
    //cancel
    Route::post('/cash-receive/cancel/{id}', [CashReceiveController::class, 'cancel'])->name('editor.cash-receive.cancel');
    //close
    Route::post('/cash-receive/close/{id}', [CashReceiveController::class, 'close'])->name('editor.cash-receive.close');
    //detail
    Route::get('/cash-receive/detail/{id}', [CashReceiveController::class, 'detail'])->name('editor.cash-receive.detail');
    Route::put('/cash-receive/saveheader/{id}', [CashReceiveController::class, 'saveheader'])->name('editor.cash-receive.saveheader');
    Route::put('/cash-receive/savedetail/{id}', [CashReceiveController::class, 'savedetail'])->name('editor.cash-receive.savedetail');
    Route::post('/cash-receive/updatedetail/{id}', [CashReceiveController::class, 'updatedetail'])->name('editor.cash-receive.updatedetail');
    Route::put('/cash-receive/detail/{id}', [CashReceiveController::class, 'update'])->name('editor.cash-receive.update');
    //delete
    Route::delete('/cash-receive/deletedet/{id}', [CashReceiveController::class, 'deletedet'])->name('editor.cash-receive.deletedet');
    // detailitem
    Route::get('/cash-receive/datadetail/{id}', [CashReceiveController::class, 'datadetail'])->name('editor.cash-receive.datadetail');


    //Cash payment
    //index
    Route::get('/cash-payment', [CashPaymentController::class, 'index'])->name('editor.cash-payment.index');
    Route::get('/cash-payment/data', [CashPaymentController::class, 'data'])->name('editor.cash-payment.data');
    //slip
    Route::get('/cash-payment/slip/{id}', [CashPaymentController::class, 'slip'])->name('editor.cash-payment.slip');
    //create
    Route::get('/cash-payment/create', [CashPaymentController::class, 'create'])->name('editor.cash-payment.create');
    Route::post('/cash-payment/create', [CashPaymentController::class, 'store'])->name('editor.cash-payment.store');
    //cancel
    Route::post('/cash-payment/cancel/{id}', [CashPaymentController::class, 'cancel'])->name('editor.cash-payment.cancel');
    //close
    Route::post('/cash-payment/close/{id}', [CashPaymentController::class, 'close'])->name('editor.cash-payment.close');
    //detail
    Route::get('/cash-payment/detail/{id}', [CashPaymentController::class, 'detail'])->name('editor.cash-payment.detail');
    Route::put('/cash-payment/saveheader/{id}', [CashPaymentController::class, 'saveheader'])->name('editor.cash-payment.saveheader');
    Route::put('/cash-payment/savedetail/{id}', [CashPaymentController::class, 'savedetail'])->name('editor.cash-payment.savedetail');
    Route::post('/cash-payment/updatedetail/{id}', [CashPaymentController::class, 'updatedetail'])->name('editor.cash-payment.updatedetail');
    Route::put('/cash-payment/detail/{id}', [CashPaymentController::class, 'update'])->name('editor.cash-payment.update');
    //delete
    Route::delete('/cash-payment/deletedet/{id}', [CashPaymentController::class, 'deletedet'])->name('editor.cash-payment.deletedet');
    // detailitem
    Route::get('/cash-payment/datadetail/{id}', [CashPaymentController::class, 'datadetail'])->name('editor.cash-payment.datadetail');

    //report ledger
    Route::get('/report-ledger', [ReportLedgerController::class, 'index'])->name('editor.report-ledger.index');
    Route::get('/report-ledger/print/{id1}/{id2}/{id3}/{id4}', [ReportLedgerController::class, 'report_print'])->name('editor.report-ledger.print');

    //Reimburse
    //index
    Route::get('/reimburse', [ReimburseController::class, 'index'])->name('editor.reimburse.index')->middleware(['role:klaim|read']);
    Route::get('/reimburse/data', [ReimburseController::class, 'data'])->name('editor.reimburse.data');
    //create
    Route::get('/reimburse/create', [ReimburseController::class, 'create'])->name('editor.reimburse.create')->middleware(['role:klaim|create']);
    Route::post('/reimburse/create', [ReimburseController::class, 'store'])->name('editor.reimburse.store')->middleware(['role:klaim|create']);
    //detail
    Route::get('/reimburse/detail/{id}', [ReimburseController::class, 'detail'])->name('editor.reimburse.detail')->middleware(['role:klaim|update']);
    Route::get('/reimburse/slip/{id}', [ReimburseController::class, 'slip'])->name('editor.reimburse.slip');
    Route::put('/reimburse/saveheader/{id}', [ReimburseController::class, 'saveheader'])->name('editor.reimburse.saveheader');
    Route::put('/reimburse/savedetail/{id}', [ReimburseController::class, 'savedetail'])->name('editor.reimburse.savedetail');
    Route::put('/reimburse/detail/{id}', [ReimburseController::class, 'update'])->name('editor.reimburse.update')->middleware(['role:klaim|update']);
    //delete
    Route::delete('/reimburse/deletedet/{id}', [ReimburseController::class, 'deletedet'])->name('editor.reimburse.deletedet');
    Route::post('/reimburse/deletebulk', [ReimburseController::class, 'deletebulk'])->name('editor.reimburse.deletebulk');
    // detail item
    Route::get('/reimburse/datadetail/{id}', [ReimburseController::class, 'datadetail'])->name('editor.reimburse.datadetail');
    //generate
    Route::get('/reimburse/generate/{id}', [ReimburseController::class, 'generate'])->name('editor.reimburse.generate');
    Route::post('/reimburse/generate/{id}', [ReimburseController::class, 'generate'])->name('editor.reimburse.generate');
    Route::delete('/reimburse/delete/{id}', [ReimburseController::class, 'delete'])->name('editor.reimburse.delete')->middleware(['role:klaim|delete']);
    //Reimburse Type
    Route::get('/reimburse-type', [ReimburseTypeController::class, 'index'])->name('editor.reimburse-type');
    Route::get('/reimburse-type/data', [ReimburseTypeController::class, 'data'])->name('editor.reimburse-type.data');
    Route::post('/reimburse-type/store', [ReimburseTypeController::class, 'store'])->name('editor.reimburse-type.store');
    Route::get('/reimburse-type/edit/{id}', [ReimburseTypeController::class, 'edit']);
    Route::put('/reimburse-type/edit/{id}', [ReimburseTypeController::class, 'update']);
    Route::delete('/reimburse-type/delete/{id}', [ReimburseTypeController::class, 'destroy'])->name('editor.reimburse-type.delete');

    //ReimburseApproval
    //index
    Route::get('/reimburse-approval', [ReimburseApprovalController::class, 'index'])->name('editor.reimburse-approval.index');
    Route::get('/reimburse-approval/data', [ReimburseApprovalController::class, 'data'])->name('editor.reimburse-approval.data');
    //create
    Route::get('/reimburse-approval/create', [ReimburseApprovalController::class, 'create'])->name('editor.reimburse-approval.create');
    Route::post('/reimburse-approval/create', [ReimburseApprovalController::class, 'store'])->name('editor.reimburse-approval.store');
    //detail
    Route::get('/reimburse-approval/detail/{id}', [ReimburseApprovalController::class, 'detail'])->name('editor.reimburse-approval.detail');
    Route::get('/reimburse-approval/slip/{id}', [ReimburseApprovalController::class, 'slip'])->name('editor.reimburse-approval.slip');
    Route::put('/reimburse-approval/detail/{id}', [ReimburseApprovalController::class, 'update'])->name('editor.reimburse-approval.update');

    //Time
    //index
    Route::get('/time', [TimeController::class, 'index'])->name('editor.time.index')->middleware(['role:kelola_absensi|read']);
    Route::get('/time/data', [TimeController::class, 'data'])->name('editor.time.data');
    Route::get('/time/datadetail/{id}', [TimeController::class, 'datadetail'])->name('editor.time.datadetail');
    //create
    // Route::get('/time/create/{id}', [TimeController::class, 'create'])->name('editor.time.create')->middleware(['role:kelola_absensi|create']);
    Route::post('/time/store', [TimeController::class, 'store'])->name('editor.time.store')->middleware(['role:kelola_absensi|create']);
    //edit
    Route::get('/time/{id}/{id2}/edit', [TimeController::class, 'edit'])->name('editor.time.edit')->middleware(['role:kelola_absensi|update']);
    Route::put('/time/{id}/{id2}/edit', [TimeController::class, 'update'])->name('editor.time.update')->middleware(['role:kelola_absensi|update']);
    Route::get('/time/datadetail', [TimeController::class, 'datadetail'])->name('editor.time.datadetail');
    //generate
    Route::get('/time/generate/{id}', [TimeController::class, 'generate'])->name('editor.time.generate');
    Route::post('/time/generate/{id}', [TimeController::class, 'generate'])->name('editor.time.generate');
    Route::post('/time/generateshiftschedule/{id}', [TimeController::class, 'generateshiftschedule'])->name('editor.time.generateshiftschedule');


    //Payroll
    //index
    Route::get('/payroll', [PayrollController::class, 'index'])->name('editor.payroll.index');
    Route::get('/payroll/data', [PayrollController::class, 'data'])->name('editor.payroll.data');
    //create
    Route::get('/payroll/create/{id}', [PayrollController::class, 'create'])->name('editor.payroll.create');
    Route::post('/payroll/create/{id}', [PayrollController::class, 'store'])->name('editor.payroll.store');
    //edit
    Route::get('/payroll/{id}/edit', [PayrollController::class, 'edit'])->name('editor.payroll.edit')->middleware(['role:gaji|update']);
    Route::put('/payroll/{id}/edit', [PayrollController::class, 'update'])->name('editor.payroll.update')->middleware(['role:gaji|update']);
    //generate
    Route::get('/payroll/generate/{id}', [PayrollController::class, 'generate'])->name('editor.payroll.generate');
    Route::post('/payroll/generate/{id}', [PayrollController::class, 'generate'])->name('editor.payroll.generate');
    //slip
    Route::get('/payroll/slip/{id}', [PayrollController::class, 'slip'])->name('editor.payroll.slip');
    Route::get('/payroll/{id}/report', [PayrollController::class, 'report'])->name('editor.payroll.report');
    Route::get('/payroll/{id}/report-print', [PayrollController::class, 'report_print'])->name('editor.payroll.report-print');
    Route::get('/payroll/{id}/slip-print', [PayrollController::class, 'slip_print'])->name('editor.payroll.report-print');
    //history
    Route::get('/payroll/dataabsence', [PayrollController::class, 'dataabsence'])->name('editor.payroll.dataabsence');
    Route::post('/payroll/store-absence', [PayrollController::class, 'store_absence'])->name('editor.payroll-absence.store');

    Route::post('/payroll/slip-print-employee', [PayrollController::class, 'send_receipt'])->name('editor.payroll.send-receipt');

    //Payroll Report
    //index
    Route::get('/payroll-report', [PayrollReportController::class, 'index'])->name('editor.payroll-report.index')->middleware(['role:tinjauan_gaji|read']);

    //Faq
    //index
    Route::get('/faq', [FaqController::class, 'index'])->name('editor.faq.index')->middleware(['role:faq|read']);
    Route::get('/faq/data', [FaqController::class, 'data'])->name('editor.faq.data');
    //create
    Route::get('/faq/create', [FaqController::class, 'create'])->name('editor.faq.create')->middleware(['role:faq|create']);
    Route::post('/faq/create', [FaqController::class, 'store'])->name('editor.faq.store')->middleware(['role:faq|create']);
    //edit
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('editor.faq.edit')->middleware(['role:faq|update']);
    Route::put('/faq/edit/{id}', [FaqController::class, 'update'])->name('editor.faq.update')->middleware(['role:faq|update']);
    //delete
    Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('editor.faq.delete')->middleware(['role:faq|delete']);
    Route::post('/faq/deletebulk', [FaqController::class, 'deletebulk'])->name('editor.faq.deletebulk')->middleware(['role:faq|delete']);


    //Popup
    //index
    Route::get('/popup', ['as' => 'editor.popup.index', 'uses' => 'PopupController@index'])->middleware(['role:popup|read']);
    //edit
    Route::get('/popup/edit/{id}', ['as' => 'editor.popup.edit', 'uses' => 'PopupController@edit'])->middleware(['role:popup|update']);
    Route::put('/popup/edit/{id}', ['as' => 'editor.popup.update', 'uses' => 'PopupController@update'])->middleware(['role:popup|update']);
    //userlog
    Route::get('/userlog', [UserLogController::class, 'index'])->name('editor.userlog.index');
    Route::get('/userlog/form', [UserLogController::class, 'create'])->name('editor.userlog.form');
    Route::post('/userlog/form', [UserLogController::class, 'store'])->name('editor.userlog.store');

    //Manual Book
    //index
    Route::get('/manual-book', [ManualBookController::class, 'index'])->name('editor.manual-book.index');
    Route::get('/manual-book/data', [ManualBookController::class, 'data'])->name('editor.manual-book.data');
    //create
    Route::get('/manual-book/create', [ManualBookController::class, 'create'])->name('editor.manual-book.create');
    Route::post('/manual-book/create', [ManualBookController::class, 'store'])->name('editor.manual-book.store');
    //edit
    Route::get('/manual-book/edit/{id}', [ManualBookController::class, 'edit'])->name('editor.manual-book.edit');
    Route::put('/manual-book/edit/{id}', [ManualBookController::class, 'update'])->name('editor.manual-book.update');
    //delete
    Route::delete('/manual-book/delete/{id}', [ManualBookController::class, 'delete'])->name('editor.manual-book.delete');
    //show
    Route::get('/manual-book/show/{id}', [ManualBookController::class, 'show'])->name('editor.manual-book.show');

    // filter
    Route::post('/periodfilteronly', [UserController::class, 'periodfilteronly'])->name('editor.periodfilteronly');

    Route::get('/provinces', [EmployeeController::class, 'get_provinces'])->name('editor.provinces');
})->namespace('Editor');
