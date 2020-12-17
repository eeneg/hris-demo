<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VoluntaryWorkUpdateListener
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
        if($this->request->voluntaryworks !== null){

            $arr = [];

            foreach($this->request->voluntaryworks as $key => $value)
            {
                if(count($value) > 0)
                {
                    array_push($arr, data_get($value, 'id'));
                    $event->pi->voluntaryworks()->updateOrCreate(['id'=> data_get($value, 'id')],$value);
                }
            }

            DB::table('voluntary_works')->whereNotIn('id', $arr)->delete();

        }
    }
}
