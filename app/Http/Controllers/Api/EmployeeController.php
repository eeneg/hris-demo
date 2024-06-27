<?php

namespace App\Http\Controllers\Api;

use App\EmployeePDSEdit;
use App\EmployeePDSEditRequest;
use App\Http\Controllers\Controller;
use App\LeaveApplication;
use App\LeaveCredit;
use App\LeaveType;
use App\PersonalInformation;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PersonalInformation::find(Auth::user()->id);
    }

    public function getpdsEdits(Request $request)
    {
        $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                        ->leftJoin('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                        ->select(
                            'personal_informations.id as personal_information_id',
                            'personal_informations.firstname as firstname',
                            'personal_informations.surname as surname',
                            'personal_informations.nameextension as nameextension',
                            'employee_p_d_s_edit_requests.*'
                        )
                        ->where('employee_p_d_s_edit_requests.personal_information_id', '=', Auth::user()->id)
                        ->orderBy('employee_p_d_s_edit_requests.created_at', 'DESC')
                        ->paginate(10);

        return $editRequest;
    }

    public function getApplications(){

        $data = LeaveApplication::where('personal_information_id',  Auth::user()->id)->orderBy('created_at', 'DESC')
            ->select('leave_applications.*', 'personal_informations.surname','personal_informations.firstname','personal_informations.nameextension','leave_types.title as title')
            ->leftJoin('personal_informations', 'leave_applications.personal_information_id', '=', 'personal_informations.id')
            ->leftJoin('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->paginate(10);
        return $data;

    }

    public function getLeaveApplication(Request $request){

        $data = LeaveApplication::find($request->id);

        return $data;

    }

    public function getLeaveCredits(){
        $data = LeaveCredit::where('personal_information_id', Auth::user()->id)
        ->select('leave_credits.*', 'leave_types.title')
        ->leftJoin('leave_types', 'leave_credits.leave_type_id', '=', 'leave_types.id')
        ->get()
        ->map(fn($e) => ['title' => $e->title, 'balance' => $e->balance]);

        return $data;
    }

    public function getLeaveTypesForEmployee()
    {
        return LeaveType::all();
    }

    public function deleteLeaveApplication($id)
    {
        LeaveApplication::find($id)->delete();
    }

    public function submitLeaveApplication(Request $request)
    {

        $this->validate($request,
        [
            'personal_information_id' => 'required',
            'leave_type_id' => 'required',
        ],
        [
            'personal_information_id.required' => 'No Applicant Inserted',
            'leave_type_id.required' => 'Type of leave is required.',
        ]);

        return LeaveApplication::create($request->all());
    }

    public function editLeaveApplication(Request $request, $id)
    {
        $this->validate($request,
        [
            'personal_information_id' => 'required',
            'leave_type_id' => 'required',
        ],
        [
            'personal_information_id.required' => 'No Applicant Inserted',
            'leave_type_id.required' => 'Type of leave is required.',
        ]);

        return LeaveApplication::find($id)->update($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = PersonalInformation::find($request->id);

        $data = [];

        if (! count($employee->employeeEditRequests->where('status', 'PENDING'))) {
            $editRequest = $employee->employeeEditRequests()->create(['status' => 'PENDING']);

            foreach ($request->except('id') as $key => $value) {
                $data[] = [
                    'model_id' => isset($value['model_id']) ? $value['model_id'] : null,
                    'model' => isset($value['model']) ? $value['model'] : null,
                    'field' => isset($value['field']) ? $value['field'] : null,
                    'oldValue' => isset($value['oldValue']) ? $value['oldValue'] : null,
                    'newValue' => isset($value['newValue']) ? $value['newValue'] : null,
                    'status' => isset($value['status']) ? $value['status'] : null,
                ];
            }

            $insert = $editRequest->employeeEdits()->createMany($data);
        } else {
            abort(401, 'Can only have one requests at a time');
        }
    }

    public function edit(Request $request)
    {
        $editsRequest = PersonalInformation::find($request->id)->employeeEditRequests->where('status', 'PENDING');

        if (count($editsRequest)) {
            abort(401, 'Can only have one requests at a time');
        } else {
            return PersonalInformation::find($request->id);
        }
    }

    public function cancelEdits(Request $request)
    {
        $ar = [];

        $cancel = EmployeePDSEdit::whereIn('id', $request->all())->delete();

        $editRequest = EmployeePDSEditRequest::where('personal_information_id', Auth::user()->id)->first();

        if ($cancel) {
            foreach ($editRequest->employeeEdits as $value) {
                array_push($ar, $value->status);
            }

            if (! in_array('PENDING', $ar) && ! in_array('DENIED', $ar)) {
                $editRequest->update(['status' => 'APPROVED']);
            } elseif (! in_array('PENDING', $ar) && ! in_array('APPROVED', $ar)) {
                $editRequest->update(['status' => 'DENIED']);
            } elseif (! in_array('PENDING', $ar)) {
                $editRequest->update(['status' => 'VALIDATED']);
            }

            if (count($editRequest->employeeEdits) == 0) {
                $editRequest->delete();
            }
        }
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
        $editRequest = EmployeePDSEditRequest::find($id);

        if (count($editRequest->employeeEdits->where('status', '!=', 'PENDING')) == 0) {
            $editRequest->delete();
        } else {
            abort(401, 'Cannot cancel validated requests');
        }
    }
}
