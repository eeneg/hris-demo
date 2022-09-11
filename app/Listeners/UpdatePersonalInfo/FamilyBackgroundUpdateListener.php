<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Child;
use App\FamilyBackground;

class FamilyBackgroundUpdateListener
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

        $familyBackground = array_filter(collect($this->request->familybackground)->except('id', 'personal_information_id', 'created_at', 'updated_at')->toArray());

        if(count($familyBackground) > 0)
        {

            $event->pi->familybackground()->updateOrCreate(['personal_information_id' => $this->request->id], $this->request->familybackground);

        }
        else if(!count($familyBackground) && array_key_exists('id', $this->request->familybackground)){

            $family_Background = FamilyBackground::find($this->request->familybackground['id']);
            if ($family_Background) {
                $family_Background->delete();
            }

        }

        if($this->request->children !== null)
        {

            $arr = [];

            foreach($this->request->children as $key => $value)
            {

                if(!is_null(data_get($value, 'id')) && !data_get($value, 'name') && !data_get($value, 'birthday'))
                {

                    DB::table('children')->where('id', data_get($value, 'id'))->delete();

                }else if(count($value) > 0){

                    array_push($arr, data_get($value, 'id'));
                    $event->pi->children()->updateOrCreate(['id' => data_get($value, 'id')], $value);

                }
            }

            DB::table('children')->where('personal_information_id', $this->request->id)->whereNotIn('id', $arr)->delete();

        }
    }
}
