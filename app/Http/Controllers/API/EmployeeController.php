<?php

namespace App\Http\Controllers\API;

use App\EmployeePDSEditRequest;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
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
                        )->orderBy('employee_p_d_s_edit_requests.created_at', 'DESC')->paginate(10);

        return $editRequest;
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

        if(!count($employee->employeeEditRequests->where('status', 'PENDING')))
        {
            $editRequest = $employee->employeeEditRequests()->create(['status' => 'PENDING']);

            foreach ($request->except('id') as $key => $value) {
                $editRequest->employeeEdits()->create([
                    'model_id'  => isset($value['model_id']) ? $value['model_id'] : '',
                    'model'     => isset($value['model']) ? $value['model'] : '',
                    'field'     => isset($value['field']) ? $value['field'] : '',
                    'oldValue'  => isset($value['oldValue']) ? $value['oldValue'] : '',
                    'newValue'  => isset($value['newValue']) ? $value['newValue'] : '',
                    'status'    => isset($value['status']) ? $value['status'] : '',
                ]);
            }
        }else{
            abort(401, 'Can only have one requests at a time');
        }
    }

    public function edit(Request $request)
    {
        $editsRequest = PersonalInformation::find($request->id)->employeeEditRequests->where('status', 'PENDING');

        if(count($editsRequest)){
            abort(401, 'Can only have one requests at a time');
        }else{
            return PersonalInformation::find($request->id);
        }
    }

    public function employeeEdits(Request $request)
    {

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
