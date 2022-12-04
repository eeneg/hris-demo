<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAppointmentListResource;
use App\Http\Resources\ReappointmentResource;
use App\PersonalInformation;
use App\Reappointment;
use Illuminate\Http\Request;

class ReappointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reappointment = Reappointment::select('reappointments.*')
                            ->join('personal_informations', 'reappointments.personal_information_id', 'personal_informations.id')
                            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                            ->leftJoin('departments as assigned_from_table', 'positions.department_id', '=', 'assigned_from_table.id')
                            ->leftJoin('departments as assigned_to_table', 'reappointments.assigned_to', '=', 'assigned_to_table.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.surname as surname',
                                'personal_informations.firstname as firstname',
                                'personal_informations.middlename as middlename',
                                'personal_informations.nameextension as nameextension',
                                'assigned_from_table.title as dept_from',
                                'assigned_to_table.title as dept_to',
                                'reappointments.*'
                            )
                            ->orderBy('reappointments.date', 'desc')->paginate(20);

        // return $reappointment;
        return new ReappointmentResource($reappointment);
    }

    public function employeeList()
    {
        $employees = PersonalInformation::orderBy('surname')->get();
        return new EmployeeAppointmentListResource($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'personal_information_id' => 'required',
            'assigned_to' => 'required',
        ],
        [
            'personal_information_id.required' => 'Employee required.',
            'assigned_to.required' => 'Department required',
        ]);

        $employee = PersonalInformation::find($request->personal_information_id)->plantillacontents;

        $department = Department::find($employee[0]->position->department_id);


        return Reappointment::create(array_merge($request->all(), ['assigned_from' => $department->id]));
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
        $data = Reappointment::find($id);

        $this->validate($request,
        [
            'personal_information_id' => 'required',
            'assigned_to' => 'required',
        ],
        [
            'personal_information_id.required' => 'Employee required.',
            'assigned_to.required' => 'Department required',
        ]);


        return $data->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Reappointment::findOrFail($id);

        $data->delete();
    }
}
