<?php

namespace App\Http\Controllers\API;

use App\EmployeePDSEdit;
use App\EmployeePDSEditRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                            )->orderBy('employee_p_d_s_edit_requests.created_at', 'DESC');
        }else if($request->search || $request->to || $request->from){
            $editRequest = EmployeePDSEditRequest::select('employee_p_d_s_edit_requests.*')
                            ->join('personal_informations', 'employee_p_d_s_edit_requests.personal_information_id', '=', 'personal_informations.id')
                            ->select(
                                'personal_informations.id as personal_information_id',
                                'personal_informations.firstname as firstname',
                                'personal_informations.surname as surname',
                                'personal_informations.nameextension as nameextension',
                                'employee_p_d_s_edit_requests.*',
                            )
                            ->orWhere('surname', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('firstname', 'LIKE', '%'.$request->search.'%')
                            ->orWhere(DB::raw("CONCAT(`firstname`, ' ', `surname`)"), 'LIKE', '%'.$request->search.'%')
                            ->orderBy('employee_p_d_s_edit_requests.created_at', 'DESC');
        }

        return $editRequest->paginate(10);
    }

    public function acceptEditRequest(Request $request)
    {
        $edits = $request->except('id');

        $ar = [];

        if(count($edits) > 0){
            EmployeePDSEdit::where('employee_edit_request_id', $request->id)->whereIn('id', $edits)->update(['status' => 'APPROVED']);
            EmployeePDSEdit::where('employee_edit_request_id', $request->id)->whereNotIn('id', $edits)->update(['status' => 'DENIED']);
        }else{
            EmployeePDSEdit::where('employee_edit_request_id', $request->id)->whereNotIn('id', $edits)->update(['status' => 'DENIED']);
        }


        $editRequest = EmployeePDSEdit::where('employee_edit_request_id', $request->id)->get();

        foreach($editRequest as $value)
        {
            array_push($ar, $value->status);
        }


        if(in_array('APPROVED', $ar) && !in_array('PENDING', $ar) && !in_array('DENIED', $ar)){
            EmployeePDSEditRequest::find($request->id)->update(['status' => 'APPROVED']);
        }else if(in_array('DENIED', $ar) && !in_array('PENDING', $ar) && !in_array('APPROVED', $ar)){
            EmployeePDSEditRequest::find($request->id)->update(['status' => 'DENIED']);
        }else{
            EmployeePDSEditRequest::find($request->id)->update(['status' => 'REVIEWED']);
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
        //
    }
}
