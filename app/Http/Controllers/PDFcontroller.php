<?php

namespace App\Http\Controllers;

use App\Department;
use App\LeaveSummary;
use App\PersonalInformation;
use App\Plantilla;
use App\PlantillaContent;
use App\PlantillaDept;
use App\Position;
use App\SalarySchedule;
use App\Setting;
use App\Http\Resources\CSCResource;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class PDFcontroller extends Controller
{
    public function pds(Request $request)
    {
        $id = $request['id'];
        $personalinfos = PersonalInformation::findOrFail($id);
        $fb = PersonalInformation::findOrFail($id)->familybackground;
        $eb = PersonalInformation::findOrFail($id)->educationalbackground;
        $children = PersonalInformation::findOrFail($id)->children->skip(00)->take(12);
        $eligibilities = PersonalInformation::findOrFail($id)->eligibilities->skip(00)->take(07);
        $we = PersonalInformation::findOrFail($id)->workexperiences;
        $voluntaryworks = PersonalInformation::findOrFail($id)->voluntaryworks->skip(00)->take(07);
        $tp = PersonalInformation::findOrFail($id)->trainingprograms;
        $otherinfos = PersonalInformation::findOrFail($id)->otherinfos->skip(00)->take(07);
        $pdsquestions = PersonalInformation::findOrFail($id)->pdsquestion;

        $workExperiences = $we->skip(0)->take(28);
        $workExperiences_cont = $we->skip(28);

        $trainingPrograms = $tp->skip(0)->take(21);
        $trainingPrograms_cont = $tp->skip(21);

        $pdf = PDF::loadView('reports.PDS', compact('personalinfos', 'fb', 'eb', 'children', 'eligibilities', 'workExperiences', 'workExperiences_cont', 'voluntaryworks', 'trainingPrograms', 'trainingPrograms_cont', 'otherinfos', 'pdsquestions'))
            ->setPaper([0, 0, 590, 930], 'portrait')
            ->setOptions([
                'defaultMediaType' => 'screen',
                'dpi' => 112,
            ]);
        // ->download('PDS.pdf');
        Storage::put('public/employee_pds/'.$personalinfos->firstname.'.pdf', $pdf->output());

        return ['title' => $personalinfos->firstname];
    }

    public function plantilla(Request $request)
    {
        if ($request->type == 'DBM') {
            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            $department = Department::find($request->dept_id);
            $previous_plantilla = Plantilla::where('year', '!=', $plantilla->year)->latest('created_at')->first();

            $plantillacontents = PlantillaContent::whereHas('position', function ($q) use ($department) {
                $q->where('department_id', $department->id);
            })
                ->leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('plantilla_depts', function ($join) {
                    $join->on('departments.id', '=', 'plantilla_depts.department_id');
                    $join->on('plantilla_contents.plantilla_id', '=', 'plantilla_depts.plantilla_id');
                })
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->orderBy('plantilla_depts.order_number')->orderBy('plantilla_contents.order_number')->get();

            $data = [
                'plantillacontents' => $plantillacontents,
                'department' => $department,
                'previous_plantilla' => $previous_plantilla,
                'plantilla' => $plantilla,
            ];

            $pdf = PDF::loadView('reports/plantilla_dbm', $data)
                ->setPaper([0, 0, 1275, 1950], 'port')
                ->setOptions([
                    'defaultMediaType' => 'screen',
                    'dpi' => 112,
                ]);
            Storage::put('public/plantilla_reports/dbm.pdf', $pdf->output());

            return ['path' => '/storage/plantilla_reports/dbm.pdf'];
        } elseif ($request->type == 'CSC') {
            ini_set('max_execution_time', 300);
            ini_set('memory_limit', '2048M');

            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            $allplantillacontents = PlantillaContent::leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
                ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('plantilla_depts', function ($join) {
                    $join->on('departments.id', '=', 'plantilla_depts.department_id');
                    $join->on('plantilla_contents.plantilla_id', '=', 'plantilla_depts.plantilla_id');
                })
                ->where('plantilla_contents.plantilla_id', $plantilla->id)
                ->select('plantilla_contents.*')
                ->orderBy('plantilla_depts.order_number')->orderBy('plantilla_contents.order_number')->get();

            $data = [
                'plantillacontents' => $allplantillacontents,
                // 'plantillacontents' => json_decode((new CSCResource($allplantillacontents))->toJson(), true),
            ];



            $pdf = PDF::loadView('reports/plantilla_csc', $data)
                ->setPaper([0, 0, 952, 1456], 'landscape')
                ->setOptions([
                    'defaultMediaType' => 'screen',
                    'dpi' => 112,
                ]);
            Storage::put('public/plantilla_reports/csc.pdf', $pdf->output());

            return ['path' => '/storage/plantilla_reports/csc.pdf'];
        } else {
            $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
            $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
            $plantilla_depts = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get();
            $prev_plantilla = Plantilla::where('year', '!=', $plantilla->year)->latest('created_at')->first();

            $auth_grand_total = 0;
            $prop_grand_total = 0;
            $inc_dec_grand_total = 0;
            foreach ($plantilla_depts as $key => $dept) {
                $contents = PlantillaContent::where('plantilla_id', $plantilla->id)->with('position')->whereHas('position', function ($query) use ($dept) {
                    $query->where('department_id', $dept->department_id);
                })->orderBy('order_number', 'desc')->get();
                $auth_total = 0;
                $prop_total = 0;
                foreach ($contents as $key => $content) {
                    $auth_total = $auth_total + ($content->salaryauthorized != null ? $content->salaryauthorized->amount * 12 : 0);
                    $prop_total = $prop_total + ($content->salaryproposed != null ? $content->salaryproposed->amount * 12 : 0);
                }
                $inc_dec = $prop_total - $auth_total;
                $amount = new \stdClass();
                $amount->auth_total = number_format($auth_total, 2, '.', ',');
                $amount->prop_total = number_format($prop_total, 2, '.', ',');
                $amount->inc_dec = $inc_dec < 0 ? ('('.number_format(abs($inc_dec), 2, '.', ',').')') : number_format($inc_dec, 2, '.', ',');
                $dept->amount = $amount;

                // Totals
                $auth_grand_total = $auth_grand_total + $auth_total;
                $prop_grand_total = $prop_grand_total + $prop_total;
                $inc_dec_grand_total = $inc_dec_grand_total + $inc_dec;
            }

            $data = [
                'plantilla_depts' => $plantilla_depts,
                'current_year' => $plantilla->year,
                'previous_year' => $prev_plantilla->year,
                'auth_grand_total' => number_format($auth_grand_total, 2, '.', ','),
                'prop_grand_total' => number_format($prop_grand_total, 2, '.', ','),
                'inc_dec_grand_total' => $inc_dec_grand_total < 0 ? ('('.number_format(abs($inc_dec_grand_total), 2, '.', ',').')') : number_format($inc_dec_grand_total, 2, '.', ','),
            ];

            $pdf = PDF::loadView('reports/plantilla_summary', $data)
                ->setPaper([0, 0, 952, 1456], 'port')
                ->setOptions([
                    'defaultMediaType' => 'screen',
                    'dpi' => 112,
                ]);
            Storage::put('public/plantilla_reports/summary.pdf', $pdf->output());

            return ['path' => '/storage/plantilla_reports/summary.pdf'];
        }
    }

    public function sr(Request $request)
    {
        $pdf = PDF::loadView('reports/sr');
        // ->setPaper([0,0,1275,1950], 'port')
        // ->setOptions([
            //     'defaultMediaType' => 'screen',
            //     'dpi' => 112,
        // ])
        // ;
        Storage::put('public/pdf_reports/sr.pdf', $pdf->output());

        return ['title' => 'sr_test'];
    }

    public function nosi(Request $request)
    {
        $pdf = PDF::loadView('reports/nosi');
        // ->setPaper([0,0,1275,1950], 'landscape')
        // ->setOptions([
            //     'defaultMediaType' => 'screen',
            //     'dpi' => 112,
        // ])
        // ;
        Storage::put('public/pdf_reports/nosi.pdf', $pdf->output());

        return ['title' => 'nosi_test'];
    }

    public function nosa(Request $request)
    {
        $pdf = PDF::loadView('reports/nosa');
        // ->setPaper([0,0,1275,1950], 'landscape')
        // ->setOptions([
            //     'defaultMediaType' => 'screen',
            //     'dpi' => 112,
        // ])
        // ;
        Storage::put('public/pdf_reports/nosa.pdf', $pdf->output());

        return ['title' => 'nosa_test'];
    }

    public function employeeId(Request $request)
    {
        $request->validate(['name' => 'required|string', 'address' => 'required|string', 'signature' => 'required|file|image']);

        $employee = PersonalInformation::findOrFail($request['id']);
        $id = PersonalInformation::findOrFail($employee->id)->plantillacontents;
        $position = Position::findOrFail($id[0]->position_id);
        $dept = Department::findOrFail($position->department_id);

        $img = $request->file('signature')->storeAs('/public/employee_id_files/signatures', $employee->id.'.png');

        $data = [
            'employee' => $employee,
            'position' => $position,
            'dept' => str_replace([' - ', ' / ', ' '], '-', $dept->title),
            'contact' => (object) ['name' => $request->name, 'address' => $request->address, 'signature' => $employee->id],
            'code' => $employee->barcode->value,
            'qrcode' => $employee->firstname.' '.$employee->middlename[0].'. '.$employee->surname.PHP_EOL.$position->title.PHP_EOL.'Provincial Government of Davao del Sur',
        ];

        $pdf = PDF::loadView('reports/employee-id', $data);

        Storage::put('public/employee_ids/'.$employee->firstname.'.pdf', $pdf->output());

        // return $pdf->download('invoice.pdf');
        return ['title' => $employee->firstname];
    }

    public function generateleavecard(Request $request)
    {
        $employee = PersonalInformation::find($request->id);

        $employee_name = $employee->surname.', '.$employee->firstname.' '.$employee->middlename[0].'. '.$employee->nameextension;

        $id = PersonalInformation::findOrFail($employee->id)->plantillacontents->first();
        $position = Position::findOrFail($id->position_id);
        $dept = Department::findOrFail($position->department_id);

        $data = LeaveSummary::where('personal_information_id', $request->id)->orderBy('sort')->get();

        $pdf = PDF::loadView('reports/employee-leavecard', compact('data', 'employee_name', 'position', 'dept', 'employee', 'id'))->setPaper('legal', 'landscape');

        Storage::put('public/employee_leave_card/'.$employee->surname.'.pdf', $pdf->output());

        return ['title' => $employee->surname.'.pdf'];
    }

    public function generatesalarysched(Request $request)
    {
        $sg = SalarySchedule::find($request->tranche)->salarygrades->sortBy('created_at');
        $tranche = SalarySchedule::find($request->tranche)->tranche;
        $salarysched = collect();

        foreach ($sg->sortBy('grade')->groupBy('grade') as $data) {
            foreach ($data as $value) {
                $value['annual'] = $value->amount * 12;
            }

            $salarysched->push(($data)->sortBy('step')->values());
        }

        $pdf = PDF::loadView('reports/salary-sched', compact('salarysched', 'tranche'));

        Storage::put('public/salary_sched_report/'. \Str::kebab($tranche) .'.pdf', $pdf->output());

        return ['title' => \Str::kebab($tranche) .'.pdf'];
    }
}
