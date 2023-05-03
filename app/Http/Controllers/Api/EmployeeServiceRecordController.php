<?php

namespace App\Http\Controllers\Api;

use App\EmployeeServiceRecord;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\SalaryGrade;
use App\ServiceRecord;
use App\Setting;
use App\UserAssignment;
use Illuminate\Http\Request;

class EmployeeServiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return EmployeeServiceRecord::select('employee_service_records.*', 'positions.title as position_title', 'departments.description as dept_name')
        ->where('employee_service_records.service_record_id',  $request->id)
        ->leftJoin('positions', 'employee_service_records.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_record_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'position_id' => 'required',
            'status' => 'required',
            'salary' => 'required',
            'station' => 'required',
            'branch' => 'required',
            'pay' => 'required',
            'remark' => 'required',
            'date' => 'required',
            'cause'  => 'required'
        ]);

        EmployeeServiceRecord::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $default_plantilla  =   Setting::where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::where('year', $default_plantilla->value)->first();
        $department_id      =   auth('api')->user()->role == 'Office User' || auth('api')->user()->role == 'Office Head'  ?
                                UserAssignment::where('user_id', auth('api')->user()->id)->first()->department_id : '';

       $data = EmployeeServiceRecord::select('employee_service_records.*', 'positions.title as position_title', 'departments.description as dept_name')
       ->where('employee_service_records.service_record_id',  $id)
       ->leftJoin('positions', 'employee_service_records.position_id', '=', 'positions.id')
       ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
       ->orderBy('created_at', 'DESC')
       ->get()
       ->chunk(18);

       $sr = ServiceRecord::find($id);

       $employee = PersonalInformation::find($sr->personal_information_id)->withoutRelations();

       $certName = PersonalInformation::find($sr->certifier_id)->getFullNameAttribute();

       $certPos = PlantillaContent::where('personal_information_id', $sr->certifier_id)->where('plantilla_id', $plantilla->id)->withOnly('position',)->first()->position->title;

       return view('reports.service-record', compact('data','sr', 'employee', 'certName', 'certPos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $request->validate([
            'service_record_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'position_id' => 'required',
            'status' => 'required',
            'salary' => 'required',
            'station' => 'required',
            'branch' => 'required',
            'pay' => 'required',
            'remark' => 'required',
            'date' => 'required',
            'cause'  => 'required'
        ]);

        EmployeeServiceRecord::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmployeeServiceRecord::find($id)->delete();
    }
}
