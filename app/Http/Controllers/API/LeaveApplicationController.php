<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\LeaveApplication;
use App\UserAssignment;
use App\Setting;
use App\Plantilla;
use App\Http\Resources\LeaveApplicationResource;
use App\LeaveCredit;
use App\PersonalInformation;
use App\Reappointment;
use App\User;
use Carbon\Carbon;
use App\Events\LeaveProcessed;
use Illuminate\Pagination\Paginator;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_plantilla  =   Setting::where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::where('year', $default_plantilla->value)->first();
        $department_id      =   Auth::user()->role == 'Office User' || Auth::user()->role == 'Office Head'  ?
                                UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';

        $data = [
            'role' => Auth::user()->role,
            'dept' => Department::find(UserAssignment::where('user_id', Auth::user()->id)->value('department_id'))
        ];

        return new LeaveApplicationResource(LeaveApplication::leaveapplications($default_plantilla, $plantilla, $department_id, $data));
    }

    public function getAllLeave()
    {
        $default_plantilla  =   Setting::where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::where('year', $default_plantilla->value)->first();
        $department_id      =   Auth::user()->role == 'Office User' || Auth::user()->role == 'Office Head' ?
                                UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';

        return new LeaveApplicationResource(LeaveApplication::getAllLeave($default_plantilla, $plantilla, $department_id));
    }

    public function searchLeave(Request $request)
    {
        $data = [];

        foreach($request->all() as $key => $item)
        {
            if($item != null)
            {
                $data[$key]=$item;
            }
        }

        return LeaveApplication::where($data)->get();
    }

    public function getLeaveBalance(Request $request)
    {
        $leaveCredit    =   DB::table('leave_credits')
                            ->leftJoin('leave_types', 'leave_credits.leave_type_id', '=', 'leave_types.id')
                            ->where('personal_information_id', $request->id)
                            ->where(function ($query) {
                                $query->where('leave_types.title', 'Sick Leave')
                                ->orWhere('leave_types.title', 'Vacation Leave');
                            })
                            ->pluck('balance', 'abbreviation');

        return $leaveCredit;
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
            'leave_type_id' => 'required'
        ],
        [
            'personal_information_id.required' => 'Name of applicant is required.',
            'leave_type_id.required' => 'Type of leave is required.',
        ]);

        return LeaveApplication::create($request->all());
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

    public function edit(Request $request)
    {

        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $department_id = Auth::user()->role == 'Office User' ? UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';

        $data = [
            'role' => Auth::user()->role,
            'dept' => Department::find(UserAssignment::where('user_id', Auth::user()->id)->value('department_id'))
        ];

        return new LeaveApplicationResource(LeaveApplication::leaveapplications($default_plantilla, $plantilla, $department_id, $data));
    }

    public function update(Request $request, $id)
    {
        $application = LeaveApplication::find($id);

        // if($request->stage_status == 'Approved by the HR Head')
        // {
        //     event(new LeaveProcessed($application));
            $application->update($request->all());
        // }

        // if($application->stage_status == 'Approved by the HR Head' && $request->stage_status == 'Pending Noted By')
        // {
        //     $application->update($request->all());
        // }

        return event(new LeaveProcessed($application));

    }

    public function loadUserRole()
    {
        $data = [
            'role' => Auth::user()->role,
            'dept' => Department::find(UserAssignment::where('user_id', Auth::user()->id)->value('department_id')),
            'id'   => Auth::user()->id
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return LeaveApplication::find($id)->delete();
    }
}
