<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use App\PersonalInformation;
use App\WorkExperience;

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
                $workexp->save();
            }
            
            // $dates = explode(' /*/ ', $workexp->inclusiveDateFrom);
            // $workexp->inclusiveDateFrom = $dates[0];
            // $workexp->inclusiveDateTo = $dates[1];
           
        }
        echo $pos;
    }
}
