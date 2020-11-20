<?php

namespace App\Http\Controllers;

use App\Child;
use App\EducationalBackground;
use App\Eligibility;
use App\FamilyBackground;
use App\PersonalInformation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
// use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class PDFcontroller extends Controller
{
    public function pds(Request $request)
    {
        $id = $request['id'];
        $personalinfos      =  PersonalInformation::findOrFail($id);
        $fb                 =  PersonalInformation::findOrFail($id)->familybackground;
        $eb                 =  PersonalInformation::findOrFail($id)->educationalbackground;
        $children           =  PersonalInformation::findOrFail($id)->children->skip(00)->take(12);
        $eligibilities      =  PersonalInformation::findOrFail($id)->eligibilities->skip(00)->take(07);
        $we                 =  PersonalInformation::findOrFail($id)->workexperiences;
        $voluntaryworks     =  PersonalInformation::findOrFail($id)->voluntaryworks->skip(00)->take(07);
        $tp                 =  PersonalInformation::findOrFail($id)->trainingprograms;
        $otherinfos         =  PersonalInformation::findOrFail($id)->otherinfos->skip(00)->take(07);
        $pdsquestions       =  PersonalInformation::findOrFail($id)->pdsquestion;

        $workExperiences      = $we->skip(0)->take(28);
        $workExperiences_cont = $we->skip(28);

        $trainingPrograms      = $tp->skip(0)->take(21);
        $trainingPrograms_cont = $tp->skip(21);

        $pdf = PDF::loadView('reports.PDS', compact('personalinfos', 'fb', 'eb', 'children', 'eligibilities', 'workExperiences', 'workExperiences_cont', 'voluntaryworks', 'trainingPrograms', 'trainingPrograms_cont', 'otherinfos', 'pdsquestions'))
            ->setPaper([0,0,590,930], 'portrait')
            ->setOptions([
                'defaultMediaType' => 'screen',
                'dpi' => 112,
            ]);
            // ->download('PDS.pdf');
        Storage::put('public/employee_pds/' . $personalinfos->firstname . '.pdf', $pdf->output());
        return ['title' => $personalinfos->firstname];
    }

    public function employeeId(Request $request) {
        $employee = PersonalInformation::findOrFail($request['id']);
        $data = [
            'employee' => $employee
        ];


        $pdf = PDF::loadView('reports/employee-id', $data);

        Storage::put('public/employee_ids/' . $employee->firstname . '.pdf', $pdf->output());

        // return $pdf->download('invoice.pdf');
        return ['title' => $employee->firstname];
    }
}
