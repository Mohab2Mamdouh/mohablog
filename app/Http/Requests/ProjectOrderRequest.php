<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order'   => 'required|list|max:500',
            'order.*' => 'required|integer|distinct|exists:projects,id',
        ];
    }
}

