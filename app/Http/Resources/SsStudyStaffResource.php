<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SsStudyStaffResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'staff_type_id' => $this->enum_staff_type_id,
            'description' => $this->description,
            'created_by' => $this->creator ? $this->creator->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'study' => $this->whenLoaded('study'),
            'study' => $this->whenLoaded('study'),
            'user' => $this->whenLoaded('user'),
            'organization' => $this->whenLoaded('organization'),
        ];
    }
}
