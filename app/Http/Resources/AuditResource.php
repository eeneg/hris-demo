<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuditResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(fn ($audit) => [
            'audited' => $audit->audited,
            'event' => $audit->event,
            'ip_address' => $audit->ip_address,
            'modified' => $audit->modified,
            'time' => $audit->created_at,
            'user' => [
                'avatar' => $audit->user->avatar,
                'name' => $audit->user->name,
            ],
        ]);
    }
}
