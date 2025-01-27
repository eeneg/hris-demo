<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAppointmentListResource;
use App\Http\Resources\ReappointmentResource;
use App\PersonalInformation;
use App\Reappointment;
use App\Setting;
use App\Plantilla;
use App\PlantillaContent;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReappointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function index(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

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
                            ->where('plantilla_contents.plantilla_id',$plantilla->id)
                            ->orderBy('reappointments.termination_date', 'asc');


        if (!$request->search && !$request->dateFrom && !$request->dateTo) {
            return new ReappointmentResource($reappointment->orderBy('created_at', 'desc')->paginate(20));
        } else if (!$request->search && $request->dateFrom && $request->dateTo) {
            $reappointment->whereBetween('reappointments.termination_date', [$request->dateFrom ? $request->dateFrom : Carbon::now()->format('Y-m-d'), $request->dateTo ? $request->dateTo : Carbon::now()->format('Y-m-d')]);

            return new ReappointmentResource($reappointment->paginate(20));
        } else if ($request->search && !$request->dateFrom && !$request->dateTo) {
            $reappointment->where(function ($query) use ($request) {
                $query->where('surname', 'LIKE', '%'.$request->search.'%')
                ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                ->orWhere(DB::raw("CONCAT(`surname`, ' ', `firstname`)"), 'LIKE', '%'.$request->search.'%')
                ->orderBy('surname');
            });

            return new ReappointmentResource($reappointment->paginate(20));
        } else {
            $reappointment->whereBetween('reappointments.termination_date', [$request->dateFrom ? $request->dateFrom : Carbon::now()->format('Y-m-d'), $request->dateTo ? $request->dateTo : Carbon::now()->format('Y-m-d')])
                ->where(function ($query) use ($request) {
                    $query->where('surname', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                    ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                    ->orWhere(DB::raw("CONCAT(`surname`, ' ', `firstname`)"), 'LIKE', '%'.$request->search.'%')
                    ->orderBy('surname');
                });

            return new ReappointmentResource($reappointment->paginate(20));
        }
    }

    public function printReappointments(Request $request)
    {
        $data = $request->data;
        $from = $request->from ?? Carbon::now()->format('Y-m-d');
        $to = $request->to ?? Carbon::now()->format('Y-m-d');

        $from = Carbon::parse($from)->format('F, d Y');
        $to = Carbon::parse($to)->format('F, d Y');

        return view('reports.reappointments', compact('data','from', 'to'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEmployeePosition($id)
    {

        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontent = PlantillaContent::where('plantilla_id', $plantilla->id)->where('personal_information_id', $id)->first();


        $position = Position::find($plantillacontent->position_id);
        return response()->json($position->title);
    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'personal_information_id' => 'required',
                'assigned_to' => 'required',
                'position' => 'required',
                'effectivity_date' => 'required',
                'termination_date' => 'required',
                'type' => 'required',
                'duties' => 'required',
            ],
            [
                'personal_information_id.required' => 'Employee required.',
                'assigned_to.required' => 'Department Field Required',
                'position.required' => 'Position Field Required',
                'effectivity_date.required' => 'Effectivity Date Field Required',
                'termination_date.required' => 'Termination Date Field Required',
                'type.required' => 'Reassignment Type Field Required',
                'duties.required' => 'Duties Field Required',
            ]
        );

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
                'position' => 'required',
                'effectivity_date' => 'required',
                'termination_date' => 'required',
                'type' => 'required',
                'duties' => 'required',
            ],
            [
                'personal_information_id.required' => 'Employee required.',
                'assigned_to.required' => 'Department Field Required',
                'position.required' => 'Position Field Required',
                'effectivity_date.required' => 'Effectivity Date Field Required',
                'termination_date.required' => 'Termination Date Field Required',
                'type.required' => 'Reassignment Type Field Required',
                'duties.required' => 'Duties Field Required',
            ]
        );

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
