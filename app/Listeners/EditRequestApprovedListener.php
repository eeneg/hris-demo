<?php

namespace App\Listeners;

use App\EmployeePDSEdit;
use App\Events\EditRequestApproved;
use App\PersonalInformation;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

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
        $id = $event->data->personal_information_id;

        if ($id) {
            $employee = PersonalInformation::find($id);

            $records = $event->data->employeeEdits
                ->where('status', 'APPROVED')
                ->groupBy('model')
                ->map(fn($e) => $e->groupBy('model_id')->map(fn($e) => $e->flatMap(fn($e) => [$e->field => $e->newValue])))
                ->toArray();

            foreach($records as $model => $record){

                foreach($record as $key => $data){
                    if($model == 'personalinformation'){
                        $employee->update($data);
                    }else if(!in_array($model, ['children', 'eligibilities', 'otherinfos', 'workexperiences', 'voluntaryworks', 'trainingprograms'])){
                        $employee->$model()->updateOrCreate(['personal_information_id' => $key], $data);
                    }else{
                        if(Uuid::isValid($key)){
                            $employee->$model()->find($key)->update($data);
                        }else{
                            $create = $employee->$model()->create($data);
                            $update = EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $create->id]);
                        }
                    }
                }
            }
        }
    }

}
