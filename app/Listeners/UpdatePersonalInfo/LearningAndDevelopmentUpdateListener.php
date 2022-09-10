<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class LearningAndDevelopmentUpdateListener
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
        if($this->request->trainingprograms !== null){

            $arr = [];

            foreach($this->request->trainingprograms as $key => $value)
            {

                $bool = !is_null(data_get($value, 'id')) && !data_get($value, 'title') && !data_get($value, 'inclusiveDateFrom')
                        && !data_get($value, 'inclusiveDateTo') && !data_get($value, 'hours') && !data_get($value, 'conductor');

                if($bool){

                    DB::table('training_programs')->where('id', data_get($value, 'id'))->delete();

                }else if(count($value) > 0){
                    array_push($arr, data_get($value, 'id'));
                    $event->pi->trainingprograms()->updateOrCreate(['id'=> data_get($value, 'id')],$value);
                }
            }

            DB::table('training_programs')->where('personal_information_id', $this->request->id)->whereNotIn('id', $arr)->delete();

        }
    }
}
