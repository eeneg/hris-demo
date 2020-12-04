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

// Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResources([
        'user' => 'API\UserController',
        'personalinformation' => 'API\PersonalInformationController',
        'barcode' => 'API\BarcodeController',
        'plantilla' => 'API\PlantillaController',
        'salaryschedule' => 'API\SalaryScheduleController',
        'salarygrade' => 'API\SalaryGradeController',
        'setting' => 'API\SettingsController',
        'department' => 'API\DepartmentController',
        'plantillacontent' => 'API\PlantillaContentController'
    ]);
    Route::get('profile', 'Api\UserController@profile');
    Route::put('profile', 'Api\UserController@updateProfile');

    Route::post('verifybarcode', 'Api\BarcodeController@verify');

    Route::post('salaryschedule', 'Api\SalaryScheduleController@store');
    Route::patch('salaryschedule', 'Api\SalaryScheduleController@update');

    Route::post('salarygrade', 'API\SalaryGradeController@store');
    Route::patch('salarygrade', 'API\SalaryGradeController@update');

    Route::post('plantilladepartmentcontent', 'API\PlantillaContentController@plantilladepartmentcontent');
    Route::get('forvacants', 'API\PersonalInformationController@forvacants');
// });

//api test
// Route::get('per', 'API\PersonalInformationController@index');
// Route::get('salary', 'API\SalaryGradeController@index');
// Route::get('salarygrade', 'API\SalaryScheduleController@index');



