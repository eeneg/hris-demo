<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\SALN;
use App\SALN_Children;

class EmployeeSALNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $saln = Saln::where('personal_information_id', $request->id)->first();
        return $saln;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'declarant_fn' => 'required',
                'declarant_ln' => 'required',
                'declarant_mi' => 'required',
                'declarant_address' => 'required',
                'declarant_position' => 'required',
                'declarant_agency' => 'required',
                'declarant_office_address' => 'required',
                'date' => 'required',
                'gov_id1' => 'required',
                'idNo_id1' => 'required',
                'idDate_id1' => 'required',
            ],
            [
                'declarant_fn.required' => 'Field required',
                'declarant_ln.required' => 'Field required',
                'declarant_mi.required' => 'Field required',
                'declarant_address.required' => 'Field required',
                'declarant_position.required' => 'Field required',
                'declarant_agency.required' => 'Field required',
                'declarant_office_address.required' => 'Field required',
                'date.required' => 'Field required',
                'gov_id1.required' => 'Field required',
                'idNo_id1.required' => 'Field required',
                'idDate_id1.required' => 'Field required',
            ]
        );

        $saln = Saln::create($request->all());

        $record = Saln::find($saln->id);

        $children           = $record->children()->createMany($request->children);
        $realProperty       = $record->realProperty()->createMany($request->real_property);
        $personalProperty   = $record->personalProperty()->createMany($request->personal_property);
        $liability          = $record->liability()->createMany($request->liability);
        $business           = $record->business()->createMany($request->business);
        $relative           = $record->relative()->createMany($request->relative);

        return $saln->id;

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
        $this->validate($request, [
                'declarant_fn' => 'required',
                'declarant_ln' => 'required',
                'declarant_mi' => 'required',
                'declarant_address' => 'required',
                'declarant_position' => 'required',
                'declarant_agency' => 'required',
                'declarant_office_address' => 'required',
                'date' => 'required',
                'gov_id1' => 'required',
                'idNo_id1' => 'required',
                'idDate_id1' => 'required',
            ],
            [
                'declarant_fn.required' => 'Field required',
                'declarant_ln.required' => 'Field required',
                'declarant_mi.required' => 'Field required',
                'declarant_address.required' => 'Field required',
                'declarant_position.required' => 'Field required',
                'declarant_agency.required' => 'Field required',
                'declarant_office_address.required' => 'Field required',
                'date.required' => 'Field required',
                'gov_id1.required' => 'Field required',
                'idNo_id1.required' => 'Field required',
                'idDate_id1.required' => 'Field required',
            ]
        );

        $saln = Saln::find($id)->delete();

        $saln = Saln::create($request->all());

        $c = collect($request->all())->map(function ($e) use ($saln) {
            if(is_array($e)){
                return collect($e)->map(function($i) use ($saln){
                    $i['id'] = $i['id'] ?? Uuid::generate()->string;
                    $i['saln_id'] = $saln->id;
                    unset($i['created_at'], $i['updated_at']);
                    return $i;
                })->toArray();
            }
        })->toArray();

        $children           = $saln->children()->createMany($c['children']);
        $realProperty       = $saln->realProperty()->createMany($c['real_property']);
        $personalProperty   = $saln->personalProperty()->createMany($c['personal_property']);
        $liability          = $saln->liability()->createMany($c['liability']);
        $business           = $saln->business()->createMany($c['business']);
        $relative           = $saln->relative()->createMany($c['relative']);

        return $saln->id;

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

    public function printSaln($id){

        $saln = Saln::find($id);

        $saln_children          = $saln->children;
        $saln_realProperty      = $saln->realProperty;
        $saln_personalProperty  = $saln->personalProperty;
        $saln_liability         = $saln->liability;
        $saln_business          = $saln->business;
        $saln_relative          = $saln->relative;
        $saln                   = $saln->without('children','realProperty','personalProperty','liability','business','relative')->first();

        return view('reports.employee-saln', compact(
            'saln',
            'saln_children',
            'saln_realProperty',
            'saln_personalProperty',
            'saln_liability',
            'saln_business',
            'saln_relative',
        ));
    }
}
