<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SsDepartmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'ss_organizations_id'  => $this->ss_organizations_id,
            'name'                 => $this->name,
            'description'          => $this->description,
            'is_active'            => $this->is_active,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,

            'organization' => $this->whenLoaded('organization', function () {
                return [
                    'id'   => $this->organization->id,
                    'name' => $this->organization->name ?? null,
                ];
            }),
        ];
    }
}
