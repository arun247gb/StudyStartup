<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsMilestoneIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'study_setup_type' => 'required|in:external,internal',
        ];
    }

    public function messages(): array
    {
        return [
            'study_setup_type.required' => 'Study setup type is required.',
            'study_setup_type.in'       => 'Study setup type must be either external or internal.',
        ];
    }
}
