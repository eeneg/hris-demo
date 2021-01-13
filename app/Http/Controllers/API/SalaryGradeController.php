<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SalaryGrade;
use App\SalarySchedule;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->id != null)
        {
            $sg = SalarySchedule::findOrFail($request->id)->salarygrades;
            $cl = collect();

            $maxG = $sg->max('grade');
            $maxS = $sg->max('step');
            for ($i=0; $i < $maxG + 1; $i++)
            {
                for ($x=0; $x < $maxS + 1; $x++)
                {
                    $temp = $sg->where('grade', $i)->where('step', $x)->first();
                    isset($temp) ? $cl->push($temp) : '';
                }
            }

            return $cl;
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
        $salarysched = SalarySchedule::find($request->id);

        $request->validate(['grade' => 'required|numeric']);

        foreach($request->amount as $key => $amount)
        {
            $salarysched->salarygrades()->create(['amount' => $amount, 'grade' => $request->grade, 'step' => $key + 1]);
        }

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
    public function update(Request $request)
    {
        $request->validate(['grade' => 'required|numeric']);

        foreach($request->id as $key => $id)
        {
            $salarysched = SalaryGrade::findOrFail($id);

            $salarysched->update(['amount' => $request->amount[$key], 'grade' => $request->grade]);
        }
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
