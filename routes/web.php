<?php

use App\LeaveSummary;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'employee'], function () {
    Route::get('/login/step-one', 'Auth\EmployeeLoginController@employeelogin')->name('step-one');
    Route::post('/login/step-one/post', 'Auth\EmployeeLoginController@authenticateEmployeeLogin')->name('employee_login');

    Route::get('/login/step-two', 'Auth\EmployeeLoginController@employeeloginbarcode')->name('step-two');
    Route::post('/login/step-two/post', 'Auth\EmployeeLoginController@authenticateEmployeeLoginBarcode')->name('employee_login_barcode');
});

Auth::routes(['register' => false]);

Route::post('/generateId', 'PDFcontroller@employeeId');

Route::post('/generatePDS', 'PDFcontroller@pds');

Route::post('/generateleavecard', 'PDFcontroller@generateleavecard');

Route::post('/generateleavecardByDept', 'PDFcontroller@generateleavecardByDept');

Route::post('/generatePlantilla', 'PDFcontroller@plantilla');

Route::get('/generatePlantillaExcel', 'PDFcontroller@plantillaExcel');

Route::post('/generateNOSI', 'PDFcontroller@nosi');

Route::post('/generateNOSA', 'PDFcontroller@nosa');

Route::post('/generateSR', 'PDFcontroller@sr');

Route::any('/generateSalarySched', 'PDFcontroller@generatesalarysched');

Route::get('{path}', 'HomeController@index')->where('path', '([-a-z0-9_\s]+)');

// Route::get('/workExpFormat', 'Helpers@workExperienceFormat');
// Route::get('/volWorkFormat', 'Helpers@voluntaryWorksFormat');
// Route::get('/trainingFormat', 'Helpers@trainingFormat');
// Route::get('/makePlantilla', 'Helpers@makePlantilla');
Route::get('/initializeSystem', 'Helpers@initialize');
// Route::get('/post/post', 'Helpers@positions');
// Route::get('/updateIds', 'Helpers@updateIds');
// Route::get('/updateSalaryGrades', 'Helpers@updateSalaryGrades');

Route::get('/asd/generateleavecard', 'PDFcontroller@generateleavecard');

Route::get('/dsa/{id}', 'API\SalaryGradeController@index');


Route::get('/displayLeaveApplication/{id}', 'Api\LeaveApplicationController@show');

Route::get('/leave/CC', 'Api\LeaveCreditController@leaveCC');
