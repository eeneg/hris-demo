<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SALN;

class EmployeeSALNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $this->validate($request, [
                'declarant_fn' => 'required',
                'declarant_ln' => 'required',
                'declarant_mi' => 'required',
                'declarant_address' => 'required',
                'declarant_position' => 'required',
                'declarant_agency' => 'required',
                'declarant_office_address' => 'required',
                'spouse_ln' => 'required',
                'spouse_fn' => 'required',
                'spouse_mi' => 'required',
                'spouse_position' => 'required',
                'spouse_agency' => 'required',
                'spouse_agency_address' => 'required',
                'real_property_subtotal' => 'required',
                'personal_property_subtotal' => 'required',
                'total_asset' => 'required',
                'total_liability' => 'required',
                'net_worth' => 'required',
                'date' => 'required',
                'gov_id1' => 'required',
                'idNo_id1' => 'required',
                'idDate_id1' => 'required',
                'gov_id2' => 'required',
                'idNo_id2' => 'required',
                'idDate_id2' => 'required',
            ],
            [
                'declarant_fn.required' => 'Field required',
                'declarant_ln.required' => 'Field required',
                'declarant_mi.required' => 'Field required',
                'declarant_address.required' => 'Field required',
                'declarant_position.required' => 'Field required',
                'declarant_agency.required' => 'Field required',
                'declarant_office_address.required' => 'Field required',
                'gov_id1.required' => 'Field required',
                'idNo_id1.required' => 'Field required',
                'idDate_id1.required' => 'Field required',
            ]
        );

        $saln = Saln::create($request->all());

        $record = Saln::find($saln->id);

        $children           = $record->children()->createMany($request->children);
        $realProperty       = $record->realProperty()->createMany($request->real_properties);
        $personalProperty   = $record->personalProperty()->createMany($request->personal_properties);
        $liability          = $record->liability()->createMany($request->liabilities);
        $business           = $record->business()->createMany($request->business);
        $relative           = $record->relative()->createMany($request->relatives);

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
