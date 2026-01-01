<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\ErrorHandler\Collecting;

class SsSiteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                       => $this->id,
            'organization_id'           => $this->ss_organizations_id,
            'organization'             => $this->organization ? SsOrganizationResource::make($this->organization) : null,
            'name'                     => $this->name,
            'site_number'              => $this->site_number,
            'address_line1'            => $this->address_line1,
            'address_line2'            => $this->address_line2,
            'city'                     => $this->city,
            'state'                    => $this->state,
            'postal_code'              => $this->postal_code,
            'country'                  => $this->country,
            'irb_name'                 => $this->irb_name,
            'is_active'                => $this->is_active,
            'activation_date'          => $this->activation_date,
            'activation_letter_document_id' => $this->activation_letter_document_id,
            'created_at'               => $this->created_at,
            'updated_at'               => $this->updated_at,
        ];
    }
}
