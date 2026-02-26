<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkExpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyName'  => 'required|string',
            'title'        => 'required|string',
            'caption'      => 'required|string',
            'environment'  => 'required|string',
            'startDate'    => 'required|date',
            'present'      => 'nullable|string',
            'Present'      => 'nullable|string',
            'endDate'      => 'nullable|date',
        ];
    }
}

