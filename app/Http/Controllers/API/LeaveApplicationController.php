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
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $department_id = Auth::user()->role == 'Office User' ? UserAssignment::where('user_id', Auth::user()->id)->first()->department_id : '';

        $data = [
            'role' => Auth::user()->role,
            'dept' => Department::find(UserAssignment::where('user_id', Auth::user()->id)->value('department_id'))
        ];

        $allEmployees = [];

        if ($department_id != '' && $department_id != null) {
            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where('departments.id', $department_id)
                ->orWhere('reappointments.assigned_to', $department_id)
                ->orderBy('date_of_filing', 'desc')
                ->paginate(20);

            // $allEmployees = DB::select("SELECT * FROM leave_applications
            //     JOIN personal_informations ON leave_applications.`personal_information_id` =  personal_informations.`id`
            //     JOIN plantilla_contents ON personal_informations.`id` = plantilla_contents.`personal_information_id`
            //     JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
            //     JOIN departments ON positions.`department_id` =  departments.`id`
            //     WHERE plantilla_contents.`personal_information_id` IS NOT NULL
            //     AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "'
            //     AND departments.`id` = '" . $department_id . "'
            //     ORDER BY leave_applications.`date_of_filing`");

            // $allEmployees = $allEmployees->merge($reappointments);

            // return $allEmployees;
            // return new LeaveApplicationResource($allEmployees);

            // return $allEmployees->get('data') = 'asd';

        }else if($data['role'] == 'Office Head' && $data['dept']['title'] == 'PHRMO'){

            $allEmployees = LeaveApplication::select('leave_applications.*',
                    'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                    'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                    ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                    ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                    ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                    ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                    ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                    ->whereNotNull('plantilla_contents.personal_information_id')
                    ->where('plantilla_contents.plantilla_id', $plantilla->id)
                    ->where(function ($query) use($data) {
                        $query->where('departments.id', '!=', $data['dept']['id'])
                        ->where('leave_applications.stage_status', '!=', 'Pending Recommendation')
                        ->where('leave_applications.stage_status', '!=', null)
                        ->where('leave_applications.stage_status', '!=', '');
                    })
                    ->orWhere('departments.id', $data['dept']['id'])->paginate(20);

            // return new LeaveApplicationResource($allEmployees);

        } else if($data['role'] == 'Office Head' && $data['dept']['title'] == 'PGO-Executive'){

            $allEmployees = LeaveApplication::select('leave_applications.*',
            'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
            'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->leftJoin('reappointments', 'personal_informations.id', '=', 'reappointments.personal_information_id')
            ->whereNotNull('plantilla_contents.personal_information_id')
            ->where('plantilla_contents.plantilla_id', $plantilla->id)
            ->where(function ($query) use($data) {
                $query->where('departments.id', '!=', $data['dept']['id'])
                ->where('leave_applications.stage_status', '!=', 'Pending Recommendation')
                ->where('leave_applications.stage_status', '!=', 'Pending Noted By')
                ->where('leave_applications.stage_status', '!=', 'Approved by the HR Head')
                ->where('leave_applications.stage_status', '!=', null)
                ->where('leave_applications.stage_status', '!=', '');
            })
            ->orWhere('departments.id', $data['dept']['id'])
            ->orWhere('reappointments.assigned_to', $department_id)
            ->orderBy('date_of_filing', 'desc')
            ->paginate(20);

            // return new LeaveApplicationResource($allEmployees);

        }else{

            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->orderBy('date_of_filing', 'desc')->paginate(20);
            // return new LeaveApplicationResource($allEmployees);

        }

        return new LeaveApplicationResource($allEmployees);

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

        if ($department_id != '' && $department_id != null) {

            $allEmployees = LeaveApplication::select('leave_applications.*',
                'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->where('leave_applications.id', $request->id)
                ->whereNotNull('plantilla_contents.personal_information_id')
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where('departments.id', $department_id)
                ->get();

            return new LeaveApplicationResource($allEmployees);
        }else{
            $allEmployees = LeaveApplication::select('leave_applications.*',
                    'personal_informations.firstname', 'personal_informations.middlename', 'personal_informations.surname', 'personal_informations.nameextension',
                    'leave_types.title', 'leave_types.description', 'leave_types.abbreviation', 'leave_types.max_duration')
                    ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
                    ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
                    ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
                    ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                    ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                    ->where('leave_applications.id', $request->id)
                    ->whereNotNull('plantilla_contents.personal_information_id')
                    ->where('plantilla_contents.plantilla_id', $plantilla->id)
                    ->get();

            return new LeaveApplicationResource($allEmployees);
        }
    }

    public function update(Request $request, $id)
    {

        if($request->stage_status == 'Approved')
        {
            $lc = LeaveCredit::where('leave_type_id', $request->leave_type_id)->where('personal_information_id', $request->personal_information_id)->first();

            if($lc)
            {
                $lc->update(['balance' => $lc->balance - Carbon::parse($request->from)->diffInDays(Carbon::parse($request->to))]);
            }
        }

        return LeaveApplication::find($id)->update($request->all());
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

    public function checkCredits(Request $request)
    {
        $lc = LeaveCredit::where('personal_information_id', $request->personal_information_id)
            ->where('leave_type_id', $request->leave_type_id)
            ->first();

        if(!$lc)
        {
            return ['code' => false, 'message' => 'Employee does not have Leave Credits, please encode first'];
        }else{
            return ['code' => true];
        }
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
