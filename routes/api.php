<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResources([
        'user' => 'Api\UserController',
        'personalinformation' => 'Api\PersonalInformationController',
        'barcode' => 'Api\BarcodeController',
        'plantilla' => 'Api\PlantillaController',
        'salaryschedule' => 'Api\SalaryScheduleController',
        'salarygrade' => 'Api\SalaryGradeController',
        'setting' => 'Api\SettingsController',
        'department' => 'Api\DepartmentController',
        'appointment' => 'Api\AppointmentController',
        'plantillacontent' => 'Api\PlantillaContentController',
        'abolisheditem' => 'Api\AbolishedItemController',
        'footnote' => 'Api\FootnoteController',
        'leavetype' => 'Api\LeaveTypeController',
        'leaveapplication' => 'Api\LeaveApplicationController',
        'request' => 'Api\RequestController',
        'reappointments' => 'Api\ReappointmentController',
        'leavecredits' => 'Api\LeaveCreditController',
        'dashboard' => 'Api\DashboardController',
        'position' => 'Api\PositionController',
        'status' => 'Api\StatusController',
        'leaveReport' => 'Api\LeaveReportController',
    ]);
    Route::post('department_positions', 'Api\PositionController@get_department_positions');

    Route::get('profile', 'Api\UserController@profile');
    Route::put('profile', 'Api\UserController@updateProfile');
    Route::get('employeeList', 'Api\PersonalInformationController@employees');

    Route::post('verifybarcode', 'Api\BarcodeController@verify');

    Route::post('salaryschedule', 'Api\SalaryScheduleController@store');
    Route::patch('salaryschedule', 'Api\SalaryScheduleController@update');

    Route::post('salarygrade', 'Api\SalaryGradeController@store');
    Route::patch('salarygrade', 'Api\SalaryGradeController@update');
    Route::post('deleteSalaryGrade', 'Api\SalaryGradeController@deleteSalaryGrade');

    Route::put('plantillacontentabolish', 'Api\PlantillaContentController@plantillacontentabolish');
    Route::post('plantilladepartmentcontent', 'Api\PlantillaContentController@plantilladepartmentcontent');
    Route::get('plantillaForNosi', 'Api\PlantillaContentController@plantillaForNosi');
    Route::get('plantillaForNosa', 'Api\PlantillaContentController@plantillaForNosa');
    Route::get('plantillaForOtherReports', 'Api\PlantillaContentController@plantillaForOtherReports');

    Route::post('previousplantilla', 'Api\PlantillaController@previousplantilla');
    Route::post('duplicateplantilla', 'Api\PlantillaController@duplicateplantilla');

    Route::post('forvacants', 'Api\PersonalInformationController@forvacants');
    Route::post('forleave', 'Api\PersonalInformationController@forleave');
    Route::get('edit', 'Api\PersonalInformationController@edit');
    Route::patch('personalinformation', 'Api\PersonalInformationController@update');

    Route::post('footnotespec', 'Api\FootnoteController@getfootnote');

    Route::get('fetchDepartments', 'Api\AppointmentController@fetchDepartments');
    Route::get('fetchSalarySched', 'Api\AppointmentController@fetchSalarySched');

    Route::get('getleavetypes', 'Api\LeaveTypeController@getleavetypes');
    Route::post('editLeaveApplication/{id}', 'Api\LeaveApplicationController@edit');
    Route::get('load_user', 'Api\LeaveApplicationController@loadUserRole');
    Route::get('getAllLeave', 'Api\LeaveApplicationController@getAllLeave');
    Route::post('searchLeave', 'Api\LeaveApplicationController@searchLeave');
    Route::get('getLeaveBalance', 'Api\LeaveApplicationController@getLeaveBalance');

    Route::post('acceptEditRequest', 'Api\RequestController@acceptEditRequest');
    Route::post('revertRequest', 'Api\RequestController@revertRequest');
    Route::get('reviewedRequest', 'Api\RequestController@reviewedRequest');

    Route::get('getleavesummary', 'Api\LeaveCreditController@getLeaveSummary');
    Route::post('editleavesummary', 'Api\LeaveCreditController@editleavesummary');
    Route::post('slp_fl_leave', 'Api\LeaveCreditController@slp_fl_leave');

    Route::post('checkChanges', 'Api\LeaveApplicationController@checkChanges');

    Route::get('complete_depts', 'Api\DepartmentController@complete_depts');
    Route::get('fetch_depts', 'Api\DepartmentController@fetch_depts');
    Route::get('fetch_positions', 'Api\DepartmentController@fetch_positions');
    Route::post('store_position', 'Api\DepartmentController@store_position');
    Route::patch('update_position/{id}', 'Api\DepartmentController@update_position');
    Route::delete('delete_position/{id}', 'Api\DepartmentController@delete_position');

    Route::patch('editPersonalInfo', 'Api\PersonalInformationController@editPersonalInfo');

    Route::post('foreignTravel', 'Api\LeaveReportController@generateForeignTravelReport');

    Route::resource('audits', 'Api\AuditController')->only('index', 'show');
});

Route::group(['middleware' => ['auth:employee-api']], function () {
    Route::apiResources([
        'employeepersonalinformation' => 'Api\EmployeeController',
    ]);
    Route::get('getLeaveApplications', 'Api\EmployeeController@getApplications');
    Route::get('getLeaveTypesForEmployee', 'Api\EmployeeController@getLeaveTypesForEmployee');
    Route::post('submitLeaveApplication', 'Api\EmployeeController@submitLeaveApplication');
    Route::delete('deleteLeaveApplication/{id}', 'Api\EmployeeController@deleteLeaveApplication');
    Route::patch('editLeaveApplication/{id}', 'Api\EmployeeController@editLeaveApplication');
    Route::post('getLeaveApplication', 'Api\EmployeeController@getLeaveApplication');
    Route::get('editemployee', 'Api\EmployeeController@edit');
    Route::get('getpdsEdits', 'Api\EmployeeController@getpdsEdits');
    Route::post('cancelEdits', 'Api\EmployeeController@cancelEdits');
});

Route::get('asd1', 'Api\RequestController@reviewedRequest');
Route::get('asd', 'Api\RequestController@index');
