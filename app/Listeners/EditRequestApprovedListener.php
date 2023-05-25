<?php

namespace App\Listeners;

use App\EmployeePDSEdit;
use App\Events\EditRequestApproved;
use App\PersonalInformation;
use Illuminate\Http\Request;

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

        $children = [];
        $eligibilities = [];
        $workexperiences = [];
        $voluntaryworks = [];
        $trainingprograms = [];
        $otherinfos = [];

        if ($id) {
            $employee = PersonalInformation::find($id);

            $records = $event->data->employeeEdits->where('status', 'APPROVED');

            foreach ($records as $record) {
                if ($record->model == 'personalinformation') {
                    $employee->update([$record->field => $record->newValue]);
                }

                if ($record->model == 'familybackground') {
                    $employee->familybackground()->updateOrCreate(['personal_information_id' => $employee->id], [$record->field => $record->newValue]);
                }

                if ($record->model == 'permanentaddresstable') {
                    $employee->permanentaddresstable()->updateOrCreate(['personal_information_id' => $employee->id], [$record->field => $record->newValue]);
                }

                if ($record->model == 'residentialaddresstable') {
                    $employee->residentialaddresstable()->updateOrCreate(['personal_information_id' => $employee->id], [$record->field => $record->newValue]);
                }

                if ($record->model == 'educationalbackground') {
                    $employee->educationalbackground()->updateOrCreate(['personal_information_id' => $employee->id], [$record->field => $record->newValue]);
                }

                if ($record->model == 'pdsquestion') {
                    $employee->pdsquestion()->updateOrCreate(['personal_information_id' => $employee->id], [$record->field => $record->newValue]);
                }

                if ($record->model == 'children') {
                    if (strlen($record->model_id) > 0) {
                        $data = $employee->children()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $children[$record->model_id][$record->field] = $record->newValue;
                    }
                }

                if ($record->model == 'eligibilities') {
                    if (strlen($record->model_id) > 0) {
                        $employee->eligibilities()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $eligibilities[$record->model_id][$record->field] = $record->newValue;
                    }
                }

                if ($record->model == 'workexperiences') {
                    if (strlen($record->model_id) > 0) {
                        $employee->workexperiences()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $workexperiences[$record->model_id][$record->field] = $record->newValue;
                    }
                }

                if ($record->model == 'voluntaryworks') {
                    if (strlen($record->model_id) > 0) {
                        $employee->voluntaryworks()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $voluntaryworks[$record->model_id][$record->field] = $record->newValue;
                    }
                }

                if ($record->model == 'trainingprograms') {
                    if (strlen($record->model_id) > 0) {
                        $employee->trainingprograms()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $trainingprograms[$record->model_id][$record->field] = $record->newValue;
                    }
                }

                if ($record->model == 'otherinfos') {
                    if (strlen($record->model_id) > 0) {
                        $employee->otherinfos()->updateOrCreate(['id' => $record->model_id], [$record->field => $record->newValue]);
                    } else {
                        $otherinfos[$record->model_id][$record->field] = $record->newValue;
                    }
                }
            }

            if (count($children) > 0) {
                foreach ($children as $key => $data) {
                    $record = $employee->children()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }

            if (count($eligibilities) > 0) {
                foreach ($eligibilities as $key => $data) {
                    $record = $employee->eligibilities()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }

            if (count($workexperiences) > 0) {
                foreach ($workexperiences as $key => $data) {
                    $record = $employee->workexperiences()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }

            if (count($voluntaryworks) > 0) {
                foreach ($voluntaryworks as $key => $data) {
                    $record = $employee->voluntaryworks()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }

            if (count($trainingprograms) > 0) {
                foreach ($trainingprograms as $key => $data) {
                    $record = $employee->trainingprograms()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }

            if (count($otherinfos) > 0) {
                foreach ($otherinfos as $key => $data) {
                    $record = $employee->otherinfos()->create($data);
                    EmployeePDSEdit::where('model_id', $key)->update(['model_id' => $record->id]);
                }
            }
        }
    }
}
