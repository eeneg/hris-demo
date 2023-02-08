<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(fn ($activity) => [
            'id' => $activity->id,
            'info' => $activity->info,
            'time' => $activity->time,
            'title' => $activity->title,
            'type' => $activity->type,
            'user' => [
                'name' => $activity->user?->name,
                'avatar' => $activity->user?->avatar,
            ],
            'created_at' => $activity->created_at,
            'updated_at' => $activity->updated_at,
        ]);
    }
}
