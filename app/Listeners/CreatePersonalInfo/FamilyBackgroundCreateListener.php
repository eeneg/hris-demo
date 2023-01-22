<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Http\Request;

class FamilyBackgroundCreateListener
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
        if (true) {
            $event->pi->familybackground()->create($this->request->familybackground);

            foreach ($this->request->children as $key => $value) {
                if (count($value) > 0) {
                    $event->pi->children()->createMany([$value]);
                }
            }
        }
    }
}
