<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Plantilla;
use App\PlantillaContent;
use App\PlantillaDept;
use App\SalaryGrade;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plantilla::orderBy('created_at', 'desc')->get();
    }

    public function previousplantilla(Request $request)
    {
        return Plantilla::where('year', '!=', $request->current)->latest('created_at')->first();
    }

    public function duplicateplantilla(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');
        $this->validate($request, [
            'year' => 'unique:plantillas',
        ]);
        $newplantilla = Plantilla::create([
            'year' => $request['year'],
            'salary_schedule_auth_id' => $request['salary_auth'],
            'salary_schedule_prop_id' => $request['salary_prop'],
        ]);

        $plantilla_depts = PlantillaDept::where('plantilla_id', $request['id'])->get();
        foreach ($plantilla_depts as $key => $department) {
            PlantillaDept::create([
                'plantilla_id' => $newplantilla->id,
                'department_id' => $department->department->id,
                'order_number' => $department->order_number,
            ]);
        }

        $plantillacontents = PlantillaContent::where('plantilla_id', $request['id'])->get();
        $objs_to_insert = [];
        foreach ($plantillacontents as $key => $content) {
            if ($content->salaryproposed != null) {
                $cont = [
                    'plantilla_id' => $newplantilla->id,
                    'salary_grade_auth_id' => $content->salaryproposed ? $content->salaryproposed->id : null,
                    'salary_grade_prop_id' => $content->salaryproposed ? (SalaryGrade::where('salary_sched_id', $request['salary_prop'])->where('grade', $content->salaryproposed->grade)->where('step', $content->salaryproposed->step)->first()->id) : null,
                    'position_id' => $content->position->id,
                    'personal_information_id' => $content->personalinformation ? $content->personalinformation->id : null,
                    'old_number' => $content->old_number ? $content->old_number : $content->new_number,
                    'new_number' => null,
                    'working_time' => $content->working_time,
                    'appointment_status' => $content->appointment_status,
                    'order_number' => $content->order_number,
                    'level' => $content->level,
                    'original_appointment' => $content->original_appointment,
                    'last_promotion' => $content->last_promotion,
                    'appointment_status' => $content->appointment_status,
                    'csc_level' => $content->csc_level
                ];
                // PlantillaContent::create([
                //     'plantilla_id' => $newplantilla->id,
                //     'salary_grade_auth_id' => $content->salaryproposed ? $content->salaryproposed->id : null,
                //     'salary_grade_prop_id' => $content->salaryproposed ? (SalaryGrade::where('salary_sched_id', $request['salary_prop'])->where('grade', $content->salaryproposed->grade)->where('step', $content->salaryproposed->step)->first()->id) : null,
                //     'position_id' => $content->position->id,
                //     'personal_information_id' => $content->personalinformation ? $content->personalinformation->id : null,
                //     'old_number' => $content->old_number ? $content->old_number : $content->new_number,
                //     'new_number' => null,
                //     'working_time' => $content->working_time,
                //     'appointment_status' => $content->appointment_status,
                //     'order_number' => $content->order_number,
                //     'level' => $content->level,
                //     'original_appointment' => $content->original_appointment,
                //     'last_promotion' => $content->last_promotion,
                //     'appointment_status' => $content->appointment_status,
                // ]);
                array_push($objs_to_insert, $cont);
            }
        }
        // return $objs_to_insert;
        collect($objs_to_insert)->chunk(250)->each(function ($insert) {
            $newplantilla->plantilla_contents()->createMany($insert);
        });
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');
        $this->validate($request, [
            'year' => 'unique:plantillas',
        ]);
        $newplantilla = Plantilla::create([
            'year' => $request['year'],
            'salary_schedule_auth_id' => $request['salary_auth'],
            'salary_schedule_prop_id' => $request['salary_prop'],
        ]);

        $departments = $request['plantilla_depts'];
        foreach ($departments as $key => $department) {
            PlantillaDept::create([
                'plantilla_id' => $newplantilla->id,
                'department_id' => $department['id'],
                'order_number' => $key,
            ]);
        }

        // $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        // $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        // $plantillacontents = PlantillaContent::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get();
        // foreach ($plantillacontents as $key => $content) {
        //     PlantillaContent::create([
        //         'plantilla_id' => $newplantilla->id,
        //         'salary_grade_auth_id' => $content->salaryproposed->id,
        //         'salary_grade_prop_id' => SalaryGrade::where('salary_sched_id', $request['salary_prop'])->where('grade', $content->salaryproposed->grade)->where('step', $content->salaryproposed->step)->first()->id,
        //         'position_id' => $content->position->id,
        //         'personal_information_id' => $content->personalinformation ? $content->personalinformation->id : null,
        //         'old_number' => $content->new_number,
        //         'new_number' => $content->new_number,
        //         'working_time' => $content->working_time,
        //         'appointment_status' => $content->appointment_status,
        //         'order_number' => $content->order_number
        //     ]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdministratorORAuthor');
        $this->validate($request, [
            'year' => 'unique:plantillas,year,'.$id,
        ]);
        $plantilla = Plantilla::findOrFail($id);
        $plantilla->year = $request->year;
        $plantilla->salary_schedule_auth_id = $request->salary_auth;
        $plantilla->salary_schedule_prop_id = $request->salary_prop;
        $plantilla->date_approved = $request->date_approved;
        $plantilla->save();

        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $default_plantilla->value = $request->year;
        $default_plantilla->save();

        return ['message' => 'Success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
