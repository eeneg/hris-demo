<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Http\Request;

class OtherInformationCreateListener
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
        foreach ($this->request->otherinfos as $key => $value) {
            if (count($value) > 0) {
                $event->pi->otherinfos()->createMany([$value]);
            }
        }
    }
}
