<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveApplicationResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'personal_information_id' => $item->personal_information_id,
                'personalinformation' => [ 
                    'firstname' => $item->firstname, 
                    'middlename' => $item->middlename, 
                    'nameextension' => $item->nameextension, 
                    'surname' => $item->surname 
                ],
                'leave_type_id' => $item->leave_type_id,
                'leavetype' => [
                    'abbreviation' => $item->abbreviation,
                    'description' => $item->description,
                    'max_duration' => $item->max_duration,
                    'status' => $item->status,
                    'title' => $item->title
                ],
                'date_of_filing' => $item->date_of_filing,
                'working_days' => $item->working_days,
                'spent' => $item->spent,
                'spent_spec' => $item->spent_spec,
                'commutation' => $item->commutation,
                'from' => $item->from,
                'to' => $item->to,
                'credit_as_of' => $item->credit_as_of,
                'vacation_balance' => $item->vacation_balance,
                'sick_balance' => $item->sick_balance,
                'vacation_less' => $item->vacation_less,
                'sick_less' => $item->sick_less,
                'recommendation' => $item->recommendation,
                'days_with_pay' => $item->days_with_pay,
                'days_without_pay' => $item->days_without_pay,
                'others' => $item->others,
                'disapproved_due_to' => $item->disapproved_due_to,
                'status' => $item->status
                // 'leavetype' => $item->leavetype,
                // 'order_number' => $item->order_number,
                // 'working_time' => $item->working_time,
                // 'position' => $item->position ? $item->position->title : '',
                // 'position_id' =>$item->position ? $item->position->id : '',
                // 'firstname' => $item->personalinformation ? $item->personalinformation->firstname : '',
                // 'middlename' => $item->personalinformation ? $item->personalinformation->middlename : '',
                // 'surname' => $item->personalinformation ? $item->personalinformation->surname : '',
                // 'nameextension' => $item->personalinformation ? $item->personalinformation->nameextension : '',
                // 'salaryauthorized' => $item->salaryauthorized,
                // 'salaryproposed' => $item->salaryproposed,
            ];
        });
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://www.davsurians.com.ph/')
        ];
    }
}
