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
            $maxG = $sg[$key]->max('grade');
            $maxS = $sg[$key]->max('step');
            for ($i=0; $i < $maxG + 1; $i++)
            {
                for ($x=0; $x < $maxS + 1; $x++)
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
        $request->validate(['amount' => 'numeric', 'tranche' => 'string', 'effectiv_date' => 'date']);

        SalaryGrade::create($request->all());
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

        $this->validate($request, ['amount' => 'required|numeric']);

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
