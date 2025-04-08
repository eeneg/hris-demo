<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Events\LeaveProcessed;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveApplicationResource;
use App\LeaveApplication;
use App\LeaveCredit;
use App\LeaveType;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\Position;
use App\Setting;
use App\User;
use App\UserAssignment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first(); //Get the default plantilla for current plantilla year
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first(); //Get the plantilla for the current plantilla year
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::without('department')->where('user_id', auth('api')->user()->id)->first()->department_id : ''; //Get the department id of the user

        $leave_applications = LeaveApplication::whereHas('personalinformation', function($query) use ($department_id, $plantilla, $default_plantilla){
            $query->when(
                // check if user not the admin, author, hr head, or governor and view only their department leave applications
                $department_id && !(
                    (
                        Department::where('title', env('HR_DEPARTMENT'))->first()->id == auth('api')->user()->userassignment->department_id ||
                        Department::where('title', env('GOV_OFFICE'))->first()->id == auth('api')->user()->userassignment->department_id
                    )
                ),
                function($query) use ($department_id, $plantilla){
                    $query->whereHas('plantillacontents', function($query) use ($department_id, $plantilla){
                        $query->where('plantilla_id', $plantilla->id)
                            ->whereIn('position_id', Position::where('department_id', $department_id)
                            ->pluck('id')
                        );
                    });
                }
            );
            // check if HR Head and view all leave applications of the HR department
            // with leave applications that are pending noted by, noted by disapproved from other departments
            // ->when(
            //     $department_id && Department::where('title', env('HR_DEPARTMENT'))->first()->id == auth('api')->user()->userassignment->department_id,
            //     function($query) use ($department_id, $plantilla){
            //         $query->whereHas('plantillacontents', function($query) use ($department_id, $plantilla){
            //             $query->where('plantilla_id', $plantilla->id)
            //                 ->whereIn('position_id', Position::where('department_id', $department_id)
            //                 ->pluck('id')
            //             );
            //         })
            //         ->orWhere(function($query){
            //             $query->where('application_stage', 'pending_noted_by')
            //                 ->orWhere('application_stage', 'noted_by_disapproved');
            //         });
            //     }
            // )
            // check if Governor and view all leave applications of the Governor's Office
            // with leave applications that are pending governor approval, governor disapproved from other departments
            // ->when(
            //     $department_id && Department::where('title', env('GOV_OFFICE'))->first()->id == auth('api')->user()->userassignment->department_id,
            //     function($query) use ($department_id, $plantilla){
            //         $query->whereHas('plantillacontents', function($query) use ($department_id, $plantilla){
            //             $query->where('plantilla_id', $plantilla->id)
            //                 ->whereIn('position_id', Position::where('department_id', $department_id)
            //                 ->pluck('id')
            //             );
            //         })
            //         ->orWhere(function($query){
            //             $query->where('application_stage', 'pending_governor_approval')
            //                 ->orWhere('application_stage', 'governor_disapproved');
            //         });
            //     }
            // );
        })
        // add employee personal information
        ->with(['personalinformation' => function($query){
            $query->select('id', 'firstname', 'middlename', 'surname', 'nameextension')
            ->without(
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
            );
        }])
        // add leave type
        ->with(['leavetype' => function($query){
            $query->select('id', 'title');
        }])
        ->orderBy('created_at', 'desc');

        return new LeaveApplicationResource($leave_applications->paginate(10));

    }

    public function searchLeaveApplications(Request $request){
        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first(); //Get the default plantilla for current plantilla year
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first(); //Get the plantilla for the current plantilla year
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::without('department')->where('user_id', auth('api')->user()->id)->first()->department_id : ''; //Get the department id of the user


        $leave_applications = LeaveApplication::whereHas('personalinformation', function($query) use ($department_id, $plantilla, $default_plantilla, $request){
            $query->when($request->input('employee_name'), function($query) use ($request){
                $query->where('firstname', 'like', '%'.$request->input('employee_name').'%')
                    ->orWhere('middlename', 'like', '%'.$request->input('employee_name').'%')
                    ->orWhere('surname', 'like', '%'.$request->input('employee_name').'%')
                    ->without(
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
                    );
            })
            ->when(
                //Check if the user is not the HR Head or Governor
                $department_id &&
                (
                    $default_plantilla->hr_head_id != auth('api')->user()->id &&
                    $default_plantilla->governor_id != auth('api')->user()->id
                ),
                function($query) use ($department_id, $plantilla){
                    $query->whereHas('plantillacontents', function($query) use ($department_id, $plantilla){
                        $query->where('plantilla_id', $plantilla->id)
                        ->whereIn('position_id', Position::where('department_id', $department_id)->pluck('id'));
                    });
                }
            )
            //department filter
            ->when($request->input('department'), function($query) use ($request, $plantilla){
                $query->whereHas('plantillacontents', function($query) use ($request, $plantilla){
                    $query->where('plantilla_id', $plantilla->id)
                    ->whereIn('position_id', Position::where('department_id', $request->input('department'))->pluck('id'));
                    });
                });
            })
            //leave type filter
            ->when($request->input('leave_types'), function($query) use ($request){
                $query->whereIn('leave_type_id', $request->input('leave_types'));
            })
            //application stage filter
            ->when($request->input('leave_stages'), function($query) use ($request){
                    $query->whereIn('application_stage', $request->input('leave_stages'));
            });

        return new LeaveApplicationResource($leave_applications->paginate(10));
    }

    public function getEmployees(){
        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first();
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::without('department')->where('user_id', auth('api')->user()->id)->first()->department_id : '';

        $employees = PersonalInformation::without(
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
            ->where(function($query) use ($department_id, $plantilla){
                $query->when($department_id, function($query) use ($department_id, $plantilla){
                    $query->whereHas('plantillacontents', function($query) use ($department_id, $plantilla){
                        $query->where('plantilla_id', $plantilla->id)
                        ->whereIn('position_id', Position::where('department_id', $department_id)->pluck('id')->toArray());
                    });
                });
            })
            ->orderBy('surname', 'asc')
            ->get(['id', 'firstname', 'middlename', 'surname', 'nameextension']);

        return response()->json($employees);

    }

    public function getLeaveTypes(){
        return response()->json(LeaveType::where('status', 'active')->get());
    }

    public function getDepartmentWithPositions($id){

        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first();

        $employee_plantilla = PlantillaContent::where('plantilla_id', $plantilla->id)->where('personal_information_id', $id)->first();

        if(!$employee_plantilla){
            return response()->json(['department' => '', 'position' => '']);
        }

        $position = Position::find($employee_plantilla->position_id);
        $department = Department::find($position->department_id);

        return response()->json(['department' => $department->description ?? '', 'position' => $position->title ?? '']);

    }

    public function getEmployeeSalary($id){
        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first();

        $employee_plantilla = PlantillaContent::where('plantilla_id', $plantilla->id)->where('personal_information_id', $id)->first();

        if(!$employee_plantilla){
            return response()->json(['salary' => 0]);
        }


        return response()->json(['salary' => number_format($employee_plantilla->salaryproposed->amount, 2) ?? 0]);
    }

    public function getEmployeeLeaveCredits($id){

        $vl = LeaveCredit::where('personal_information_id', $id)
            ->where('leave_type_id', LeaveType::where('abbreviation', 'VL')->first()->id)
            ->first(); //Vacation Leave Credits
        $sl = LeaveCredit::where('personal_information_id', $id)
            ->where('leave_type_id', LeaveType::where('abbreviation', 'SL')->first()->id)
            ->first(); //Sick Leave Credits

        return response()->json(['vl' => $vl->balance ?? 0, 'sl' => $sl->balance ?? 0]);

    }

    public function getUserDepartment(){
        $department_id = auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                        UserAssignment::without('department')->where('user_id', auth('api')->user()->id)->first()->department_id : '';

        $is_hr = null;

        if($department_id){
            $is_hr = Department::where('id', $department_id)->first()->title == env('HR_DEPARTMENT');
        }

        return ['is_hr' => $is_hr, 'role' => auth('api')->user()->role];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'personal_information_id' => 'required',
            'leave_type_id' => 'required',
            'department' => 'required',
            'position' => 'required',
            'salary' => 'required',
            'spent' => 'required',
            'spent_specified' => 'required_if:spent,abroad,within_the_philippines,in_hospital,out_patient',
            'working_days' => 'required',
            'date_of_filing' => 'required',
            'inclusive_dates' => 'required',
            'commutation' => 'required',
            'credit_as_of' => 'required',
            'credit_officer.name' => 'required',
            'vacation_less' => 'required',
            'sick_less' => 'required',
            'vacation_balance' => 'required',
            'sick_balance' => 'required',
            'recommendation_approved' =>  [
                function ($attribute, $value, $fail) use ($request) {
                    if (!empty($request->input('recommendation_officer.name')) && is_null($value)) {
                        $fail('The recommendation approved field is required');
                    }
                },
            ],
            'recommendation_officer.name' => 'required_if:recommendation_approved,true,false',
            'recommendation_disapproved_due_to' => 'required_if:recommendation_approved,false',
            'final' => 'required',
            'application_stage' => 'required',
            'days_with_pay' => 'required',
            'days_without_pay' => 'required',
        ],
        [
            'personal_information_id.required' => 'The employee field is required.',
            'leave_type_id.required' => 'The leave type field is required.',
            'vacation_less.required' => 'This field is required.',
            'sick_less.required' => 'This field is required.',
            'spent_specified.required_if' => 'The specify field is required.',
            'recommendation_officer.required_if' => 'The recommendation officer field is required.',
            'recommendation_remark.required_if' => 'The recommendation remark field is required.',
            'approved_for_others.required' => 'The others field is required.',
        ]);

        LeaveApplication::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave = LeaveApplication::with('leavetype')->find($id);

        $employee = PersonalInformation::without(
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
        ->find($leave->personal_information_id);

        return view('reports.leave_application_form', compact('employee', 'leave'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editLeaveApplication($id)
    {
        return LeaveApplication::with('personalinformation', 'leavetype')->find($id);
    }

    public function returnPreviousStage(Request $request, $id){
        $leave = LeaveApplication::find($id);

        $stage = $request->input('application_stage');
        $data = [];

        if (in_array($stage, ['pending_governor_approval', 'governor_disapproved'])) {
            $data = [
                'noted_by_officer' => null,
                'noted_by_approved' => null,
                'noted_disapproved_due_to' => null,
                'governor_approval_officer' => null,
                'governor_approved' => null,
                'gov_disapproved_due_to' => null,
                'application_stage' => 'pending_noted_by'
            ];
        }

        if (in_array($stage, ['pending_noted_by', 'noted_by_disapproved'])) {
            $data = [
                'recommendation_officer' => null,
                'recommendation_approved' => null,
                'recommendation_disapproved_due_to' => null,
                'noted_by_officer' => null,
                'noted_by_approved' => null,
                'noted_disapproved_due_to' => null,
                'application_stage' => 'pending_recommendation'
            ];
        }

        if (in_array($stage, ['pending_recommendation', 'disapproved_recommendation'])) {
            $data =[
                'credit_as_of' => null,
                'credit_officer' => null,
                'vacation_less' => null,
                'sick_less' => null,
                'vacation_balance' => null,
                'sick_balance' => null,
                'recommendation_officer' => null,
                'recommendation_approved' => null,
                'recommendation_disapproved_due_to' => null,
                'application_stage' => 'pending_leave_credit_calculation'
            ];
        }

        if ($stage === 'approved') {
            if ($leave->governor_approved) {
                $data = [
                    'governor_approval_officer' => null,
                    'governor_approved' => null,
                    'gov_disapproved_due_to' => null,
                    'application_stage' => 'pending_governor_approval'
                ];
            } elseif ($leave->noted_by_approved && !$leave->governor_approved) {
                $data = [
                    'noted_by_officer' => null,
                    'noted_by_approved' => null,
                    'noted_disapproved_due_to' => null,
                    'application_stage' => 'pending_noted_by'
                ];
            }
        }

        $leave->update($data);
    }

    public function update(Request $request, $id)
    {
        $data = [];

        if($request->input('type') == 'leave_credit_calculation'){
            $request->validate([
                'name' => 'required',
                'credit_as_of' => 'required',
                'vacation_balance' => 'required',
                'vacation_less' => 'required|numeric',
                'sick_balance' => 'required|numeric',
                'sick_less' => 'required'
            ],[
                'name.required' => 'The officer field is required.',
                'vacation_less.required' => 'This field is required.',
                'vacation_less.numeric' => 'This field must be a number.',
                'sick_less.required' => 'This field is required.',
                'sick_less.numeric' => 'This field must be a number.',
            ]);
            $data = [
                'credit_as_of' => $request->input('credit_as_of'),
                'vacation_balance' => $request->input('vacation_balance'),
                'vacation_less' => $request->input('vacation_less'),
                'sick_balance' => $request->input('sick_balance'),
                'sick_less' => $request->input('sick_less'),
                'credit_officer' => [
                    'personal_information_id' => $request->input('personal_information_id'),
                    'name' => $request->input('name'),
                    'position' => $request->input('position'),
                    'date' => Carbon::now()->format('Y-m-d'),
                ],
                'application_stage' => 'pending_recommendation'
            ];
        }

        if($request->input('type') == 'recommendation'){
            $request->validate([
                'name' => 'required',
                'recommendation_approved' => 'required',
                'recommendation_disapproved_due_to' => 'required_if:recommendation_approved,==,false',
            ]);
            $data = [
                'recommendation_officer' => [
                    'personal_information_id' => $request->input('personal_information_id'),
                    'name' => $request->input('name'),
                    'position' => $request->input('position'),
                    'date' => Carbon::now()->format('Y-m-d'),
                ],
                'recommendation_approved' => $request->input('recommendation_approved'),
                'recommendation_disapproved_due_to' => $request->input('recommendation_disapproved_due_to'),
                'application_stage' => $request->input('recommendation_approved') == 'true' ? 'pending_noted_by' : 'disapproved_recommendation'
            ];
        }

        if($request->input('type') == 'noted_by'){
            $request->validate([
                'name' => 'required',
                'approved' => 'required',
                'remark' => 'required_if:approved,false',
            ]);
            $data = [
                'noted_by_officer' => [
                    'personal_information_id' => $request->input('personal_information_id'),
                    'name' => $request->input('name'),
                    'position' => $request->input('position'),
                    'date' => Carbon::now()->format('Y-m-d'),
                ],
                'noted_by_approved' => $request->input('approved'),
                'noted_disapproved_due_to' => $request->input('remark'),
                'application_stage' => $request->input('application_stage')
            ];
        }

        if($request->input('type') == 'governor_approval'){
            $request->validate([
                'name' => 'required',
                'approved' => 'required',
                'remark' => 'required_if:approved,false',
            ]);
            $data = [
                'governor_approval_officer' => [
                    'personal_information_id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'position' => $request->input('position'),
                    'date' => Carbon::now()->format('Y-m-d'),
                ],
                'governor_approved' => $request->input('approved'),
                'gov_disapproved_due_to' => $request->input('remark'),
                'application_stage' => $request->input('application_stage')
            ];
        }

        if(!$request->input("type")){
            $data = $request->all();
        }

        LeaveApplication::find($id)->update($data);

        if ($request->input('application_stage') == 'approved') {
            return event(new LeaveProcessed(LeaveApplication::find($id)));
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        LeaveApplication::find($id)->delete();
    }
}
