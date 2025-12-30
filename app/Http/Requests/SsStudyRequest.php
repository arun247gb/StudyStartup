<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsStudyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'ss_organizations_id' => 'nullable|exists:ss_organizations,id',
            'ss_site_id' => 'required|exists:ss_sites,id',
            'name' => 'required|string|max:255',
            'protocol_number' => 'required|string|max:100',
            'does_ctms_connected' => 'required|boolean',
            'planned_activation_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];

        return $rules;
    }


    public function messages(): array
    {
        return [
            'ss_site_id.required' => 'Site is required',
            'ss_site_id.exists' => 'Selected site does not exist',
        ];
    }

}
