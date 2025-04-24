<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveCreditResource;
use App\LeaveCredit;
use App\LeaveSummary;
use App\LeaveType;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\Position;
use App\Services\LeaveService;
use App\Setting;
use App\UserAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeaveCreditController extends Controller
{

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first();
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::without('department')->where('user_id', auth('api')->user()->id)->first()->department_id : '';

        $role = auth('api')->user()->role;

        if($department_id && $role == 'Office User' || $role == 'Office Head')
        {
            $employee = PlantillaContent::without(
                'plantilla',
                'salaryauthorized',
                'salaryproposed',
                'position'
            )
            ->select(
                'plantilla_contents.id',
                'plantilla_contents.plantilla_id',
                'plantilla_contents.personal_information_id',
                'plantilla_contents.position_id',
                'personal_informations.id',
                'personal_informations.firstname',
                'personal_informations.middlename',
                'personal_informations.surname',
                'personal_informations.nameextension',
                'personal_informations.civilstatus',
                'personal_informations.birthdate',
                'personal_informations.retirement_date',
                'personal_informations.status',
                'positions.department_id'
            )
            ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('personal_informations', 'plantilla_contents.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('reappointments', 'plantilla_contents.personal_information_id', '=', 'reappointments.personal_information_id')
            ->where('personal_informations.id', '!=', null)
            ->where('plantilla_id', $plantilla->id)
            ->where(function ($query) use ($department_id) {
                $query->where('reappointments.assigned_to', $department_id)
                ->orWhere('department_id', $department_id);
            })
            ->orderBy('surname')
            ->get();
        }else{
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
            ->select(
                'personal_informations.id',
                'personal_informations.firstname',
                'personal_informations.middlename',
                'personal_informations.surname',
                'personal_informations.nameextension',
                'personal_informations.civilstatus',
                'personal_informations.birthdate',
                'personal_informations.retirement_date',
                'personal_informations.status',
            )
            ->orderBy('surname')
            ->get();
        }

        return new LeaveCreditResource($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $forCreate = [];
        $forUpdate = [];

        $vl_balance = null;
        $sl_balance = null;

        $vl_id = LeaveType::where('title', 'Vacation Leave')->first()->id;
        $sl_id = LeaveType::where('title', 'Sick Leave')->first()->id;

        $collection = collect($request->data)->map(function ($leave) {
            $ll = collect($leave)->mapWithKeys(fn ($data, $key) => in_array($key, ['particulars', 'period']) ? [$key => json_encode($data)] : [$key => $data])->reject(fn ($data, $key) => in_array($key, ['newly_added']));

            return $ll;
        });

        $forUpdate = $collection->filter(fn ($summary) => $summary->has('id'));
        $forCreate = $collection->reject(fn ($summary) => $summary->has('id'))->map(fn ($summary) => $summary->put('id', Str::orderedUuid()->toString()));

        DB::transaction(function () use ($request, $forCreate, $forUpdate, $vl_id, $sl_id) {
            $vl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $vl_id], ['balance' => collect($request->data)->last()['vl_balance']]);
            $sl_balance = LeaveCredit::updateOrCreate(['personal_information_id' => $request['id'], 'leave_type_id' => $sl_id], ['balance' => collect($request->data)->last()['sl_balance']]);

            $create = LeaveSummary::insert($forCreate->toArray());
            $update = LeaveSummary::upsert($forUpdate->toArray(), 'id');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->leaveService->getLeaveDetails($id));
    }

    public function getEmployeesByDepartment($id){

        $default_plantilla  =   Setting::without('user')->where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::without('salaryproposedschedule', 'salaryauthorizedschedule')->where('year', $default_plantilla->value)->first();

        $positions = Position::where('department_id', $id)->get();
        $department = Department::find($id)->title;

        $employee = PlantillaContent::without(
            'plantilla',
            'salaryproposed',
            'position'
        )->select(
            'plantilla_contents.id',
            'plantilla_contents.plantilla_id',
            'plantilla_contents.personal_information_id',
            'personal_informations.firstname',
            'personal_informations.middlename',
            'personal_informations.surname',
            'personal_informations.nameextension',
            'personal_informations.civilstatus',
            'personal_informations.birthdate',
            'personal_informations.retirement_date',
            'personal_informations.status',
            'plantilla_contents.position_id',
            'positions.title as position_title',
            'departments.address as department_title',
            'salary_grades.grade as salary_grade',
        )
        ->leftJoin('personal_informations', 'plantilla_contents.personal_information_id', '=', 'personal_informations.id')
        ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
        ->leftJoin('salary_grades', 'plantilla_contents.salary_grade_auth_id', '=', 'salary_grades.id')
        ->where('personal_information_id', '!=', null)
        ->where('plantilla_id', $plantilla->id)
        ->whereIn('position_id', $positions->pluck('id'))
        ->orderBy('surname')
        ->paginate(10);

        return $employee;

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $summary = LeaveSummary::find($id);

        $vl_deduct = $summary->vl_earned - $summary->vl_withpay;
        $sl_deduct = $summary->sl_earned - $summary->sl_withpay;

        $vl_id = LeaveType::where('title', 'Vacation Leave')->first()->id;
        $sl_id = LeaveType::where('title', 'Sick Leave')->first()->id;

        $vl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $vl_id)->first();
        $sl_balance = LeaveCredit::where('personal_information_id', $summary->personal_information_id)->where('leave_type_id', $sl_id)->first();

        if ($vl_balance && $sl_balance) {
            $update_vl_balance = $vl_balance->update(['balance' => (float) $vl_balance->balance - (float) $vl_deduct]);
            $update_sl_balance = $sl_balance->update(['balance' => (float) $sl_balance->balance - (float) $sl_deduct]);
        }

        $summary->delete();
    }

    public function leaveCC(){

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
        ->select(
            'personal_informations.id',
            'personal_informations.firstname',
            'personal_informations.middlename',
            'personal_informations.surname',
        )
        ->with(['leavesummary' => function($query){
            $query->orderBy('sort');
        }])
        ->orderBy('surname')
        ->get();

        $correctionsCount = [];
        $strings = [];
        $noCorrections = 0;

        foreach($employees as $employee){
            $prevVLBalance = 0;
            $prevSLBalance = 0;
            $corrections = 0;

           if($employee->leavesummary){
                foreach($employee->leavesummary->sortBy('sort') as $leave){

                    $newVLBalance = round($prevVLBalance + $leave->vl_earned - (float)$leave->vl_withpay, 3); // Correct balance calculation
                    $newSLBalance = round($prevSLBalance + $leave->sl_earned - (float)$leave->sl_withpay, 3); // Correct balance calculation

                    // Check if correction is needed
                    if ($leave->vl_balance !== $newVLBalance || $leave->sl_balance !== $newSLBalance) {
                        $corrections++;

                        // LeaveSummary::find($leave->id)->update(['vl_balance' => $newVLBalance, 'sl_balance' => $newSLBalance]);
                    }

                    $prevVLBalance = $newVLBalance; // Carry over balance
                    $prevSLBalance = $newSLBalance; // Carry over balance

                }

                // $sl = LeaveType::where('abbreviation', 'SL')->first()->id;
                // $vl = LeaveType::where('abbreviation', 'VL')->first()->id;

                // $employee_vl = LeaveCredit::where('personal_information_id', $employee->id)->where('leave_type_id', $vl)->update(['balance' => $prevVLBalance]);
                // $employee_sl = LeaveCredit::where('personal_information_id', $employee->id)->where('leave_type_id', $sl)->update(['balance' => $prevSLBalance]);

                if($corrections > 0){
                    $correctionsCount[$employee->fullName] = $corrections;
                }else{
                    $noCorrections++;
                }
           }

        }

        return [$correctionsCount, $noCorrections];

    }
}

