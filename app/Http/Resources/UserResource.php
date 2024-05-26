<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role->name,
            'address' => $this->when($user->isStudent(), new AddressResource($this->address)),
            'activities' => ActivityResource::collection($this->activities->sortBy('name')),
            'courses' => CourseResource::collection($this->courses->sortBy('name'))
        ];
    }
}
