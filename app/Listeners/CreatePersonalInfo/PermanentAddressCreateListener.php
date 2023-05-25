<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Http\Request;

class PermanentAddressCreateListener
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
        $event->pi->permanentaddresstable()->create($this->request->permanentaddresstable);
    }
}
