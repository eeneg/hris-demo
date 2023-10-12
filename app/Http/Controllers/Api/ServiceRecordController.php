<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Plantilla;
use App\ServiceRecord;
use App\Setting;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PersonalInformation::orderBy('surname')->withOnly('servicerecord')
            ->get(['id', 'retirement_date', 'surname', 'firstname', 'middlename', 'nameextension'])
            ->map(function($e){
                return [
                    'id' => $e->id,
                    'retirement_date' => $e->retirement_date,
                    'name' => $e->fullname,
                    'service_record' => $e->servicerecord
                ];
            });
    }

    public function certifierEmployee(){
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();

        $employees = PersonalInformation::whereHas('plantillacontents', function ($query) use ($plantilla) {
            $query->where('plantilla_id', $plantilla->id);
        })->orderBy('surname')
        ->withOnly('servicerecord')
        ->get(['id', 'retirement_date', 'surname', 'firstname', 'middlename', 'nameextension'])
        ->map(function($e){
            return [
                'id' => $e->id,
                'retirement_date' => $e->retirement_date,
                'name' => $e->fullname,
                'service_record' => $e->servicerecord
            ];
        });

        return $employees;
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
            'personal_information_id' => 'required',
            'ORNo' => 'required',
            'dateCertified' => 'required',
            'dateIssued' => 'required',
            'certifier_id' => 'required',
            'amount' => 'required',
        ]);

        $data = ServiceRecord::updateOrCreate(['personal_information_id' => $request->personal_information_id], $request->all());

        return $data->id;
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

    public function retirementDate(Request $request)
    {
        PersonalInformation::find($request->id)->update(['retirement_date' => $request->retirement_date]);
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
