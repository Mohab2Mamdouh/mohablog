<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'caption'         => 'required|string',
            'TechnologyStack' => 'required|string',
            'endDate'         => 'nullable|date',
            'appURL'          => 'nullable|string',
            'URL'             => 'nullable|string',
            'description'     => 'nullable|string',
            'link'            => 'nullable|string',
        ];
    }
}

