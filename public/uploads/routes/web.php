<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'Editor'], function()
{
	Route::get('/', ['as' => 'editor.index', 'uses' => 'EditorController@index']);
});

//User Management
Route::group(['prefix' => 'editor', 'middleware' => 'auth', 'namespace' => 'Editor'], function()
{
	//Home
	Route::get('/', ['as' => 'editor.index', 'uses' => 'EditorController@index']);
	//Notif
	Route::get('/notif', ['as' => 'editor.notif.index', 'uses' => 'EditorController@notif']);
	//Profile
		//detail
	Route::get('/profile', ['as' => 'editor.profile.show', 'uses' => 'ProfileController@show']);
		//edit
	Route::get('/profile/edit', ['as' => 'editor.profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('/profile/edit', ['as' => 'editor.profile.update', 'uses' => 'ProfileController@update']);
		//edit password
	Route::get('/profile/password', ['as' => 'editor.profile.edit_password', 'uses' => 'ProfileController@edit_password']);
	Route::put('/profile/password', ['as' => 'editor.profile.update_password', 'uses' => 'ProfileController@update_password']);

	//Filter
	Route::post('/datefilter', ['as' => 'editor.datefilter', 'uses' => 'UserController@datefilter']);
	Route::post('/employeefilter', ['as' => 'editor.employeefilter', 'uses' => 'UserController@employeefilter']);
	Route::post('/periodfilter', ['as' => 'editor.periodfilter', 'uses' => 'UserController@periodfilter']);
	Route::post('/periodfilterthr', ['as' => 'editor.periodfilterthr', 'uses' => 'UserController@periodfilterthr']);
	Route::post('/periodfilteronly', ['as' => 'editor.periodfilteronly', 'uses' => 'UserController@periodfilteronly']);
	Route::post('/periodfilteremp', ['as' => 'editor.periodfilteremp', 'uses' => 'UserController@periodfilteremp']);

	//User
		//index
	Route::get('/user', ['middleware' => ['role:user|read'], 'as' => 'editor.user.index', 'uses' => 'UserController@index']);
		//create
	Route::get('/user/create', ['middleware' => ['role:user|create'], 'as' => 'editor.user.create', 'uses' => 'UserController@create']);
	Route::post('/user/create', ['middleware' => ['role:user|create'], 'as' => 'editor.user.store', 'uses' => 'UserController@store']);
		//edit
	Route::get('/user/{id}/edit', ['middleware' => ['role:user|update'], 'as' => 'editor.user.edit', 'uses' => 'UserController@edit']);
	Route::put('/user/{id}/edit', ['middleware' => ['role:user|update'], 'as' => 'editor.user.update', 'uses' => 'UserController@update']);
		//delete
	Route::delete('/user/delete/{id}', ['middleware' => ['role:user|delete'], 'as' => 'editor.user.delete', 'uses' => 'UserController@delete']);

	//User
		//index
	Route::get('/userbranch', ['middleware' => ['role:userbranch|read'], 'as' => 'editor.userbranch.index', 'uses' => 'UserbranchController@index']);
		//create
	Route::get('/userbranch/create', ['middleware' => ['role:userbranch|create'], 'as' => 'editor.userbranch.create', 'uses' => 'UserbranchController@create']);
	Route::post('/userbranch/create', ['middleware' => ['role:userbranch|create'], 'as' => 'editor.userbranch.store', 'uses' => 'UserbranchController@store']);
		//edit
	Route::get('/userbranch/{id}/edit', ['middleware' => ['role:userbranch|update'], 'as' => 'editor.userbranch.edit', 'uses' => 'UserbranchController@edit']);
	Route::put('/userbranch/{id}/edit', ['middleware' => ['role:userbranch|update'], 'as' => 'editor.userbranch.update', 'uses' => 'UserbranchController@update']);
		//delete
	Route::delete('/userbranch/{id}/delete', ['middleware' => ['role:userbranch|delete'], 'as' => 'editor.userbranch.delete', 'uses' => 'UserbranchController@delete']);

	//Module
		//index
	Route::get('/module', ['middleware' => ['role:module|read'], 'as' => 'editor.module.index', 'uses' => 'ModuleController@index']);
		//create
	Route::get('/module/create', ['middleware' => ['role:module|create'], 'as' => 'editor.module.create', 'uses' => 'ModuleController@create']);
	Route::post('/module/create', ['middleware' => ['role:module|create'], 'as' => 'editor.module.store', 'uses' => 'ModuleController@store']);
		//edit
	Route::get('/module/{id}/edit', ['middleware' => ['role:module|update'], 'as' => 'editor.module.edit', 'uses' => 'ModuleController@edit']);
	Route::put('/module/{id}/edit', ['middleware' => ['role:module|update'], 'as' => 'editor.module.update', 'uses' => 'ModuleController@update']);
		//delete
	Route::delete('/module/{id}/delete', ['middleware' => ['role:module|delete'], 'as' => 'editor.module.delete', 'uses' => 'ModuleController@delete']);
	//delete
	Route::delete('/module/delete/{id}', ['middleware' => ['role:module|delete'], 'as' => 'editor.module.delete', 'uses' => 'ModuleController@delete']);

	//Action
		//index
	Route::get('/action', ['middleware' => ['role:action|read'], 'as' => 'editor.action.index', 'uses' => 'ActionController@index']);
		//create
	Route::get('/action/create', ['middleware' => ['role:action|create'], 'as' => 'editor.action.create', 'uses' => 'ActionController@create']);
	Route::post('/action/create', ['middleware' => ['role:action|create'], 'as' => 'editor.action.store', 'uses' => 'ActionController@store']);
		//edit
	Route::get('/action/{id}/edit', ['middleware' => ['role:action|update'], 'as' => 'editor.action.edit', 'uses' => 'ActionController@edit']);
	Route::put('/action/{id}/edit', ['middleware' => ['role:action|update'], 'as' => 'editor.action.update', 'uses' => 'ActionController@update']);
		//delete
	Route::delete('/action/delete/{id}', ['middleware' => ['role:action|delete'], 'as' => 'editor.action.delete', 'uses' => 'ActionController@delete']);

	//Privilege
		//index
	Route::get('/privilege', ['middleware' => ['role:privilege|read'], 'as' => 'editor.privilege.index', 'uses' => 'PrivilegeController@index']);
		//create
	Route::get('/privilege/create', ['middleware' => ['role:privilege|create'], 'as' => 'editor.privilege.create', 'uses' => 'PrivilegeController@create']);
	Route::post('/privilege/create', ['middleware' => ['role:privilege|create'], 'as' => 'editor.privilege.store', 'uses' => 'PrivilegeController@store']);
		//edit
	Route::get('/privilege/{id}/edit', ['middleware' => ['role:privilege|update'], 'as' => 'editor.privilege.edit', 'uses' => 'PrivilegeController@edit']);
	Route::put('/privilege/{id}/edit', ['middleware' => ['role:privilege|update'], 'as' => 'editor.privilege.update', 'uses' => 'PrivilegeController@update']);
		//delete
	Route::delete('/privilege/{id}/delete', ['middleware' => ['role:privilege|delete'], 'as' => 'editor.privilege.delete', 'uses' => 'PrivilegeController@delete']);

	 //Employee Status
		//index
	Route::get('/employee-status', ['middleware' => ['role:employee-status|read'], 'as' => 'editor.employee-status.index', 'uses' => 'EmployeeStatusController@index']);
	Route::get('/employee-status/data', ['as' => 'editor.employee-status.data', 'uses' => 'EmployeeStatusController@data']);
		//create
	Route::get('/employee-status/create', ['middleware' => ['role:employee-status|create'], 'as' => 'editor.employee-status.create', 'uses' => 'EmployeeStatusController@create']);
	Route::post('/employee-status/create', ['middleware' => ['role:employee-status|create'], 'as' => 'editor.employee-status.store', 'uses' => 'EmployeeStatusController@store']);
		//edit
	Route::get('/employee-status/edit/{id}', ['middleware' => ['role:employee-status|update'], 'as' => 'editor.employee-status.edit', 'uses' => 'EmployeeStatusController@edit']);
	Route::put('/employee-status/edit/{id}', ['middleware' => ['role:employee-status|update'], 'as' => 'editor.employee-status.update', 'uses' => 'EmployeeStatusController@update']);
		//delete
	Route::delete('/employee-status/delete/{id}', ['middleware' => ['role:employee-status|delete'], 'as' => 'editor.employee-status.delete', 'uses' => 'EmployeeStatusController@delete']);
	Route::post('/employee-status/deletebulk', ['middleware' => ['role:employee-status|delete'], 'as' => 'editor.employee-status.deletebulk', 'uses' => 'EmployeeStatusController@deletebulk']);

	//Department
		//index
	Route::get('/department', ['as' => 'editor.department.index', 'uses' => 'DepartmentController@index']);
	Route::get('/department/data', ['as' => 'editor.department.data', 'uses' => 'DepartmentController@data']);
		//create
	Route::get('/department/create', ['as' => 'editor.department.create', 'uses' => 'DepartmentController@create']);
	Route::post('/department/create', ['as' => 'editor.department.store', 'uses' => 'DepartmentController@store']);
		//edit
	Route::get('/department/edit/{id}', ['as' => 'editor.department.edit', 'uses' => 'DepartmentController@edit']);
	Route::put('/department/edit/{id}', ['as' => 'editor.department.update', 'uses' => 'DepartmentController@update']);
		//delete
	Route::delete('/department/delete/{id}', ['as' => 'editor.department.delete', 'uses' => 'DepartmentController@delete']);
	Route::post('/department/deletebulk', ['as' => 'editor.department.deletebulk', 'uses' => 'DepartmentController@deletebulk']);

	//Position
		//index
	Route::get('/position', ['as' => 'editor.position.index', 'uses' => 'PositionController@index']);
	Route::get('/position/data', ['as' => 'editor.position.data', 'uses' => 'PositionController@data']);
		//create
	Route::get('/position/create', ['as' => 'editor.position.create', 'uses' => 'PositionController@create']);
	Route::post('/position/create', ['as' => 'editor.position.store', 'uses' => 'PositionController@store']);
		//edit
	Route::get('/position/edit/{id}', ['as' => 'editor.position.edit', 'uses' => 'PositionController@edit']);
	Route::put('/position/edit/{id}', ['as' => 'editor.position.update', 'uses' => 'PositionController@update']);
		//delete
	Route::delete('/position/delete/{id}', ['as' => 'editor.position.delete', 'uses' => 'PositionController@delete']);
	Route::post('/position/deletebulk', ['as' => 'editor.position.deletebulk', 'uses' => 'PositionController@deletebulk']);

	//Education Level
		//index
	Route::get('/education-level', ['as' => 'editor.education-level.index', 'uses' => 'EducationLevelController@index']);
	Route::get('/education-level/data', ['as' => 'editor.education-level.data', 'uses' => 'EducationLevelController@data']);
		//create
	Route::get('/education-level/create', ['as' => 'editor.education-level.create', 'uses' => 'EducationLevelController@create']);
	Route::post('/education-level/create', ['as' => 'editor.education-level.store', 'uses' => 'EducationLevelController@store']);
		//edit
	Route::get('/education-level/edit/{id}', ['as' => 'editor.education-level.edit', 'uses' => 'EducationLevelController@edit']);
	Route::put('/education-level/edit/{id}', ['as' => 'editor.education-level.update', 'uses' => 'EducationLevelController@update']);
		//delete
	Route::delete('/education-level/delete/{id}', ['as' => 'editor.education-level.delete', 'uses' => 'EducationLevelController@delete']);
	Route::post('/education-level/deletebulk', ['as' => 'editor.education-level.deletebulk', 'uses' => 'EducationLevelController@deletebulk']);

	//Education Major
		//index
	Route::get('/education-major', ['as' => 'editor.education-major.index', 'uses' => 'EducationMajorController@index']);
	Route::get('/education-major/data', ['as' => 'editor.education-major.data', 'uses' => 'EducationMajorController@data']);
		//create
	Route::get('/education-major/create', ['as' => 'editor.education-major.create', 'uses' => 'EducationMajorController@create']);
	Route::post('/education-major/create', ['as' => 'editor.education-major.store', 'uses' => 'EducationMajorController@store']);
		//edit
	Route::get('/education-major/edit/{id}', ['as' => 'editor.education-major.edit', 'uses' => 'EducationMajorController@edit']);
	Route::put('/education-major/edit/{id}', ['as' => 'editor.education-major.update', 'uses' => 'EducationMajorController@update']);
		//delete
	Route::delete('/education-major/delete/{id}', ['as' => 'editor.education-major.delete', 'uses' => 'EducationMajorController@delete']);
	Route::post('/education-major/deletebulk', ['as' => 'editor.education-major.deletebulk', 'uses' => 'EducationMajorController@deletebulk']);

	//Employee
		//index
	Route::get('/employee', ['as' => 'editor.employee.index', 'uses' => 'EmployeeController@index']);
	Route::get('/employee/data', ['as' => 'editor.employee.data', 'uses' => 'EmployeeController@data']);
		//create
	Route::get('/employee/create', ['as' => 'editor.employee.create', 'uses' => 'EmployeeController@create']);
	Route::post('/employee/create', ['as' => 'editor.employee.store', 'uses' => 'EmployeeController@store']);
		//edit
	Route::get('/employee/{id}/edit', ['as' => 'editor.employee.edit', 'uses' => 'EmployeeController@edit']);
	Route::put('/employee/{id}/edit', ['as' => 'editor.employee.update', 'uses' => 'EmployeeController@update']);
	Route::put('/employee/edit/{id}', ['as' => 'editor.employee.update', 'uses' => 'EmployeeController@update']);
		//view
	Route::get('/employee/{id}/view', ['as' => 'editor.employee.view', 'uses' => 'EmployeeController@view']);
		//delete
	Route::delete('/employee/delete/{id}', ['as' => 'editor.employee.delete', 'uses' => 'EmployeeController@delete']);
	Route::post('/employee/deletebulk', ['as' => 'editor.employee.deletebulk', 'uses' => 'EmployeeController@deletebulk']);
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
	Route::get('/training-provider', ['as' => 'editor.training-provider.index', 'uses' => 'TrainingProviderController@index']);
	Route::get('/training-provider/data', ['as' => 'editor.training-provider.data', 'uses' => 'TrainingProviderController@data']);
		//create
	Route::get('/training-provider/create', ['as' => 'editor.training-provider.create', 'uses' => 'TrainingProviderController@create']);
	Route::post('/training-provider/create', ['as' => 'editor.training-provider.store', 'uses' => 'TrainingProviderController@store']);
		//edit
	Route::get('/training-provider/edit/{id}', ['as' => 'editor.training-provider.edit', 'uses' => 'TrainingProviderController@edit']);
	Route::put('/training-provider/edit/{id}', ['as' => 'editor.training-provider.update', 'uses' => 'TrainingProviderController@update']);
		//delete
	Route::delete('/training-provider/delete/{id}', ['as' => 'editor.training-provider.delete', 'uses' => 'TrainingProviderController@delete']);
	Route::post('/training-provider/deletebulk', ['as' => 'editor.training-provider.deletebulk', 'uses' => 'TrainingProviderController@deletebulk']);

	//Absence Type
		//index
	Route::get('/absence-type', ['as' => 'editor.absence-type.index', 'uses' => 'AbsenceTypeController@index']);
	Route::get('/absence-type/data', ['as' => 'editor.absence-type.data', 'uses' => 'AbsenceTypeController@data']);
		//create
	Route::get('/absence-type/create', ['as' => 'editor.absence-type.create', 'uses' => 'AbsenceTypeController@create']);
	Route::post('/absence-type/create', ['as' => 'editor.absence-type.store', 'uses' => 'AbsenceTypeController@store']);
		//edit
	Route::get('/absence-type/edit/{id}', ['as' => 'editor.absence-type.edit', 'uses' => 'AbsenceTypeController@edit']);
	Route::put('/absence-type/edit/{id}', ['as' => 'editor.absence-type.update', 'uses' => 'AbsenceTypeController@update']);
		//delete
	Route::delete('/absence-type/delete/{id}', ['as' => 'editor.absence-type.delete', 'uses' => 'AbsenceTypeController@delete']);
	Route::post('/absence-type/deletebulk', ['as' => 'editor.absence-type.deletebulk', 'uses' => 'AbsenceTypeController@deletebulk']);


	//Overtime Type
		//index
	Route::get('/overtime-type', ['as' => 'editor.overtime-type.index', 'uses' => 'OvertimeTypeController@index']);
	Route::get('/overtime-type/data', ['as' => 'editor.overtime-type.data', 'uses' => 'OvertimeTypeController@data']);
		//create
	Route::get('/overtime-type/create', ['as' => 'editor.overtime-type.create', 'uses' => 'OvertimeTypeController@create']);
	Route::post('/overtime-type/create', ['as' => 'editor.overtime-type.store', 'uses' => 'OvertimeTypeController@store']);
		//edit
	Route::get('/overtime-type/edit/{id}', ['as' => 'editor.overtime-type.edit', 'uses' => 'OvertimeTypeController@edit']);
	Route::put('/overtime-type/edit/{id}', ['as' => 'editor.overtime-type.update', 'uses' => 'OvertimeTypeController@update']);
		//delete
	Route::delete('/overtime-type/delete/{id}', ['as' => 'editor.overtime-type.delete', 'uses' => 'OvertimeTypeController@delete']);
	Route::post('/overtime-type/deletebulk', ['as' => 'editor.overtime-type.deletebulk', 'uses' => 'OvertimeTypeController@deletebulk']);


	//Payroll Type
		//index
	Route::get('/payroll-type', ['as' => 'editor.payroll-type.index', 'uses' => 'PayrollTypeController@index']);
	Route::get('/payroll-type/data', ['as' => 'editor.payroll-type.data', 'uses' => 'PayrollTypeController@data']);
		//create
	Route::get('/payroll-type/create', ['as' => 'editor.payroll-type.create', 'uses' => 'PayrollTypeController@create']);
	Route::post('/payroll-type/create', ['as' => 'editor.payroll-type.store', 'uses' => 'PayrollTypeController@store']);
		//edit
	Route::get('/payroll-type/edit/{id}', ['as' => 'editor.payroll-type.edit', 'uses' => 'PayrollTypeController@edit']);
	Route::put('/payroll-type/edit/{id}', ['as' => 'editor.payroll-type.update', 'uses' => 'PayrollTypeController@update']);
		//delete
	Route::delete('/payroll-type/delete/{id}', ['as' => 'editor.payroll-type.delete', 'uses' => 'PayrollTypeController@delete']);
	Route::post('/payroll-type/deletebulk', ['as' => 'editor.payroll-type.deletebulk', 'uses' => 'PayrollTypeController@deletebulk']);


	//Loan Type
		//index
	Route::get('/loan-type', ['as' => 'editor.loan-type.index', 'uses' => 'LoanTypeController@index']);
	Route::get('/loan-type/data', ['as' => 'editor.loan-type.data', 'uses' => 'LoanTypeController@data']);
		//create
	Route::get('/loan-type/create', ['as' => 'editor.loan-type.create', 'uses' => 'LoanTypeController@create']);
	Route::post('/loan-type/create', ['as' => 'editor.loan-type.store', 'uses' => 'LoanTypeController@store']);
		//edit
	Route::get('/loan-type/edit/{id}', ['as' => 'editor.loan-type.edit', 'uses' => 'LoanTypeController@edit']);
	Route::put('/loan-type/edit/{id}', ['as' => 'editor.loan-type.update', 'uses' => 'LoanTypeController@update']);
		//delete
	Route::delete('/loan-type/delete/{id}', ['as' => 'editor.loan-type.delete', 'uses' => 'LoanTypeController@delete']);
	Route::post('/loan-type/deletebulk', ['as' => 'editor.loan-type.deletebulk', 'uses' => 'LoanTypeController@deletebulk']);

	//Tarif
		//index
	Route::get('/tarif', ['as' => 'editor.tarif.index', 'uses' => 'TarifController@index']);
	Route::get('/tarif/data', ['as' => 'editor.tarif.data', 'uses' => 'TarifController@data']);
		//create
	Route::get('/tarif/create', ['as' => 'editor.tarif.create', 'uses' => 'TarifController@create']);
	Route::post('/tarif/create', ['as' => 'editor.tarif.store', 'uses' => 'TarifController@store']);
		//edit
	Route::get('/tarif/edit/{id}', ['as' => 'editor.tarif.edit', 'uses' => 'TarifController@edit']);
	Route::put('/tarif/edit/{id}', ['as' => 'editor.tarif.update', 'uses' => 'TarifController@update']);
		//delete
	Route::delete('/tarif/delete/{id}', ['as' => 'editor.tarif.delete', 'uses' => 'TarifController@delete']);
	Route::post('/tarif/deletebulk', ['as' => 'editor.tarif.deletebulk', 'uses' => 'TarifController@deletebulk']);

	//Holiday
		//index
	Route::get('/holiday', ['as' => 'editor.holiday.index', 'uses' => 'HolidayController@index']);
	Route::get('/holiday/data', ['as' => 'editor.holiday.data', 'uses' => 'HolidayController@data']);
		//create
	Route::get('/holiday/create', ['as' => 'editor.holiday.create', 'uses' => 'HolidayController@create']);
	Route::post('/holiday/create', ['as' => 'editor.holiday.store', 'uses' => 'HolidayController@store']);
		//edit
	Route::get('/holiday/edit/{id}', ['as' => 'editor.holiday.edit', 'uses' => 'HolidayController@edit']);
	Route::put('/holiday/edit/{id}', ['as' => 'editor.holiday.update', 'uses' => 'HolidayController@update']);
		//delete
	Route::delete('/holiday/delete/{id}', ['as' => 'editor.holiday.delete', 'uses' => 'HolidayController@delete']);
	Route::post('/holiday/deletebulk', ['as' => 'editor.holiday.deletebulk', 'uses' => 'HolidayController@deletebulk']);

	//User filter
		//index
	Route::get('/userfilter', ['middleware' => ['role:userfilter|read'], 'as' => 'editor.userfilter.index', 'uses' => 'UserFilterController@index']);
	Route::get('/userfilter/data', ['as' => 'editor.userfilter.data', 'uses' => 'UserFilterController@data']);
		//create
	Route::get('/userfilter/create', ['middleware' => ['role:userfilter|create'], 'as' => 'editor.userfilter.create', 'uses' => 'UserFilterController@create']);
	Route::post('/userfilter/create', ['middleware' => ['role:userfilter|create'], 'as' => 'editor.userfilter.store', 'uses' => 'UserFilterController@store']);
		//edit
	Route::get('/userfilter/edit/{id}', ['middleware' => ['role:userfilter|update'], 'as' => 'editor.userfilter.edit', 'uses' => 'UserFilterController@edit']);
	Route::put('/userfilter/edit/{id}', ['middleware' => ['role:userfilter|update'], 'as' => 'editor.userfilter.update', 'uses' => 'UserFilterController@update']);
		//delete
	Route::delete('/userfilter/delete/{id}', ['middleware' => ['role:userfilter|delete'], 'as' => 'editor.userfilter.delete', 'uses' => 'UserFilterController@delete']);
	Route::post('/userfilter/deletebulk', ['middleware' => ['role:userfilter|delete'], 'as' => 'editor.userfilter.deletebulk', 'uses' => 'UserFilterController@deletebulk']);

	//Leave
		//index
	Route::get('/leave', ['as' => 'editor.leave.index', 'uses' => 'LeaveController@index']);
	Route::get('/leave/data', ['as' => 'editor.leave.data', 'uses' => 'LeaveController@data']);
	Route::get('/leave/datahistory', ['as' => 'editor.leave.datahistory', 'uses' => 'LeaveController@datahistory']);
		//create
	Route::get('/leave/create', ['as' => 'editor.leave.create', 'uses' => 'LeaveController@create']);
	Route::post('/leave/create', ['as' => 'editor.leave.store', 'uses' => 'LeaveController@store']);
		//edit
	Route::get('/leave/{id}/edit', ['as' => 'editor.leave.edit', 'uses' => 'LeaveController@edit']);
	Route::put('/leave/{id}/edit', ['as' => 'editor.leave.update', 'uses' => 'LeaveController@update']);
		//delete
	Route::delete('/leave/delete/{id}', ['as' => 'editor.leave.delete', 'uses' => 'LeaveController@delete']);
	Route::post('/leave/deletebulk', ['as' => 'editor.leave.deletebulk', 'uses' => 'LeaveController@deletebulk']);

	//Training
		//index
	Route::get('/training', ['as' => 'editor.training.index', 'uses' => 'TrainingController@index']);
	Route::get('/training/data', ['as' => 'editor.training.data', 'uses' => 'TrainingController@data']);
	Route::get('/training/datahistory', ['as' => 'editor.training.datahistory', 'uses' => 'TrainingController@datahistory']);
	Route::get('/training/dataparticipant/{id}', ['as' => 'editor.training.dataparticipant', 'uses' => 'TrainingController@dataparticipant']);
		//create
	Route::get('/training/create', ['as' => 'editor.training.create', 'uses' => 'TrainingController@create']);
	Route::post('/training/create', ['as' => 'editor.training.store', 'uses' => 'TrainingController@store']); 
		//edit
	Route::get('/training/{id}/edit', ['as' => 'editor.training.edit', 'uses' => 'TrainingController@edit']);
	Route::put('/training/{id}/edit', ['as' => 'editor.training.update', 'uses' => 'TrainingController@update']);
		//delete
	Route::delete('/training/delete/{id}', ['as' => 'editor.training.delete', 'uses' => 'TrainingController@delete']);
	Route::put('/training/cancel/{id}', ['as' => 'editor.training.cancel', 'uses' => 'TrainingController@cancel']);
		// save detail
	Route::put('/training/savedetail/{id}', ['as' => 'editor.training.savedetail', 'uses' => 'TrainingController@savedetail']);
	Route::delete('/training/deletedet/{id}', ['as' => 'editor.training.deletedet', 'uses' => 'TrainingController@deletedet']);

	//Punishment
		//index
	Route::get('/punishment', ['as' => 'editor.punishment.index', 'uses' => 'PunishmentController@index']);
	Route::get('/punishment/data', ['as' => 'editor.punishment.data', 'uses' => 'PunishmentController@data']); 
		//create
	Route::get('/punishment/create', ['as' => 'editor.punishment.create', 'uses' => 'PunishmentController@create']);
	Route::post('/punishment/create', ['as' => 'editor.punishment.store', 'uses' => 'PunishmentController@store']);
		//edit
	Route::get('/punishment/{id}/edit', ['as' => 'editor.punishment.edit', 'uses' => 'PunishmentController@edit']);
	Route::put('/punishment/{id}/edit', ['as' => 'editor.punishment.update', 'uses' => 'PunishmentController@update']);
		//delete
	Route::delete('/punishment/delete/{id}', ['as' => 'editor.punishment.delete', 'uses' => 'PunishmentController@delete']);
	Route::put('/punishment/cancel/{id}', ['as' => 'editor.punishment.cancel', 'uses' => 'PunishmentController@cancel']);

	//Reward
		//index
	Route::get('/reward', ['as' => 'editor.reward.index', 'uses' => 'RewardController@index']);
	Route::get('/reward/data', ['as' => 'editor.reward.data', 'uses' => 'RewardController@data']);
		//create
	Route::get('/reward/create', ['as' => 'editor.reward.create', 'uses' => 'RewardController@create']);
	Route::post('/reward/create', ['as' => 'editor.reward.store', 'uses' => 'RewardController@store']);
		//edit
	Route::get('/reward/{id}/edit', ['as' => 'editor.reward.edit', 'uses' => 'RewardController@edit']);
	Route::put('/reward/{id}/edit', ['as' => 'editor.reward.update', 'uses' => 'RewardController@update']);
		//delete
	Route::delete('/reward/delete/{id}', ['as' => 'editor.reward.delete', 'uses' => 'RewardController@delete']);
	Route::put('/reward/cancel/{id}', ['as' => 'editor.reward.cancel', 'uses' => 'RewardController@cancel']);

	//Document
		//index
	Route::get('/document', ['as' => 'editor.document.index', 'uses' => 'DocumentController@index']);
	Route::get('/document/data', ['as' => 'editor.document.data', 'uses' => 'DocumentController@data']);
		//create
	Route::get('/document/create', ['as' => 'editor.document.create', 'uses' => 'DocumentController@create']);
	Route::post('/document/create', ['as' => 'editor.document.store', 'uses' => 'DocumentController@store']);
		//edit
	Route::get('/document/{id}/edit', ['as' => 'editor.document.edit', 'uses' => 'DocumentController@edit']);
	Route::put('/document/{id}/edit', ['as' => 'editor.document.update', 'uses' => 'DocumentController@update']);
		//delete
	Route::delete('/document/delete/{id}', ['as' => 'editor.document.delete', 'uses' => 'DocumentController@delete']);
	Route::post('/document/deletebulk', ['as' => 'editor.document.deletebulk', 'uses' => 'DocumentController@deletebulk']);

	//Cash receive
		//index
	Route::get('/cash-receive', ['as' => 'editor.cash-receive.index', 'uses' => 'CashReceiveController@index']);
	Route::get('/cash-receive/data', ['as' => 'editor.cash-receive.data', 'uses' => 'CashReceiveController@data']);
		//slip
	Route::get('/cash-receive/slip/{id}', ['as' => 'editor.cash-receive.slip', 'uses' => 'CashReceiveController@slip']);
		//create
	Route::get('/cash-receive/create', ['as' => 'editor.cash-receive.create', 'uses' => 'CashReceiveController@create']);
	Route::post('/cash-receive/create', ['as' => 'editor.cash-receive.store', 'uses' => 'CashReceiveController@store']);
		//cancel
	Route::post('/cash-receive/cancel/{id}', ['as' => 'editor.cash-receive.cancel', 'uses' => 'CashReceiveController@cancel']); 
		//close
	Route::post('/cash-receive/close/{id}', ['as' => 'editor.cash-receive.close', 'uses' => 'CashReceiveController@close']); 	
		//detail
	Route::get('/cash-receive/detail/{id}', ['as' => 'editor.cash-receive.detail', 'uses' => 'CashReceiveController@detail']);
	Route::put('/cash-receive/saveheader/{id}', ['as' => 'editor.cash-receive.saveheader', 'uses' => 'CashReceiveController@saveheader']);
	Route::put('/cash-receive/savedetail/{id}', ['as' => 'editor.cash-receive.savedetail', 'uses' => 'CashReceiveController@savedetail']);
	Route::post('/cash-receive/updatedetail/{id}', ['as' => 'editor.cash-receive.updatedetail', 'uses' => 'CashReceiveController@updatedetail']);
	Route::put('/cash-receive/detail/{id}', ['as' => 'editor.cash-receive.update', 'uses' => 'CashReceiveController@update']);
		//delete
	Route::delete('/cash-receive/deletedet/{id}', ['as' => 'editor.cash-receive.deletedet', 'uses' => 'CashReceiveController@deletedet']); 
		// detailitem 
	Route::get('/cash-receive/datadetail/{id}', ['as' => 'editor.cash-receive.datadetail', 'uses' => 'CashReceiveController@datadetail']); 


	//Cash payment
	//index
	Route::get('/cash-payment', ['as' => 'editor.cash-payment.index', 'uses' => 'CashPaymentController@index']);
	Route::get('/cash-payment/data', ['as' => 'editor.cash-payment.data', 'uses' => 'CashPaymentController@data']);
	//slip
	Route::get('/cash-payment/slip/{id}', ['as' => 'editor.cash-payment.slip', 'uses' => 'CashPaymentController@slip']);
	//create
	Route::get('/cash-payment/create', ['as' => 'editor.cash-payment.create', 'uses' => 'CashPaymentController@create']);
	Route::post('/cash-payment/create', ['as' => 'editor.cash-payment.store', 'uses' => 'CashPaymentController@store']);
	//cancel
	Route::post('/cash-payment/cancel/{id}', ['as' => 'editor.cash-payment.cancel', 'uses' => 'CashPaymentController@cancel']); 
	//close
	Route::post('/cash-payment/close/{id}', ['as' => 'editor.cash-payment.close', 'uses' => 'CashPaymentController@close']); 	
	//detail
	Route::get('/cash-payment/detail/{id}', ['as' => 'editor.cash-payment.detail', 'uses' => 'CashPaymentController@detail']);
	Route::put('/cash-payment/saveheader/{id}', ['as' => 'editor.cash-payment.saveheader', 'uses' => 'CashPaymentController@saveheader']);
	Route::put('/cash-payment/savedetail/{id}', ['as' => 'editor.cash-payment.savedetail', 'uses' => 'CashPaymentController@savedetail']);
	Route::post('/cash-payment/updatedetail/{id}', ['as' => 'editor.cash-payment.updatedetail', 'uses' => 'CashPaymentController@updatedetail']);
	Route::put('/cash-payment/detail/{id}', ['as' => 'editor.cash-payment.update', 'uses' => 'CashPaymentController@update']);
		//delete
	Route::delete('/cash-payment/deletedet/{id}', ['as' => 'editor.cash-payment.deletedet', 'uses' => 'CashPaymentController@deletedet']); 
	// detailitem 
	Route::get('/cash-payment/datadetail/{id}', ['as' => 'editor.cash-payment.datadetail', 'uses' => 'CashPaymentController@datadetail']); 

	//report ledger
	Route::get('/report-ledger', ['as' => 'editor.report-ledger.index', 'uses' => 'ReportLedgerController@index']);
	Route::get('/report-ledger/print/{id1}/{id2}/{id3}/{id4}', ['as' => 'editor.report-ledger.print', 'uses' => 'ReportLedgerController@report_print']);

	//Reimburse
		//index
	Route::get('/reimburse', ['as' => 'editor.reimburse.index', 'uses' => 'ReimburseController@index']);
	Route::get('/reimburse/data', ['as' => 'editor.reimburse.data', 'uses' => 'ReimburseController@data']);
		//create
	Route::get('/reimburse/create', ['as' => 'editor.reimburse.create', 'uses' => 'ReimburseController@create']);
	Route::post('/reimburse/create', ['as' => 'editor.reimburse.store', 'uses' => 'ReimburseController@store']);
		//detail
	Route::get('/reimburse/detail/{id}', ['as' => 'editor.reimburse.detail', 'uses' => 'ReimburseController@detail']);
	Route::get('/reimburse/slip/{id}', ['as' => 'editor.reimburse.slip', 'uses' => 'ReimburseController@slip']);
	Route::put('/reimburse/saveheader/{id}', ['as' => 'editor.reimburse.saveheader', 'uses' => 'ReimburseController@saveheader']);
	Route::put('/reimburse/savedetail/{id}', ['as' => 'editor.reimburse.savedetail', 'uses' => 'ReimburseController@savedetail']);
	Route::put('/reimburse/detail/{id}', ['as' => 'editor.reimburse.update', 'uses' => 'ReimburseController@update']);
		//delete
	Route::delete('/reimburse/deletedet/{id}', ['as' => 'editor.reimburse.deletedet', 'uses' => 'ReimburseController@deletedet']);
	Route::post('/reimburse/deletebulk', ['as' => 'editor.reimburse.deletebulk', 'uses' => 'ReimburseController@deletebulk']);
		// detail item 
	Route::get('/reimburse/datadetail/{id}', ['as' => 'editor.reimburse.datadetail', 'uses' => 'ReimburseController@datadetail']);
		//generate
	Route::get('/reimburse/generate/{id}', ['as' => 'editor.reimburse.generate', 'uses' => 'ReimburseController@generate']);
	Route::post('/reimburse/generate/{id}', ['as' => 'editor.reimburse.generate', 'uses' => 'ReimburseController@generate']);


	//ReimburseApproval
		//index
	Route::get('/reimburse-approval', ['as' => 'editor.reimburse-approval.index', 'uses' => 'ReimburseApprovalController@index']);
	Route::get('/reimburse-approval/data', ['as' => 'editor.reimburse-approval.data', 'uses' => 'ReimburseApprovalController@data']);
		//create
	Route::get('/reimburse-approval/create', ['as' => 'editor.reimburse-approval.create', 'uses' => 'ReimburseApprovalController@create']);
	Route::post('/reimburse-approval/create', ['as' => 'editor.reimburse-approval.store', 'uses' => 'ReimburseApprovalController@store']);
		//detail
	Route::get('/reimburse-approval/detail/{id}', ['as' => 'editor.reimburse-approval.detail', 'uses' => 'ReimburseApprovalController@detail']);
	Route::get('/reimburse-approval/slip/{id}', ['as' => 'editor.reimburse-approval.slip', 'uses' => 'ReimburseApprovalController@slip']); 
	Route::put('/reimburse-approval/detail/{id}', ['as' => 'editor.reimburse-approval.update', 'uses' => 'ReimburseApprovalController@update']); 

	//Time
	//index
	Route::get('/time', ['as' => 'editor.time.index', 'uses' => 'TimeController@index']);
	Route::get('/time/data', ['as' => 'editor.time.data', 'uses' => 'TimeController@data']);
	Route::get('/time/datadetail/{id}', ['as' => 'editor.time.datadetail', 'uses' => 'TimeController@datadetail']);
	//create
	Route::get('/time/create/{id}', ['as' => 'editor.time.create', 'uses' => 'TimeController@create']);
	Route::post('/time/create/{id}', ['as' => 'editor.time.store', 'uses' => 'TimeController@store']);
	//edit
	Route::get('/time/{id}/{id2}/edit', ['as' => 'editor.time.edit', 'uses' => 'TimeController@edit']);
	Route::put('/time/{id}/edit', ['as' => 'editor.time.update', 'uses' => 'TimeController@update']);
	Route::get('/time/datadetail', ['as' => 'editor.time.datadetail', 'uses' => 'TimeController@datadetail']); 
	//generate
	Route::get('/time/generate/{id}', ['as' => 'editor.time.generate', 'uses' => 'TimeController@generate']);
	Route::post('/time/generate/{id}', ['as' => 'editor.time.generate', 'uses' => 'TimeController@generate']);
	Route::post('/time/generateshiftschedule/{id}', ['as' => 'editor.time.generateshiftschedule', 'uses' => 'TimeController@generateshiftschedule']);


	//Payroll
		//index
	Route::get('/payroll', ['as' => 'editor.payroll.index', 'uses' => 'PayrollController@index']);
	Route::get('/payroll/data', ['as' => 'editor.payroll.data', 'uses' => 'PayrollController@data']);
		//create
	Route::get('/payroll/create/{id}', ['as' => 'editor.payroll.create', 'uses' => 'PayrollController@create']);
	Route::post('/payroll/create/{id}', ['as' => 'editor.payroll.store', 'uses' => 'PayrollController@store']);
		//edit
	Route::get('/payroll/{id}/edit', ['as' => 'editor.payroll.edit', 'uses' => 'PayrollController@edit']);
	Route::put('/payroll/{id}/edit', ['as' => 'editor.payroll.update', 'uses' => 'PayrollController@update']);
		//generate
	Route::get('/payroll/generate/{id}', ['as' => 'editor.payroll.generate', 'uses' => 'PayrollController@generate']);
	Route::post('/payroll/generate/{id}', ['as' => 'editor.payroll.generate', 'uses' => 'PayrollController@generate']);
		//slip
	Route::get('/payroll/slip/{id}', ['as' => 'slipor.payroll.slip', 'uses' => 'PayrollController@slip']);
		//history
	Route::get('/payroll/dataabsence', ['as' => 'editor.payroll.dataabsence', 'uses' => 'PayrollController@dataabsence']);
	Route::post('/payroll/storeabsence', ['as' => 'editor.payrollabsence.store', 'uses' => 'PayrollController@storeabsence']);

	//Faq
		//index
	Route::get('/faq', ['middleware' => ['role:faq|read'], 'as' => 'editor.faq.index', 'uses' => 'FaqController@index']);
	Route::get('/faq/data', ['as' => 'editor.faq.data', 'uses' => 'FaqController@data']);
		//create
	Route::get('/faq/create', ['middleware' => ['role:faq|create'], 'as' => 'editor.faq.create', 'uses' => 'FaqController@create']);
	Route::post('/faq/create', ['middleware' => ['role:faq|create'], 'as' => 'editor.faq.store', 'uses' => 'FaqController@store']);
		//edit
	Route::get('/faq/edit/{id}', ['middleware' => ['role:faq|update'], 'as' => 'editor.faq.edit', 'uses' => 'FaqController@edit']);
	Route::put('/faq/edit/{id}', ['middleware' => ['role:faq|update'], 'as' => 'editor.faq.update', 'uses' => 'FaqController@update']);
		//delete
	Route::delete('/faq/delete/{id}', ['middleware' => ['role:faq|delete'], 'as' => 'editor.faq.delete', 'uses' => 'FaqController@delete']);
	Route::post('/faq/deletebulk', ['middleware' => ['role:faq|delete'], 'as' => 'editor.faq.deletebulk', 'uses' => 'FaqController@deletebulk']);


	//Popup
		//index
	Route::get('/popup', ['middleware' => ['role:popup|read'], 'as' => 'editor.popup.index', 'uses' => 'PopupController@index']);
		//edit
	Route::get('/popup/edit/{id}', ['middleware' => ['role:popup|update'], 'as' => 'editor.popup.edit', 'uses' => 'PopupController@edit']);
	Route::put('/popup/edit/{id}', ['middleware' => ['role:popup|update'], 'as' => 'editor.popup.update', 'uses' => 'PopupController@update']);
	//userlog
	Route::get('/userlog', ['as' => 'editor.userlog.index', 'uses' => 'UserLogController@index']);

});



//api
Route::group(['prefix' => 'api', 'middleware' => 'auth', 'namespace' => 'Editor'], function(){
	Route::get('/user', ['middleware' => ['role:user|read'], 'as' => 'api.user.data', 'uses' => 'UserFilterController@dataUser']);
	Route::get('/privilege', ['middleware' => ['role:privilege|read'], 'as' => 'api.privilege.data', 'uses' => 'PrivilegeController@data']);
	Route::get('/userbranch', ['middleware' => ['role:userbranch|read'], 'as' => 'editor.userbranch.data', 'uses' => 'UserbranchController@data']);
	Route::get('/module', ['middleware' => ['role:module|read'], 'as' => 'editor.module.data', 'uses' => 'ModuleController@data']);
	Route::get('/action', ['middleware' => ['role:action|read'], 'as' => 'editor.action.data', 'uses' => 'ActionController@data']);
	//Popup
	Route::get('/popup', ['middleware' => ['role:action|read'], 'as' => 'editor.popup.data', 'uses' => 'PopupController@data']);
	Route::get('/check/popup', ['as' => 'editor.popup.checkpopup', 'uses' => 'PopupController@checkPopUp']);

	//userlog
	Route::get('/userlog', [ 'as' => 'editor.userlog.dataApi', 'uses' => 'UserLogController@dataApi']);
});
