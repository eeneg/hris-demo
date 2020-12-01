<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SalarySchedule;
use Illuminate\Http\Request;

class SalaryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sc = SalarySchedule::all();

        return $sc;
    }

    public function getSalaryGrades(Request $request)
    {
        // $sg = SalarySchedule::findOrFail($request)->salarygrade;

        return 'fuck';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['tranche' => 'string|required', 'effective_date' => 'date|required']);

        SalarySchedule::create($request->all());
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
        $sc = SalarySchedule::findOrFail($id);

        $request->validate(['tranche' => 'string|required', 'effective_date' => 'date|required']);

        $sc->update($request->all());
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
