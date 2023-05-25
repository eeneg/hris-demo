<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Http\Request;

class ResidentialAddressCreateListener
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
        $event->pi->residentialaddresstable()->create($this->request->residentialaddresstable);
    }
}
