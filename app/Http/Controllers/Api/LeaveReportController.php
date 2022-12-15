<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LeaveReport;
use App\LeaveSummary;
use App\PersonalInformation;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LeaveReport::paginate(15);
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

        $pdf = PDF::loadView('reports/salary-sched', compact('salarysched', 'tranche'));

        Storage::put('public/salary_sched_report/' . $tranche .'.pdf', $pdf->output());

        return ['title' => $tranche . '.pdf'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function generateReport(Request $request)
    {
        $this->validate($request,
        [
            'year' => 'required',
            'month' => 'required'
        ],
        [
            'year.required' => 'Year Required',
            'month.required' => 'Months Required'
        ]);

        $i = LeaveSummary::
                where(function ($query) {
                    $query->orWhere('particulars->leave_type', 'Tardy')
                    ->orWhere('particulars->leave_type', 'Undertime')
                    ->orWhere('particulars->leave_type', 'UA');
                })->where('particulars->count', '<', 10)
                ->get()
                ->filter(function($e) use ($request) {

                    switch($e->period->mode){
                        case 1:
                        case 4:
                            return  Carbon::parse($e->period->data)->format('Y') == $request->year &&
                                    Carbon::parse($e->period->data)->format('m') == $request->month;
                            break;
                        case 2:
                            return  Carbon::parse($e->period->data->start)->format('Y') == $request->year &&
                                    Carbon::parse($e->period->data->start)->format('m') == $request->month;
                            break;
                        case 3:
                            break;
                    }

                })
                ->map( function($e){

                    $employee = PersonalInformation::find($e->personal_information_id);
                    $office = $employee->plantillacontents->first();

                    switch($e->period->mode)
                    {
                        case 1:
                        case 4:
                            $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                            $date = $e->period->data;
                            break;
                        case 2:
                            $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                            $date = $e->period->data->start;
                            break;
                        case 3:
                            break;
                    }


                    return[
                        'employee'  => $employee->firstname . ' ' . $employee->surname,
                        'month' => Carbon::parse($date)->format('m'),
                        'type' => $e->particulars->leave_type,
                        'mins' => $mins,
                        'count' => $e->particulars->count,
                        'office' => $office
                    ];

                });



                foreach($i as $data)
                {
                    $ar[$data['employee']][$data['type']] = ['mins' => $data['mins'], 'count' => $data['count'], 'office' => $data['office']];
                }

                // $this->pdfGenerate(['month' => $request->month, 'records' => $ar]);

                $d = ['month' => $request->month, 'records' => $ar];

                $pdf = PDF::loadView('reports/leave_report', compact('d'))
                        ->setPaper('legal', 'landscape')
                        ->setOptions([
                            'defaultMediaType' => 'screen',
                            'dpi' => 120,
                        ]);

                Storage::put('public/leave_reports/' . 'asd' .'.pdf', $pdf->output());

                return ['title' => 'asd' . '.pdf'];

    }

    public function pdfGenerate($d)
    {
        $pdf = PDF::loadView('reports/leave_report', compact('d'))->setPaper('legal', 'landscape');

        Storage::put('public/leave_reports/' . 'asd' .'.pdf', $pdf->output());

        return ['title' => 'asd' . '.pdf'];
    }
}
