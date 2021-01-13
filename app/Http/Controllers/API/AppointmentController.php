<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\Position;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Http\Resources\AppointmentResource;
use App\SalaryGrade;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->search && !$request->from && !$request->to)
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
            )
            ->paginate(20);
        }else{
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
            )
            ->orWhere('surname', 'LIKE', '%'.$request->search.'%')
            ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
            ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
            ->orderBy('surname')
            ->get();

            $appointments = $appointments->whereBetween('reckoning_date', array($request->from, $request->to ? $request->to : Carbon::now()->format('Y-m-d')));
        }

        return new AppointmentResource($appointments);

    }

    public function deptPosition(Request $request)
    {
        if($request->deptId != null)
        {
            return Position::where('department_id', $request->deptId)->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personalInfoId = PersonalInformation::where('firstname', $request->firstname)->where('surname', $request->surname)->value('id');

        $salaryGradeId = SalaryGrade::where('salary_sched_id', $request->salary_sched_id)->where('grade', $request->grade)->where('step', $request->step)->value('id');

        $request->merge(['personal_information_id' => $personalInfoId, 'salary_grade_id' => $salaryGradeId]);

        $request->validate([
            'personal_information_id'   => 'required',
            'salary_grade_id'           => 'required',
            'firstname'                 => 'required',
            'surname'                   => 'required',
            'position_id'               => 'required',
            'salary_sched_id'           => 'required',
            'grade'                     => 'required',
            'step'                      => 'required',
            'status'                    => 'required',
            'agency'                    => 'required',
            'nature_of_appointment'     => 'required',
            'previous_employee'         => 'required',
            'previous_status'           => 'required',
            'itemno'                    => 'required|integer',
            'page'                      => 'required|integer',
            'reckoning_date'            => 'required|date'
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
        $appointment = Appointment::findOrFail($id);

        $personalInfoId = PersonalInformation::where('firstname', $request->firstname)->where('surname', $request->surname)->value('id');

        $salaryGradeId = SalaryGrade::where('salary_sched_id', $request->salary_sched_id)->where('grade', $request->grade)->where('step', $request->step)->value('id');

        $request->merge(['personal_information_id' => $personalInfoId, 'salary_grade_id' => $salaryGradeId]);

        $request->validate([
            'personal_information_id'   => 'required',
            'salary_grade_id'           => 'required',
            'firstname'                 => 'required',
            'surname'                   => 'required',
            'position_id'               => 'required',
            'salary_sched_id'           => 'required',
            'grade'                     => 'required',
            'step'                      => 'required',
            'status'                    => 'required',
            'agency'                    => 'required',
            'nature_of_appointment'     => 'required',
            'previous_employee'         => 'required',
            'previous_status'           => 'required',
            'itemno'                    => 'required|integer',
            'page'                      => 'required|integer',
            'reckoning_date'            => 'required|date'
        ]);

        $appointment->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();
    }
}
