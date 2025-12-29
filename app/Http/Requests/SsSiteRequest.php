<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsSiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_organizations_id'        => 'nullable|exists:ss_organizations,id',
            'name'                       => 'required|string|max:255',
            'site_number'                => 'nullable|string|max:255',
            'address_line1'              => 'nullable|string|max:255',
            'address_line2'              => 'nullable|string|max:255',
            'city'                       => 'nullable|string|max:255',
            'state'                      => 'nullable|string|size:2',
            'postal_code'                => 'nullable|string|max:10',
            'country'                    => 'nullable|string|size:2',
            'irb_name'                   => 'nullable|string|max:255',
            'is_active'                  => 'nullable|boolean',
            'activation_date'            => 'nullable|date',
            'activation_letter_document_id' => 'nullable|integer',
        ];
    }
}
