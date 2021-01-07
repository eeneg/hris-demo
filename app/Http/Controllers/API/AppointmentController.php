<?php

namespace App\Http\Controllers\API;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Http\Resources\AppointmentResource;
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
        $appointments =  PersonalInformation::select('personal_informations.*')
        ->join('plantilla_contents', 'personal_informations.id' , '=', 'plantilla_contents.personal_information_id')
        ->join('positions', 'plantilla_contents.position_id', '=', 'positions.id')
        ->join('departments', 'positions.department_id', '=', 'departments.id')
        ->leftJoin('appointment_records', 'personal_informations.id', '=', 'appointment_records.personal_information_id')
        ->select(
                'personal_informations.id as personalInfoId',
                'personal_informations.firstname',
                'personal_informations.middlename',
                'personal_informations.surname',
                'personal_informations.nameextension',
                'plantilla_contents.position_id as positionId',
                'plantilla_contents.salary_grade_auth_id',
                'positions.title as positionTitle',
                'departments.title as deptTitle',
                'appointment_records.*')
        ->where('departments.title', $request->deptTitle)
        ->get();

        return new AppointmentResource($appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status'                    => 'required|string',
            'nature_of_appointment'     => 'required|string',
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

        $request->validate([
            'status'                    => 'required|string',
            'nature_of_appointment'     => 'required|string',
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
