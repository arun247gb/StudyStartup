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
            'ss_organizations_id.exists' => 'Selected organization does not exist',
            'ss_site_id.required' => 'Site is required',
            'ss_site_id.exists' => 'Selected site does not exist',
            'name.required' => 'Study name is required',
            'name.string' => 'Study name must be a string',
            'name.max' => 'Study name cannot exceed 255 characters',
            'protocol_number.required' => 'Protocol number is required',
            'protocol_number.string' => 'Protocol number must be a string',
            'protocol_number.max' => 'Protocol number cannot exceed 100 characters',
            'does_ctms_connected.required' => 'CTMS connection status is required',
            'does_ctms_connected.boolean' => 'CTMS connection status must be true or false',
            'planned_activation_date.date' => 'Planned activation date must be a valid date',
            'description.string' => 'Description must be a string',
        ];
    }
}
