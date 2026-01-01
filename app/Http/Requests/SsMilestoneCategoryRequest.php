<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsMilestoneCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ss_milestone_id' => 'required|exists:ss_milestones,id',
            'category_name'   => 'required|string|max:255',
            'description'     => 'nullable|string',
            'order'           => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'ss_milestone_id.required' => 'Milestone ID is required.',
            'ss_milestone_id.exists'   => 'Milestone does not exist.',
            'category_name.required'   => 'Category name is required.',
            'category_name.string'     => 'Category name must be a string.',
            'category_name.max'        => 'Category name may not exceed 255 characters.',
            'description.string'       => 'Description must be a string.',
            'order.integer'            => 'Order must be an integer.',
            'order.min'                => 'Order must be at least 0.',
        ];
    }
}
