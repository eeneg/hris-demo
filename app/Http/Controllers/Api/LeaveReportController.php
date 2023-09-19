<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LeaveReport;
use App\LeaveSummary;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\Setting;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return LeaveReport::orderBy('created_at', 'DESC')->paginate(15);
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
        $this->validate($request,
            [
                'title' => 'required',
                'year' => 'required',
                'month' => 'required',
            ],
            [
                'title.required' => 'Title Required',
                'year.required' => 'Year Required',
                'month.required' => 'Month Required',
            ]);

        $i = LeaveSummary::where(function ($query) {
                    $query->orWhere('particulars->leave_type', 'Tardy')
                    ->orWhere('particulars->leave_type', 'Undertime')
                    ->orWhere('particulars->leave_type', 'UA')
                    ->orWhere('particulars->leave_type', 'AWOL');
                })
                ->get()
                ->filter(function ($e) {
                    if (($e->particulars->leave_type == 'UA' || $e->particulars->leave_type == 'AWOL') && $e->particulars->count >= 2) {
                        return $e;
                    } elseif (($e->particulars->leave_type == 'Tardy' || $e->particulars->leave_type == 'Undertime') && $e->particulars->count >= 10) {
                        return $e;
                    }
                })
                ->filter(function ($e) use ($request) {
                    switch($e->period->mode) {
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
                            return  Carbon::parse($e->period->data[0]->date)->format('Y') == $request->year &&
                                    Carbon::parse($e->period->data[0]->date)->format('m') == $request->month;
                            break;
                    }
                })
                ->map(function ($e) {
                    $employee = PersonalInformation::find($e->personal_information_id);
                    $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
                    $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
                    $plantillacontents = PlantillaContent::where('plantilla_contents.plantilla_id', $plantilla->id)
                        ->where('personal_information_id', $e->personal_information_id)
                        ->first();

                    switch($e->period->mode) {
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
                            $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                            $date = $e->period->data[0]->date;
                            break;
                    }

                    return[
                        'employee' => $employee->firstname.' '.$employee->surname,
                        'month' => Carbon::parse($date)->format('F'),
                        'type' => $e->particulars->leave_type,
                        'mins' => $mins,
                        'count' => $e->particulars->count,
                        'office' => $plantillacontents->position->department->title ?? '',
                    ];
                });

        if (count($i) > 0) {
            foreach ($i as $data) {
                $ar[$data['employee']]['office'] = $data['office'];
                $ar[$data['employee']][$data['type']] = ['mins' => $data['mins'], 'count' => $data['count']];
            }

            $d = ['month' => $request->month, 'year' => $request->year, 'records' => $ar, 'prep' => $request->preparedBy, 'noted' => $request->notedBy];

            $pdf = PDF::loadView('reports/leave_report', compact('d'))
                    ->setPaper('legal', 'landscape')
                    ->setOptions([
                        'defaultMediaType' => 'screen',
                        'dpi' => 120,
                    ]);

            $id = LeaveReport::generateUuid();

            $i = LeaveReport::create([
                'id' => $id,
                'title' => $request->title,
                'file_name' => $id.'.pdf',
                'path' => '/storage/leave_reports/'.$id.'.pdf',
            ]);

            Storage::put('public/leave_reports/'.$id.'.pdf', $pdf->output());

            return ['title' => $id.'.pdf'];
        } else {
            return abort(401, 'Empty Record');
        }
    }

    public function generateForeignTravelReport(Request $request)
    {

        $data = LeaveSummary::where('foreign_travel', 1)->get()
            ->filter(function ($leave) use ($request) {
                switch($leave->period->mode) {
                    case 1:
                    case 4:
                        $date = Carbon::parse($leave->period->data)->format('F') == $request->month && Carbon::parse($leave->period->data)->format('Y') == $request->year;
                        if ($date) {
                            return $leave;
                        }
                        break;
                    case 2:
                        $startMonth = Carbon::parse($leave->period->data->start)->format('F');
                        $endMonth = Carbon::parse($leave->period->data->end)->format('F');
                        $startYear = Carbon::parse($leave->period->data->start)->format('Y');
                        $endYear = Carbon::parse($leave->period->data->end)->format('Y');
                        if ($startMonth == $request->month && $startYear == $request->year || $endMonth == $request->month && $endYear == $request->year) {
                            return $leave;
                        }
                        break;
                    case 3:
                        foreach ($leave->period->data as $dates) {
                            if (Carbon::parse($dates->date)->format('F') == $request->month && Carbon::parse($dates->date)->format('Y') == $request->year) {
                                return $leave;
                                break;
                            }
                        }
                }
            })
            ->map(function ($leave) {
                $employee = DB::table('personal_informations')->where('id', $leave->personal_information_id)->first();
                $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
                $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
                $plantillacontents = PlantillaContent::where('plantilla_contents.plantilla_id', $plantilla->id)
                    ->where('personal_information_id', $leave->personal_information_id)
                    ->first();

                switch($leave->period->mode) {
                    case 1:
                        $date = Carbon::parse($leave->period->data)->format('F d, Y');
                        $leave_info = $leave->particulars->days;
                        break;
                    case 2:
                        $date = Carbon::parse($leave->period->data->start)->format('F d, Y').' to '.Carbon::parse($leave->period->data->end)->format('F d, Y');
                        $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                        break;
                    case 3:
                        $date = collect($leave->period->data)
                        ->sort()
                        ->map(function ($dates) {
                            return [
                                'month' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('F'),
                                'day' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('d'),
                                'year' => Carbon::parse($dates->date)->setTimeZone('Asia/Manila')->format('Y'),
                            ];
                        })
                        ->groupBy('month')
                        ->map(function ($dates, $index) {
                            return $index.' '.collect($dates)->map(fn ($e) => $e['day'])->join(', ').', '.$dates[0]['year'];
                        });
                        $date = collect($date)->join(' — ');
                        $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                        break;
                    case 4:
                        $date = Carbon::parse($leave->period->data)->format('F d, Y');
                        $leave_info = $leave->particulars->days ?? $leave->particulars->count;
                        break;
                }

                return  collect([
                    'name' => $employee->firstname.' '.ucfirst($employee->middlename[0] ?? '').'. '.$employee->surname,
                    'office' => $plantillacontents->position->department->title ?? '',
                    'leave_type' => $leave->particulars->leave_type,
                    'days' => $leave_info,
                    'inclusive_dates' => $date,
                ]);
            });

        if(count($data) > 0){
            $d = collect(['data' => $data, 'prepared_by' =>  $request->preparedBy, 'noted_by' =>  $request->notedBy, 'current_year' => $request->year, 'current_month' => $request->month]);

            $pdf = PDF::loadView('reports/foreign_travel_report', compact('d'))
            ->setPaper([0, 0, 952, 1456], 'port')
                    ->setOptions([
                        'defaultMediaType' => 'screen',
                        'dpi' => 112,
            ]);

            $id = LeaveReport::generateUuid();

            $i = LeaveReport::create([
                'id' => $id,
                'title' => $request->title,
                'file_name' => $id.'.pdf',
                'path' => '/storage/leave_reports/'.$id.'.pdf',
            ]);

            Storage::put('public/leave_reports/'.$id.'.pdf', $pdf->output());

            return ['title' => $id.'.pdf'];
        }else {
            return abort(401, 'Empty Record');
        }
    }

    public function generateWithoutPayReport(Request $request){
        $this->validate($request,
        [
            'title' => 'required',
            'year' => 'required',
            'month' => 'required',
        ],
        [
            'title.required' => 'Title Required',
            'year.required' => 'Year Required',
            'month.required' => 'Month Required',
        ]);

        $i = LeaveSummary::where('particulars->leave_type', $request->type)
        ->get()
        ->filter(function ($e) use ($request) {
            switch($e->period->mode) {
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
                    return  Carbon::parse($e->period->data[0]->date)->format('Y') == $request->year &&
                            Carbon::parse($e->period->data[0]->date)->format('m') == $request->month;
                    break;
            }
        })
        ->map(function ($e) {
            $employee = PersonalInformation::find($e->personal_information_id);
            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            $plantillacontents = PlantillaContent::where('plantilla_contents.plantilla_id', $plantilla->id)
                ->where('personal_information_id', $e->personal_information_id)
                ->first();

            switch($e->period->mode) {
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
                    $mins = ($e->particulars->hours * 60) + $e->particulars->mins;
                    $date = $e->period->data[0]->date;
                    break;
            }

            return[
                'name' => $employee->firstname.' '.$employee->surname,
                'month' => Carbon::parse($date)->format('F'),
                'type' => $e->particulars->leave_type,
                'mins' => $mins,
                'count' => $e->particulars->count ?? $e->particulars->days,
                'office' => $plantillacontents->position->department->title ?? '',
            ];
        });

        if(count($i) > 0){

        $d = collect(['data' => $i, 'type' => $request->type, 'prepared_by' =>  $request->preparedBy, 'noted_by' =>  $request->notedBy, 'current_year' => $request->year, 'current_month' => Carbon::create()->month($request->month)->format('F')]);

        $pdf = PDF::loadView('reports/withoutPayReport', compact('d'))
        ->setPaper([0, 0, 952, 1456], 'port')
                ->setOptions([
                    'defaultMediaType' => 'screen',
                    'dpi' => 112,
        ]);

        $id = LeaveReport::generateUuid();

        $i = LeaveReport::create([
            'id' => $id,
            'title' => $request->title,
            'file_name' => $id.'.pdf',
            'path' => '/storage/leave_reports/'.$id.'.pdf',
        ]);

        Storage::put('public/leave_reports/'.$id.'.pdf', $pdf->output());

        return ['title' => $id.'.pdf'];

        }else{
            return abort(401, 'Empty Record');
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
        Storage::delete('public/leave_reports/'.$id.'.pdf');

        LeaveReport::find($id)->delete();
    }
}
