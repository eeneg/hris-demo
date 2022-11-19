<?php

namespace App\Http\Controllers\Api;

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
            $sg = SalarySchedule::findOrFail($request->id)->salarygrades->sortBy('created_at');
            $ar = [];

            foreach($sg->groupBy('grade') as $data)
            {
                foreach($data as $value)
                {
                    $value['annual'] = $value->amount * 12;
                }

                array_push($ar, collect($data)->sortBy('step')->values());
            }

            return $ar;
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

        for ($i=0; $i < 8; $i++) {

            $salarysched->salarygrades()->create(['amount' => isset($request->amount[$i]) ? $request->amount[$i] : 0, 'grade' => $request->grade, 'step' => $i + 1]);

        }
    }

    public function deleteSalaryGrade(Request $request)
    {
        return SalaryGrade::whereIn('id', $request->all())->delete();
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

        $check = SalaryGrade::where(['grade' => $request->grade, 'salary_sched_id' => $request->tranche])->exists();

        $grade = SalaryGrade::find($request->id[0]);

        if($grade->grade != $request->grade && $check)
        {
            return ['message' => 'error'];
        }else{
            foreach($request->id as $key => $id)
            {
                $salarygrade = SalaryGrade::findOrFail($id);


                $salarygrade->update(['amount' => isset($request->amount[$key]) ? $request->amount[$key] : 0, 'grade' => $request->grade]);
            }
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
