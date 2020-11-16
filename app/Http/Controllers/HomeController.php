<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use App\PersonalInformation;
use App\WorkExperience;
use App\VoluntaryWork;
use App\TrainingProgram;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function saveid(Request $request) {
        $employee = PersonalInformation::findOrFail($request['id']);
        $data = [
            'employee' => $employee
        ];


        $pdf = PDF::loadView('reports/employee-id', $data);

        Storage::put('public/employee_ids/' . $employee->firstname . '.pdf', $pdf->output());

        // return $pdf->download('invoice.pdf');
        return ['title' => $employee->firstname];
    }

    public function workExperienceFormat() {
        $workexps = WorkExperience::get();
        $pos = '';
        $on = '';
        $count = 0;
        foreach ($workexps as $workexp) {
           
            if(str_contains($workexp->position, '^*')){
                $count++;
                $on = explode('^*', $workexp->position)[0];
                $pos = explode('^*', $workexp->position)[1];
                $workexp->position = $pos;
                $workexp->orderNo = $on;
                
            }
            
            if(str_contains($workexp->inclusiveDateFrom, ' /*/ ')){
                $dates = explode(' /*/ ', $workexp->inclusiveDateFrom);
                $workexp->inclusiveDateFrom = $dates[0];
                $workexp->inclusiveDateTo = $dates[1];
            }

            $workexp->save();
           
        }
    }

    public function voluntaryWorksFormat() {
        $volworks = VoluntaryWork::get();
        $nad = '';
        $on = '';
        foreach ($volworks as $volwork) {
           
            if(str_contains($volwork->nameAndAddress, '^*')){
                $on = explode('^*', $volwork->nameAndAddress)[0];
                $nad = explode('^*', $volwork->nameAndAddress)[1];
                $volwork->nameAndAddress = $nad;
                $volwork->orderNo = $on;
                
            }
            
            if(str_contains($volwork->inclusiveDateFrom, ' /*/ ')){
                $dates = explode(' /*/ ', $volwork->inclusiveDateFrom);
                $volwork->inclusiveDateFrom = $dates[0];
                $volwork->inclusiveDateTo = $dates[1];
            }

            $volwork->save();
           
        }
    }

    public function trainingFormat() {
        $trainings = TrainingProgram::get();
        $title = '';
        $on = '';
        foreach ($trainings as $training) {
           
            if(str_contains($training->title, '^*')){
                $on = explode('^*', $training->title)[0];
                $title = explode('^*', $training->title)[1];
                $training->title = $title;
                $training->orderNo = $on;
                
            }
            
            if(str_contains($training->inclusiveDateFrom, ' /*/ ')){
                $dates = explode(' /*/ ', $training->inclusiveDateFrom);
                $training->inclusiveDateFrom = $dates[0];
                $training->inclusiveDateTo = $dates[1];
            }
            

            $training->save();
           
        }
    }
}
