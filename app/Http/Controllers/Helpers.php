<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;
use App\PersonalInformation;
use App\WorkExperience;
use App\VoluntaryWork;
use App\TrainingProgram;
use App\Plantilla;
use App\Setting;
use App\User;
use App\SalaryGrade;
use App\PlantillaContent;
use App\Position;

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

    public function updateIds() {
        $salaryGrades = SalaryGrade::all();
        foreach ($salaryGrades as $key => $value) {
            $value->id = Uuid::generate()->string;
            $value->save();
        }
    }

    public function updateSalaryGrades() {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $plantillacontents = PlantillaContent::where('plantilla_id', $plantilla->id)->get();
        foreach ($plantillacontents as $value) {
            $salaryGrade = SalaryGrade::where('grade', $value->salaryproposed->grade)
                ->where('step', $value->salaryproposed->step)
                ->where('salary_sched_id', '05699080-3832-11eb-aaac-e7512d9321d1')
                ->first();
            $value->salary_grade_prop_id = $salaryGrade->id;
            $value->save();
        }
    }

    public function positions() {
        $departments = Department::all();
        foreach ($departments as $key => $value) {
            $unique_positions = Position::where('department_id', $value->id)->groupBy('title')->get();
            $all_positions = Position::where('department_id', $value->id)->get();

        }
    }
}
