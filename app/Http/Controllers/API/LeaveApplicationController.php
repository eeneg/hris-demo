<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\LeaveApplication;
use App\UserAssignment;
use App\Setting;
use App\Plantilla;
use App\Http\Resources\LeaveApplicationResource;

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
        if ($department_id != '') {
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
                ->where('departments.id', $department_id)
                ->orderBy('date_of_filing', 'desc')->paginate(20);

            // $allEmployees = DB::select("SELECT * FROM leave_applications
            //     JOIN personal_informations ON leave_applications.`personal_information_id` =  personal_informations.`id`
            //     JOIN plantilla_contents ON personal_informations.`id` = plantilla_contents.`personal_information_id`
            //     JOIN positions ON plantilla_contents.`position_id` =  positions.`id`
            //     JOIN departments ON positions.`department_id` =  departments.`id`
            //     WHERE plantilla_contents.`personal_information_id` IS NOT NULL
            //     AND plantilla_contents.`plantilla_id` = '" . $plantilla->id . "'
            //     AND departments.`id` = '" . $department_id . "'
            //     ORDER BY leave_applications.`date_of_filing`");
            return $allEmployees;
            return new LeaveApplicationResource($allEmployees);
        } else {
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
            return new LeaveApplicationResource($allEmployees);
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
