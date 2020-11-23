<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SalaryGrade;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sg = SalaryGrade::all()->groupBy('tranche');
        $cl = collect();

        foreach($sg->keys() as $key)
        {
            for ($i=0; $i < $sg[$key]->max('grade') + 1; $i++)
            {
                for ($x=0; $x < $sg[$key]->max('step') + 1; $x++)
                {
                    $temp = $sg[$key]->where('grade', $i)->where('step', $x)->first();
                    isset($temp) ? $cl->push($temp) : '';
                }
            }
        }

        return $cl->groupBy('tranche');
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
        $salarysched = SalaryGrade::findOrFail($id);

        if($request->amount == null)
        {
            $request->merge(['amount' => 0]);
        }

        $salarysched->update($request->all());
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
