<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'education' => new EducationInstitutionResource($this->educationInstitution),
            'birthday' => $this->birthday,
            'experience' => $this->experience,
            'lastPosition' => new PositionResource($this->lastPosition),
            'appliedPosition' => new PositionResource($this->appliedPosition),
            'skills' => SkillResource::collection($this->skills),
            'email' => $this->email,
            'phone' => $this->phone,
            'resume' => $this->resume !== null ?? Storage::url($this->resume),
        ];
    }
}
