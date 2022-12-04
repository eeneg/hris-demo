<?php

namespace App\Http\Controllers\Api;

use App\EmployeePDSEdit;
use App\EmployeePDSEditRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\EditRequestApproved;
use App\FamilyBackground;
use App\PersonalInformation;
use Throwable;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->search)
        {
            $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                            ->join('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.firstname as firstname',
                                'personal_informations.surname as surname',
                                'personal_informations.nameextension as nameextension',
                                'employee_p_d_s_edit_requests.*',
                            )
                            ->where('employee_p_d_s_edit_requests.status', '=', 'PENDING')
                            ->orderBy('employee_p_d_s_edit_requests.created_at', 'ASC')
                            ->paginate(10);

            return $editRequest;

        }else if($request->search){
            $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                            ->join('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.firstname as firstname',
                                'personal_informations.surname as surname',
                                'personal_informations.nameextension as nameextension',
                                'employee_p_d_s_edit_requests.*'
                            )
                            ->where('employee_p_d_s_edit_requests.status', '=', 'PENDING')
                            ->where(function ($query) use ($request) {
                                $query->where('surname', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                                    ->orderBy('employee_p_d_s_edit_requests.created_at', 'ASC');
                            })
                            ->paginate(10);

            return $editRequest;
        }

    }

    public function reviewedRequest(Request $request)
    {
        if(!$request->search)
        {
            $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                            ->join('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.firstname as firstname',
                                'personal_informations.surname as surname',
                                'personal_informations.nameextension as nameextension',
                                'employee_p_d_s_edit_requests.*',
                            )
                            ->where('employee_p_d_s_edit_requests.status', '!=', 'PENDING')
                            ->orderBy('employee_p_d_s_edit_requests.updated_at', 'ASC')
                            ->paginate(10);

            return $editRequest;

        }else if($request->search){
            $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                            ->join('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.firstname as firstname',
                                'personal_informations.surname as surname',
                                'personal_informations.nameextension as nameextension',
                                'employee_p_d_s_edit_requests.*',
                            )
                            ->where('employee_p_d_s_edit_requests.status', '!=', 'PENDING')
                            ->where(function ($query) use ($request) {
                                $query->where('surname', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                                    ->orderBy('employee_p_d_s_edit_requests.created_at', 'ASC');
                            })
                            ->paginate(10);

            return $editRequest;
        }

    }

    public function acceptEditRequest(Request $request)
    {
        $edits = $request->except('id');

        $ar = [];
        $data = '';

        if(count($edits['accept']) > 0){
            EmployeePDSEdit::whereIn('id', $edits['accept'])->update(['status' => 'APPROVED']);
        }

        if(count($edits['deny']) > 0){
            EmployeePDSEdit::whereIn('id', $edits['deny'])->update(['status' => 'DENIED']);
        }

        $data = EmployeePDSEditRequest::find($request->id);

        foreach($data->employeeEdits as $value)
        {
            array_push($ar, $value->status);
        }

        if(!in_array('PENDING', $ar) && !in_array('DENIED', $ar)){
            $data->update(['status' => 'APPROVED']);
        }else if (!in_array('PENDING', $ar) && !in_array('APPROVED', $ar)){
            $data->update(['status' => 'DENIED']);
        }else if(!in_array('PENDING', $ar)){
            $data->update(['status' => 'VALIDATED']);
        }

        if($data != '' || $data != null)
        {
            event(new EditRequestApproved($data));
            $this->deleteEmptyRecords($data->personal_information_id);
        }
    }

    public function revertRequest(Request $request)
    {

        $edits = $request->except(['id', 'requestID']);

        $employee = PersonalInformation::find($request->id);

        $obj = array(
            'children' => [],
            'eligibilities' => [],
            'workexperiences' => [],
            'voluntaryworks' => [],
            'trainingprograms' => [],
            'otherinfos' => [],
        );

        $edit_id = [];

        foreach($edits as $data)
        {

            $record = EmployeePDSEdit::find($data);

            if($record['status'] == 'APPROVED' && $record['model'] == 'personalinformation')
            {
                $employee->update([$record['field'] => $record['oldValue']]);
                $record->update(['status' => 'PENDING']);
            }
            else if(($record['status'] == 'APPROVED') && $record['model'] == 'familybackground' || $record['model'] == 'educationalbackground' || $record['model'] == 'pdsquestion'){
                $model = $record['model'];
                $employee->$model()->updateOrCreate(['personal_information_id' => $employee->id], [$record['field'] => $record['oldValue']]);
                $record->update(['status' => 'PENDING']);
            }
            else if(($record['status'] == 'APPROVED')){
                $model = $record['model'];
                $obj[$model][$record['model_id']][$record['field']] =  $record['oldValue'];
                array_push($edit_id, $data);
            }
            else if(($record['status'] == 'DENIED')){
                    $record->update(['status' => 'PENDING']);
            }
        }

        foreach($obj as $model => $record)
        {
            if(count($record) > 0)
            {
                foreach($record as $key => $data)
                {
                    $record = $employee->$model()->updateOrCreate(['id' => $key], $data);
                }
            }
        }


        if(count($edit_id) > 0)
        {
            EmployeePDSEdit::whereIn('id', $edit_id)->update(['status' => 'PENDING']);
        }

        if(isset($edits[0]))
        {
            EmployeePDSEditRequest::find($request->requestID)->update(['status' => 'PENDING']);
        }


        $this->deleteEmptyRecords($request->id);
    }

    public function deleteEmptyRecords($id)
    {
        $models = ['familybackground', 'children', 'educationalbackground', 'eligibilities',
                    'otherinfos', 'workexperiences', 'voluntaryworks', 'trainingprograms', 'pdsquestion',];

        $employee = PersonalInformation::find($id);

        $record = null;

        foreach($models as $data)
        {
            if($data == 'familybackground' || $data == 'educationalbackground' || $data == 'pdsquestion')
            {
                if(isset($employee->$data))
                {
                    $record = collect($employee->$data)->except(['id', 'personal_information_id', 'created_at', 'updated_at'])->toArray();
                }

                if($record && count(array_filter($record, function ($a) { return $a !== null && $a != "";})) == 0)
                {
                    $employee->$data()->delete();
                }
            }else{
                foreach($employee->$data as $value)
                {
                    if(isset($value))
                    {
                        $record = collect($value)->except(['id', 'personal_information_id', 'created_at', 'updated_at', 'orderNo'])->toArray();
                    }

                    if($record && count(array_filter($record, function ($a) { return $a !== null && $a != "";})) == 0)
                    {
                        $employee->$data->find($value->id)->delete();
                    }
                }
            }
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
        $data = EmployeePDSEditRequest::find($id);

        $data->delete();
    }
}
