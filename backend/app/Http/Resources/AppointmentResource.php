<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'animal' => new AnimalResource($this->whenLoaded('animal')),
            'tutor' => new TutorResource($this->whenLoaded('tutor')),
            'service' => $this->service,
            'date' => $this->date,
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 