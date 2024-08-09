<?php

namespace App\Project\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Resources\UserResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'creator' => new UserResource($this->whenLoaded('creator'))
        ];
    }
}
