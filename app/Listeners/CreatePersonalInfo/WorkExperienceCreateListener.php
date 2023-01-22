<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Http\Request;

class WorkExperienceCreateListener
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
     * @param  PersonalInfoRegistered  $event
     * @return void
     */
    public function handle(PersonalInfoRegistered $event)
    {
        foreach ($this->request->workexperiences as $key => $value) {
            if (count($value) > 0) {
                $event->pi->workexperiences()->createMany([$value]);
            }
        }
    }
}
