<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SsStudyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'protocol_number' => $this->protocol_number,
            'description' => $this->description,
            'does_ctms_connected' => $this->does_ctms_connected,
            'planned_activation_date' => $this->planned_activation_date,
            'organization' => $this->whenLoaded('organization'),
            'site' => $this->whenLoaded('site'),
            'created_by' => $this->creator?->id,
            'created_at' => $this->created_at,
        ];
    }
}
