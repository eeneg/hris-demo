<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\PDSQuestion;
use Illuminate\Http\Request;

class PDSQuestionUpdateListener
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

        $pdsQuestions = array_filter(collect($this->request->pdsquestion)->except('id', 'personal_information_id', 'created_at', 'updated_at')->toArray());

        if(count($pdsQuestions) > 0)
        {

            $event->pi->pdsquestion()->updateOrCreate(['personal_information_id' => $this->request->id], $this->request->pdsquestion);

        }
        else if(!count($pdsQuestions) && array_key_exists('id', $this->request->pdsquestion)){

            PDSQuestion::find($this->request->pdsquestion['id'])->delete();

        }

    }
}
