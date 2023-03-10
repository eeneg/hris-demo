<?php

namespace App\Http\Controllers\Api;

use App\EmployeeServiceRecord;
use App\Http\Controllers\Controller;
use App\SalaryGrade;
use App\ServiceRecord;
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
       $data = EmployeeServiceRecord::select('employee_service_records.*', 'positions.title as position_title', 'departments.description as dept_name')
       ->where('employee_service_records.service_record_id',  $id)
       ->leftJoin('positions', 'employee_service_records.position_id', '=', 'positions.id')
       ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
       ->orderBy('created_at', 'DESC')
       ->get();

       return view('reports.service-record', compact('data'));
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
