<?php

namespace App\Http\Controllers\Api;

use App\Audit;
use App\Http\Controllers\Controller;
use App\Http\Resources\BirthdaysResource;
use App\LeaveApplication;
use App\LeaveType;
use App\Plantilla;
use App\PlantillaContent;
use App\Setting;
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
        $birthdays = PlantillaContent::where('plantilla_id', $plantilla->id)->whereNotNull('personal_information_id')
            ->with('personalinformation')
            ->whereHas('personalinformation', function ($q) {
                $q->whereMonth('birthdate', Carbon::now()->format('m'))
                ->whereDay('birthdate', Carbon::now()->format('d'));
            })->get();

        $onLeaveEmployees = LeaveApplication::has('personalinformation')->with('personalinformation')
            ->whereBetweenColumns('from', ['from', 'to'])
            ->where(function($query){
                $query->where('stage_status', 'Approved by the HR Head')
                ->orWhere('stage_status', 'Approved by the Governor	');
            })
            ->get()
            ->map(function($employee){
                return [
                    'name' => $employee->personalinformation->firstname . ' '. $employee->personalinformation->surname,
                    'leaveType' => LeaveType::find($employee->leave_type_id)->title,
                    'dates' => $employee->from . ' - ' . $employee->to,
                    'avatar' => $employee->personalinformation->picture
                ];
            });

        // dd($onLeaveEmployees->toArray());

        $data = [
            'onLeaveEmployees' => $onLeaveEmployees,
            'vacant_positions' => count($vacant_positions),
            'active_employees' => count($active_employees),
            'birthdays' => new BirthdaysResource($birthdays),
            'audits' => Audit::with(['user'])->latest('created_at')->take(15)->get(),
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
