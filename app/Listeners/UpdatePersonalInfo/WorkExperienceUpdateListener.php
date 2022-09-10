<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkExperienceUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  PersonalInfoUpdated  $event
     * @return void
     */
    public function handle(PersonalInfoUpdated $event)
    {
        if($this->request->workexperiences !== null)
        {

            $arr = [];

            foreach($this->request->workexperiences as $key => $value)
            {
                $bool = !is_null(data_get($value, 'id')) && !data_get($value, 'inclusiveDateFrom') && !data_get($value, 'inclusiveDateTo') && !data_get($value, 'position')
                        && !data_get($value, 'department') && !data_get($value, 'monthlySalary') && !data_get($value, 'salaryGrade') && !data_get($value, 'statusOfAppointment')
                        && !data_get($value, 'govService');

                if($bool){

                    DB::table('work_experiences')->where('id', data_get($value, 'id'))->delete();

                }else if(count($value) > 0){
                    array_push($arr, data_get($value, 'id'));
                    $event->pi->workexperiences()->updateOrCreate(['id' => data_get($value, 'id')], $value);
                }
            }

            DB::table('work_experiences')->where('personal_information_id', $this->request->id)->whereNotIn('id', $arr)->delete();

        }
    }
}
