<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SsMilestoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
            'milestone_owner_id' => 'nullable|integer|exists:ss_users,id',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Milestone name is required.',
            'name.string' => 'Milestone name must be a string.',
            'name.max' => 'Milestone name cannot exceed 255 characters.',
            'order.required' => 'Order is required.',
            'order.integer' => 'Order must be an integer.',
            'order.min' => 'Order must be at least 1.',
            'milestone_owner_id.exists' => 'The selected milestone owner does not exist.',
            'is_active.boolean' => 'is_active must be true or false.',
        ];
    }
}
