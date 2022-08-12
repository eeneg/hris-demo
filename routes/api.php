<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api']], function() {
    Route::apiResources([
        'user' => 'API\UserController',
        'personalinformation' => 'API\PersonalInformationController',
        'barcode' => 'API\BarcodeController',
        'plantilla' => 'API\PlantillaController',
        'salaryschedule' => 'API\SalaryScheduleController',
        'salarygrade' => 'API\SalaryGradeController',
        'setting' => 'API\SettingsController',
        'department' => 'API\DepartmentController',
        'appointment' => 'API\AppointmentController',
        'plantillacontent' => 'API\PlantillaContentController',
        'abolisheditem' => 'API\AbolishedItemController',
        'footnote' => 'API\FootnoteController',
        'leavetype' => 'API\LeaveTypeController',
        'leaveapplication' => 'API\LeaveApplicationController',
        'request'   => 'API\RequestController',
        'reappointments'   => 'API\ReappointmentController',
        'leavecredits'  => 'API\LeaveCreditController'
    ]);
    Route::get('profile', 'Api\UserController@profile');
    Route::put('profile', 'Api\UserController@updateProfile');
    Route::get('employeeList', 'API\PersonalInformationController@employees');

    Route::post('verifybarcode', 'Api\BarcodeController@verify');

    Route::post('salaryschedule', 'Api\SalaryScheduleController@store');
    Route::patch('salaryschedule', 'Api\SalaryScheduleController@update');

    Route::post('salarygrade', 'API\SalaryGradeController@store');
    Route::patch('salarygrade', 'API\SalaryGradeController@update');
    Route::post('deleteSalaryGrade', 'API\SalaryGradeController@deleteSalaryGrade');

    Route::put('plantillacontentabolish', 'Api\PlantillaContentController@plantillacontentabolish');
    Route::post('plantilladepartmentcontent', 'API\PlantillaContentController@plantilladepartmentcontent');

    Route::post('previousplantilla', 'API\PlantillaController@previousplantilla');

    Route::post('forvacants', 'API\PersonalInformationController@forvacants');
    Route::post('forleave', 'API\PersonalInformationController@forleave');
    Route::get('edit', 'API\PersonalInformationController@edit');
    Route::patch('personalinformation', 'API\PersonalInformationController@update');

    Route::post('footnotespec', 'API\FootnoteController@getfootnote');

    Route::get('fetchDepartments', 'API\AppointmentController@fetchDepartments');
    Route::get('fetchSalarySched', 'API\AppointmentController@fetchSalarySched');

    Route::get('getleavetypes', 'API\LeaveTypeController@getleavetypes');
    Route::get('editLeaveApplication', 'API\LeaveApplicationController@edit');
    Route::get('load_user', 'API\LeaveApplicationController@loadUserRole');
    Route::get('getAllLeave', 'API\LeaveApplicationController@getAllLeave');
    Route::post('searchLeave', 'API\LeaveApplicationController@searchLeave');

    Route::post('acceptEditRequest', 'API\RequestController@acceptEditRequest');
    Route::post('revertRequest', 'API\RequestController@revertRequest');
    Route::get('reviewedRequest', 'API\RequestController@reviewedRequest');

    Route::get('getleavesummary', 'API\LeaveCreditController@getLeaveSummary');
    Route::post('editleavesummary', 'API\LeaveCreditController@editleavesummary');
    Route::post('slp_fl_leave', 'API\LeaveCreditController@slp_fl_leave');

    Route::post('checkChanges', 'API\LeaveApplicationController@checkChanges');

    Route::get('fetch_depts', 'API\DepartmentController@fetch_depts');
    Route::get('fetch_positions', 'API\DepartmentController@fetch_positions');
    Route::post('store_position', 'API\DepartmentController@store_position');
    Route::patch('update_position/{id}', 'API\DepartmentController@update_position');
    Route::delete('delete_position/{id}', 'API\DepartmentController@delete_position');
});

Route::group(['middleware' => ['auth:employee-api']], function() {
    Route::apiResources([
        'employeepersonalinformation' => 'API\EmployeeController',
    ]);

    Route::get('editemployee', 'API\EmployeeController@edit');
    Route::get('getpdsEdits', 'API\EmployeeController@getpdsEdits');
    Route::post('cancelEdits', 'API\EmployeeController@cancelEdits');
});

Route::get('asd1', 'API\RequestController@reviewedRequest');
Route::get('asd', 'API\RequestController@index');








