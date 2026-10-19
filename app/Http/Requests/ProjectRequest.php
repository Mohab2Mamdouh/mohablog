<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'show_at_cv'  => $this->boolean('show_at_cv'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'caption'     => 'required|string',
            'summary'     => 'nullable|string',
            'description' => 'nullable|string',
            'tech_stack'  => 'required|string',
            'github_url'  => 'nullable|url|max:2048',
            'app_url'     => 'nullable|url|max:2048',
            'start_date'  => 'nullable|date',
            'end_date'    => ['nullable', 'date', Rule::when($this->filled('start_date'), 'after_or_equal:start_date')],
            'is_featured' => 'boolean',
            'show_at_cv'  => 'boolean',
        ];
    }
}
