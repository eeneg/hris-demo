<?php

namespace App\Listeners;

use App\Events\EditRequestApproved;
use App\PersonalInformation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class EditRequestApprovedListener
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
     * @param  EditRequestApproved  $event
     * @return void
     */
    public function handle(EditRequestApproved $event)
    {
        $id = $event->data->value('personal_information_id');

        $children = [];
        $eligibilities = [];
        $workexperiences = [];
        $voluntaryworks = [];
        $trainingprograms = [];
        $otherinfos = [];

        if($id)
        {
            $employee = PersonalInformation::find($id);

            $records = $event->data->employeeEdits->where('status', 'APPROVED');

            foreach($records as $record)
            {
                if($record->model == 'personalinformation')
                {
                    $employee->update([$record->field => $record->newValue]);
                }

                if($record->model == 'familybackground')
                {
                    $employee->familybackground()->update([$record->field => $record->newValue]);
                }

                if($record->model == 'educationalbackground')
                {
                    $employee->educationalbackground()->update([$record->field => $record->newValue]);
                }

                if($record->model == 'pdsquestion')
                {
                    $employee->pdsquestion()->update([$record->field => $record->newValue]);
                }

                if($record->model == 'children')
                {
                    if(strlen($record->model_id) > 5)
                    {
                        $employee->children()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $children[$record->model_id][$record->field] =  $record->newValue;
                    }
                }

                if($record->model == 'eligibilities')
                {

                    if(strlen($record->model_id) > 5)
                    {
                        $employee->eligibilities()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $eligibilities[$record->model_id][$record->field] =  $record->newValue;
                    }
                }

                if($record->model == 'workexperiences')
                {

                    if(strlen($record->model_id) > 5)
                    {
                        $employee->workexperiences()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $workexperiences[$record->model_id][$record->field] =  $record->newValue;
                    }
                }

                if($record->model == 'voluntaryworks')
                {

                    if(strlen($record->model_id) > 5)
                    {
                        $employee->voluntaryworks()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $voluntaryworks[$record->model_id][$record->field] =  $record->newValue;
                    }

                }

                if($record->model == 'trainingprograms')
                {

                    if(strlen($record->model_id) > 5)
                    {
                        $employee->trainingprograms()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $trainingprograms[$record->model_id][$record->field] =  $record->newValue;
                    }

                }

                if($record->model == 'otherinfos')
                {

                    if(strlen($record->model_id) > 5)
                    {
                        $employee->otherinfos()->find($record->model_id)->update([$record->field => $record->newValue]);
                    }else{
                        $otherinfos[$record->model_id][$record->field] =  $record->newValue;
                    }

                }
            }


            if(count($children) > 0)
            {
                $employee->children()->createMany($children);
            }

            if(count($eligibilities) > 0)
            {
                $employee->eligibilities()->createMany($eligibilities);
            }

            if(count($workexperiences) > 0)
            {
                $employee->workexperiences()->createMany($workexperiences);
            }

            if(count($voluntaryworks) > 0)
            {
                $employee->voluntaryworks()->createMany($voluntaryworks);
            }

            if(count($trainingprograms) > 0)
            {
                $employee->trainingprograms()->createMany($trainingprograms);
            }

            if(count($otherinfos) > 0)
            {
                $employee->otherinfos()->createMany($otherinfos);
            }

        }

    }
}
