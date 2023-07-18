<?php

namespace App\Http\Controllers\Api;

use App\Appointment;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Plantilla;
use App\PlantillaDept;
use App\SalaryGrade;
use App\SalarySchedule;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appointments = Appointment::select('appointment_records.*')
            ->leftJoin('personal_informations', 'appointment_records.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('positions', 'appointment_records.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('salary_grades', 'appointment_records.salary_grade_id', '=', 'salary_grades.id')
            ->leftJoin('salary_schedules', 'salary_grades.salary_sched_id', '=', 'salary_schedules.id')
            ->select(
                'personal_informations.id as personal_information_id',
                'personal_informations.firstname as firstname',
                'personal_informations.surname as surname',
                'personal_informations.nameextension as nameextension',
                'departments.id as dept_id',
                'departments.title as dept_title',
                'positions.id as position_id',
                'positions.title as position_title',
                'salary_schedules.id as salary_schedules_id',
                'salary_schedules.tranche as tranche',
                'salary_grades.id as salary_grade_id',
                'salary_grades.step as step',
                'salary_grades.grade as grade',
                'appointment_records.*'
            );


        if (!$request->search && !$request->from && !$request->to) {
            return new AppointmentResource($appointments->orderBy('created_at', 'desc')->paginate(20));
        } else if (!$request->search && $request->from && $request->to) {
            $appointments->whereBetween('appointment_records.reckoning_date', [$request->from ? $request->from : Carbon::now()->format('Y-m-d'), $request->to ? $request->to : Carbon::now()->format('Y-m-d')]);

            return new AppointmentResource($appointments->paginate(20));
        } else if ($request->search && !$request->from && !$request->to) {
            $appointments->where(function ($query) use ($request) {
                $query->where('surname', 'LIKE', '%'.$request->search.'%')
                ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                ->orWhere(DB::raw("CONCAT(`surname`, ' ', `firstname`)"), 'LIKE', '%'.$request->search.'%')
                ->orderBy('surname');
            });

            return new AppointmentResource($appointments->paginate(20));
        } else {
            $appointments->whereBetween('appointment_records.reckoning_date', [$request->from ? $request->from : Carbon::now()->format('Y-m-d'), $request->to ? $request->to : Carbon::now()->format('Y-m-d')])
                ->where(function ($query) use ($request) {
                    $query->where('surname', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                    ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                    ->orWhere(DB::raw("CONCAT(`surname`, ' ', `firstname`)"), 'LIKE', '%'.$request->search.'%')
                    ->orderBy('surname');
                });

            return new AppointmentResource($appointments->paginate(20));
        }
    }

    public function fetchDepartments(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        return PlantillaDept::where('plantilla_id', $plantilla->id)->with(['department' => fn($q) =>  $q->select(['departments.id', 'departments.title'])->with('positions')])->get()->pluck('department');
    }

    public function fetchSalarySched(Request $request)
    {
        $salarysched = SalarySchedule::with('salarygrades')->get();

        return $salarysched;
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
        $salaryGradeId = SalaryGrade::where('salary_sched_id', $request->salary_sched_id)->where('grade', $request->grade)->where('step', $request->step)->value('id');

        $request->merge(['salary_grade_id' => $salaryGradeId]);

        $request->validate([
            'personal_information_id' => 'required',
            'salary_grade_id' => 'required',
            'position_id' => 'required',
            'salary_sched_id' => 'required',
            'grade' => 'required',
            'step' => 'required',
            'status' => 'required',
            'agency' => 'required',
            'nature_of_appointment' => 'required',
            'reckoning_date' => 'required|date',
        ]);

        $appointment = Appointment::create($request->all());
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
        $appointment = Appointment::findOrFail($id);

        $salaryGradeId = SalaryGrade::where('salary_sched_id', $request->salary_sched_id)->where('grade', $request->grade)->where('step', $request->step)->value('id');

        $request->merge(['salary_grade_id' => $salaryGradeId]);

        $request->validate([
            'personal_information_id' => 'required',
            'salary_grade_id' => 'required',
            'position_id' => 'required',
            'salary_sched_id' => 'required',
            'grade' => 'required',
            'step' => 'required',
            'status' => 'required',
            'agency' => 'required',
            'nature_of_appointment' => 'required',
            'reckoning_date' => 'required|date',
        ]);

        $appointment->update($request->all());
    }

    public function printAppointmentRecords(Request $request)
    {
        $data = collect($request->data)->map(function($e){
            $f = $e['personal_information']['firstname'];
            $s = $e['personal_information']['surname'];
            return [
                'name' => $f . ' ' . $s,
                'nature' => $e['nature_of_appointment'],
                'department' => $e['department']['title'],
                'appointed_to' => $e['position']['title'],
                'reckoning_date' => $e['reckoning_date']
            ];
        });

        $from = $request->from ?? Carbon::now()->format('Y-m-d');
        $to = $request->to ?? Carbon::now()->format('Y-m-d');

        $from = Carbon::parse($from)->format('F, d Y');
        $to = Carbon::parse($to)->format('F, d Y');

        return view('reports.appointments', compact('data','from', 'to'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdministratorORAuthor');
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();
    }
}
