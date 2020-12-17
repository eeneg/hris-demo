<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        $event->pi->familybackground()->first()->update($this->request->familybackground);

        if($this->request->children !== null)
        {

            $arr = [];

            foreach($this->request->children as $key => $value)
            {

                if(count($value) > 0)
                {
                    array_push($arr, data_get($value, 'id'));
                    $event->pi->children()->updateOrCreate(['id' => data_get($value, 'id')], $value);
                }

            }

            DB::table('children')->whereNotIn('id', $arr)->delete();

        }
    }
}
