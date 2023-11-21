<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveCreditResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item, $key) {
            return [
                'id' => $item->personal_information_id,
                'name' => trim(
                    preg_replace('/\s+/', ' ',
                        "$item->surname, $item->firstname".
                        ($item->middleinitial ? " $item->middleinitial." : '').
                        ($item->nameextension ? ", $item->nameextension" : '')
                    )
                ),
                'civilstatus' => $item->civilstatus,
                'birthdate' => $item->birthdate,
                'retirement_date' => $item->retirement_date,
                'status' => $item->status,
            ];
        });
    }
}
