<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\PersonalInformation;
use App\WorkExperience;
use App\VoluntaryWork;
use App\TrainingProgram;
use App\Plantilla;
use App\Setting;
use App\User;

class Helpers extends Controller
{
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

    public function makePlantilla() {
        return Plantilla::create([
            'year' => 'Amended CY 2020',
            'date_prepared' => '2019-03-01',
        ]);
    }

    public function initialize() {
        // System User
        $user = User::create([
            'name' => 'Default System User',
            'avatar' => 'profile.png',
            'email' => 'administrator@hris.com',
            'password' => Hash::make('12345678'),
            'role' => 'Administrator',
            'status' => 'Active'
        ]);

        // System Settings
        $settings = [];
        $default_plantilla = [
            'user_id' => $user->id,
            'title' => 'Default Plantilla',
            'value' => ''
        ];
        array_push($settings, $default_plantilla);
        // $test = [
        //     'user_id' => auth()->user()->id,
        //     'title' => 'Default Plantilla2',
        //     'value' => ''
        // ];
        // array_push($settings, $test);
        foreach ($settings as $key => $setting) {
            Setting::create($setting);
        }

        return 'Successful!';
    }
}
