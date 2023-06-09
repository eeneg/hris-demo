<?php

namespace App\Http\Controllers\Api;

use App\EmployeeServiceRecord;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\ServiceRecord;
use App\Setting;
use App\UserAssignment;
use Exception;
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
        return EmployeeServiceRecord::where('service_record_id', $request->id)->orderBy('orderNo', 'ASC')->get();
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
        ]);

        EmployeeServiceRecord::create($request->all());

    }

    public function overwiteServiceRecord(Request $request)
    {
        $service_record = ServiceRecord::find($request->service_record_id);

        try{

            $service_record->employeeservicerecord()->delete();

        }catch(Exception $e){

            return $e->getMessage();

        }

        $service_record->employeeservicerecord()->createMany($request->data);
    }

    public function addToExistingServiceRecord(Request $request)
    {
        $service_record = ServiceRecord::find($request->service_record_id);
        $largestOrderNo = $service_record->employeeservicerecord()->max('orderNo') + 1;

        $record = [];

        foreach($request->data as $key => $data)
        {
            $data['orderNo'] = $largestOrderNo++;
            array_push($record, $data);
        }

        $service_record->employeeservicerecord()->createMany($record);
    }

    public function addServiceRecord(Request $request)
    {
        $service_record = ServiceRecord::find($request->service_record_id);
        $service_record->employeeservicerecord()->createMany($request->data);
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

       $data = EmployeeServiceRecord::where('service_record_id', $id)->orderBy('created_at', 'DESC')->get()->chunk(18);

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
            'position' => 'required',
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
