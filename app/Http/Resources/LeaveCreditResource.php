<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use App\LeaveType;
use App\LeaveSummary;




class LeaveCreditResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     */

    public function toArray($request)
    {

        return $this->collection->map(function ($item, $key) {
            return [
                    'id'            => $item->id,
                    'name'          => $item->fullName,
                    'civilstatus'   => $item->civilstatus,
                    'birthdate'     => $item->birthdate,
                ];
        });
    }

}
