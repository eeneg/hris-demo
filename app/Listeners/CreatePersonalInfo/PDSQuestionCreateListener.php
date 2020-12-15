<?php

namespace App\Listeners\CreatePersonalInfo;

use App\Events\PersonalInfoRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class PDSQuestionCreateListener
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
        $event->pi->pdsquestion()->create($this->request->pdsquestion);
    }
}
