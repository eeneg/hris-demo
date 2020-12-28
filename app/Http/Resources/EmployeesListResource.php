<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeesListResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'firstname' => $item->firstname,
                'middlename' => $item->middlename,
                'nameextension' => $item->nameextension,
                'surname' => $item->surname,
                'status' => $item->status,
                'plantillacontents' => $item->plantillacontents
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
