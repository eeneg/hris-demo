<?php

namespace App\Http\Controllers\Api;

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
        $sc = SalarySchedule::orderBy('effective_date', 'desc')->get();
        return $sc;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');
        $request->validate(['tranche' => 'required|string', 'effective_date' => 'required|date']);

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
        $this->authorize('isAdministratorORAuthor');
        $sc = SalarySchedule::findOrFail($id);

        $request->validate(['tranche' => 'required|string', 'effective_date' => 'required|date']);

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
        $this->authorize('isAdministratorORAuthor');
        return SalarySchedule::findOrFail($id)->delete();
    }
}
