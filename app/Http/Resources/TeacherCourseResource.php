<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response =  [
            'id' => $this->id,
            'name' => $this->name,
            'grade' => $this->grade->name,
        ];

        if ($request->user()->isTeacher()) {
            $response['students'] = UserResource::collection($this->users);
        }

        return $response;
    }
}
