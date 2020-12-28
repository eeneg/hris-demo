<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\EducationalBackground;
use Illuminate\Http\Request;

class EducationalBackgroundUpdateListener
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

        $educationalBackground = array_filter(collect($this->request->educationalbackground)->except('id', 'personal_information_id', 'created_at', 'updated_at')->toArray());

        if(count($educationalBackground) > 0)
        {

            $event->pi->educationalbackground()->updateOrCreate(['personal_information_id' => $this->request->id], $this->request->educationalbackground);

        }
        else if(!count($educationalBackground) && array_key_exists('id', $this->request->educationalbackground)){

            EducationalBackground::find($this->request->educationalbackground['id'])->delete();

        }

    }
}
