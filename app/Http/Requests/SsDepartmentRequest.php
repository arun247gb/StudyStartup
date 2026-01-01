<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_organizations_id' => 'required|exists:ss_organizations,id',
            'name'                => 'required|string|max:255',
            'description'         => 'nullable|string|max:255',
            'is_active'           => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_organizations_id.required' => 'Organization is required.',
            'ss_organizations_id.exists'   => 'Selected organization does not exist.',

            'name.required'                => 'Department name is required.',
            'name.string'                  => 'Department name must be a valid string.',
            'name.max'                     => 'Department name must not exceed 255 characters.',

            'description.string'           => 'Description must be a valid string.',
            'description.max'              => 'Description must not exceed 255 characters.',

            'is_active.boolean'            => 'Is active must be true or false.',
        ];
    }

}
