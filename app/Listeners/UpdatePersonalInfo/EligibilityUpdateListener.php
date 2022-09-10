<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EligibilityUpdateListener
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
        if($this->request->eligibilities !== null)
        {

            $arr = [];

            foreach($this->request->eligibilities as $key => $value)
            {
                $bool = !is_null(data_get($value, 'id')) && !data_get($value, 'careerService') && !data_get($value, 'rating') && !data_get($value, 'dateOfExam') && !data_get($value, 'placeOfExam') && !data_get($value, 'licenseNumber') && !data_get($value, 'licenseRelease');

                if($bool)
                {

                    DB::table('eligibilities')->where('id', data_get($value, 'id'))->delete();

                }else if(count($value) > 0){

                    array_push($arr, data_get($value, 'id'));
                    $event->pi->eligibilities()->updateOrCreate(['id' => data_get($value, 'id')], $value);

                }
            }

            DB::table('eligibilities')->where('personal_information_id', $this->request->id)->whereNotIn('id', $arr)->delete();

        }
    }
}
