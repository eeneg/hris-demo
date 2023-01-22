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

Route::post('/generatePlantilla', 'PDFcontroller@plantilla');

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

class asd
{
}

Route::get('/a/a', function () {
    $month = Carbon::parse('December')->format('F');

    return LeaveSummary::where('foreign_travel', 1)->get()
        ->filter(function ($leave) use ($month) {
            switch($leave->period->mode) {
                case 1:
                case 4:
                    $date = Carbon::parse($leave->period->data)->format('F') == $month;
                    if ($date) {
                        return $leave;
                    }
                    break;
                case 2:
                    $start = Carbon::parse($leave->period->start)->format('F');
                    $end = Carbon::parse($leave->period->end)->format('F');
                    if ($start == $month || $end == $month) {
                        return $leave;
                    }
                    break;
                case 3:
                    foreach ($leave->period->data as $dates) {
                        if (Carbon::parse($dates->date)->format('F') == $month) {
                            return $leave;
                            break;
                        }
                    }
            }
        })
        ->map(function ($leave) {
            $employee = DB::table('personal_informations')->where('id', $leave->personal_information_id)->first();
            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            $plantillacontents = PlantillaContent::where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where('personal_information_id', $leave->personal_information_id)
                ->first();

            switch($leave->period->mode) {
                case 1:
                    $date = Carbon::parse($leave->period->data)->format('F d, Y');
                    $leave_info = $leave->particulars->days;
                    break;
                case 2:
                    $date = Carbon::parse($leave->period->start)->format('F d, Y').' to '.Carbon::parse($leave->period->end)->format('F d, Y');
                    $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                    break;
                case 3:
                    $date = collect($leave->period->data)
                    ->sort()
                    ->map(function ($dates) {
                        return [
                            'month' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('F'),
                            'day' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('d'),
                            'year' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('Y'),
                        ];
                    })
                    ->groupBy('month')
                    ->map(function ($dates, $index) {
                        return $index.' '.collect($dates)->map(fn ($e) => $e['day'])->join(', ').', '.$dates[0]['year'];
                    });
                    $date = collect($date)->join(' — ');
                    $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                    break;
                case 4:
                    $date = Carbon::parse($leave->period->data)->format('F d, Y');
                    $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                    break;
            }

            return  collect([
                'name' => $employee->firstname.' '.ucfirst($employee->middlename[0] ?? '').'. '.$employee->surname,
                'office' => $plantillacontents->position->department->title ?? '',
                'leave_type' => $leave->particulars->leave_type,
                'inclusive_dates' => $date,
                'days' => $leave_info,
            ]);
        });
});

Route::get('/asd/asd', function () {
    $request = new asd;
    $request->year = 2022;
    $request->month = '02';
    $request->prep = [
        ['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II'],
        ['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II'],
        ['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II'],
    ];
    $request->noted = ['name' => 'Gene Rellanos', 'position' => 'Assessment Clerk II'];

    $ar = [];

    $i = LeaveSummary::where(function ($query) {
                    $query->orWhere('particulars->leave_type', 'Tardy')
                    ->orWhere('particulars->leave_type', 'Undertime')
                    ->orWhere('particulars->leave_type', 'UA');
                })->where('particulars->count', '<', 10)
                ->get()
                ->filter(function ($e) use ($request) {
                    switch($e->period->mode) {
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
                ->map(function ($e) {
                    $employee = PersonalInformation::find($e->personal_information_id);
                    $office = $employee->plantillacontents->first();

                    switch($e->period->mode) {
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
                        'employee' => $employee->firstname.' '.$employee->surname,
                        'month' => Carbon::parse($date)->format('m'),
                        'type' => $e->particulars->leave_type,
                        'mins' => $mins,
                        'count' => $e->particulars->count,
                        'office' => '$office',
                    ];
                });

    foreach ($i as $data) {
        $ar[$data['employee']][$data['type']] = ['mins' => $data['mins'], 'count' => $data['count'], 'office' => $data['office']];
    }

    $d = ['month' => $request->month, 'year' => $request->year, 'records' => $ar, 'prep' => $request->prep, 'noted' => $request->noted];

    return view('reports.leave_report', compact('d'));
});
