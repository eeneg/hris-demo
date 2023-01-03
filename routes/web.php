<?php

use App\LeaveReport;
use App\LeaveSummary;
use App\PersonalInformation;
use Carbon\Carbon;
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

Route::post('/generatePlantilla', 'PDFcontroller@plantilla');

Route::post('/generateNOSI', 'PDFcontroller@nosi');

Route::post('/generateNOSA', 'PDFcontroller@nosa');

Route::post('/generateSR', 'PDFcontroller@sr');

Route::any('/generateSalarySched', 'PDFcontroller@generatesalarysched');


Route::get('{path}', 'HomeController@index')->where( 'path','([-a-z0-9_\s]+)' );


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

class asd{

}

Route::get('/asd/asd', function() {

    $request = new asd;
    $request->year = 2022;
    $request->month = '02';
    $request->prep = [['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II']];
    $request->noted = ['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II'];

    $ar = [];

    $i = LeaveSummary::
                where(function ($query) {
                    $query->orWhere('particulars->leave_type', 'Tardy')
                    ->orWhere('particulars->leave_type', 'Undertime')
                    ->orWhere('particulars->leave_type', 'UA');
                })->where('particulars->count', '<', 10)
                ->get()
                ->filter(function($e) use ($request) {

                    switch($e->period->mode){
                        case 1:
                        case 4:
                            return  Carbon::parse($e->period->data)->format('Y') == $request->year &&
                                    Carbon::parse($e->period->data)->format('m') == $request->month;
                            break;
                        case 2:
                            return  Carbon::parse($e->period->data->start)->format('Y') == $request->year &&
                                    Carbon::parse($e->period->data->start)->format('m') == $request->month;
                            break;
                        case 3:
                            break;
                    }

                })
                ->map( function($e){

                    $employee = PersonalInformation::find($e->personal_information_id);
                    $office = $employee->plantillacontents->first();

                    switch($e->period->mode)
                    {
                        case 1:
                        case 4:
                            $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                            $date = $e->period->data;
                            break;
                        case 2:
                            $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                            $date = $e->period->data->start;
                            break;
                        case 3:
                            break;
                    }

                    return[
                        'employee'  => $employee->firstname . ' ' . $employee->surname,
                        'month' => Carbon::parse($date)->format('m'),
                        'type' => $e->particulars->leave_type,
                        'mins' => $mins,
                        'count' => $e->particulars->count,
                        'office' => '$office'
                    ];

                });

                foreach($i as $data)
                {
                    $ar[$data['employee']][$data['type']] = ['mins' => $data['mins'], 'count' => $data['count'], 'office' => $data['office']];
                }

    $d = ['month' => $request->month, 'year' => $request->year, 'records' => $ar, 'prep' => $request->prep, 'noted' => $request->noted];

    return view('reports.leave_report', compact('d'));
});
