<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Audit;
use App\Http\Controllers\Controller;
use App\Http\Resources\BirthdaysResource;
use App\LeaveApplication;
use App\LeaveType;
use App\Plantilla;
use App\PlantillaContent;
use App\Setting;
use App\Appointment;
use App\Position;
use App\Department;
use App\PersonalInformation;
use App\Reappointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $plantilla_contents = PlantillaContent::where('plantilla_id', $plantilla->id)->get();
        $vacant_positions = $plantilla_contents->whereNull('personal_information_id');
        $active_employees = $plantilla_contents->whereNotNull('personal_information_id');
        $retired_employees = PersonalInformation::where('status', 'Retired')->get();

        $birthdays = PlantillaContent::where('plantilla_id', $plantilla->id)->whereNotNull('personal_information_id')
            ->with('personalinformation')
            ->whereHas('personalinformation', function ($q) {
                $q->whereRaw("DAYOFYEAR(STR_TO_DATE(CONCAT(YEARWEEK(NOW(), 1),'Monday'), '%x%v %W')) <= DAYOFYEAR(birthdate) AND DAYOFYEAR(STR_TO_DATE(CONCAT(YEARWEEK(NOW(), 1),'Sunday'), '%x%v %W')) >=  DAYOFYEAR(birthdate)");
            })->get();

        $onLeaveEmployees = LeaveApplication::select(
                'id',
                'personal_information_id',
                'leave_type_id',
                'inclusive_dates',
                'application_stage',
            )
            ->has('personalinformation')
            ->with(['personalinformation' => function($query){
                $query->without(
                    'barcode',
                    'familybackground',
                    'residentialaddresstable',
                    'permanentaddresstable',
                    'children',
                    'educationalbackground',
                    'eligibilities',
                    'otherinfos',
                    'workexperiences',
                    'voluntaryworks',
                    'trainingprograms',
                    'pdsquestion'
                )
                ->select(
                    'id',
                    'firstname',
                    'surname',
                    'picture'
                );
            }])
            ->with(['leavetype' => function($query){
                $query->select('id', 'title');
            }])
            ->where(function($query){
                $query->where('inclusive_dates->mode', 2)
                    ->where('inclusive_dates->data->start', '<=', Carbon::now())
                    ->where('inclusive_dates->data->end', '>=', Carbon::now());
            })
            ->orWhere(function($query){
                $query->where('inclusive_dates->mode', 3)
                    ->where('inclusive_dates->data', 'like', '%' . now()->toDateString() . '%');
            })
            ->where('application_stage', 'approved')
            ->get();

        $newlyAppointedEmployees = Appointment::has('personalinformation')
            ->with('personalinformation')
            ->whereBetween('reckoning_date', [Carbon::now()->subMonth(6)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($employee){

                $position = Position::find($employee->position_id);

                return[
                    'name' => $employee->personalinformation->firstname . ' '. $employee->personalinformation->surname,
                    'position' => $position->title,
                    'department' => Department::find($position->department_id)->title,
                    'avatar' => $employee->personalinformation->picture
                ];
            });

        $reappointments = Reappointment::whereBetween('termination_date', [
            Carbon::now(),
            Carbon::now()->addDays(30)
        ])->orWhere('termination_date', '<', Carbon::now())->get();

        $data = [
            'newlyAppointedEmployees' => $newlyAppointedEmployees,
            'newlyAppointedEmployeesCount' => $newlyAppointedEmployees->count(),
            'onLeaveEmployees' => $onLeaveEmployees,
            'vacant_positions' => count($vacant_positions),
            'active_employees' => count($active_employees),
            'retired_employees' => count($retired_employees),
            'birthdays' => new BirthdaysResource($birthdays),
            'audits' => Audit::with(['user'])->latest('created_at')->take(15)->get(),
            'announcements' => Activity::with('attachments')->whereType('announcement')->latest('created_at')->take(5)->get(),
            'events' => Activity::with('attachments')->whereType('event')->whereDate('time', '>=', now())->latest('time')->take(5)->get(),
            'reappointments' => $reappointments
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
