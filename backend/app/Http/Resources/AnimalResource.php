<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'weight' => $this->weight,
            'color' => $this->color,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'species' => new SpeciesResource($this->whenLoaded('species')),
            'tutor' => new TutorResource($this->whenLoaded('tutor')),
        ];
    }   
}
