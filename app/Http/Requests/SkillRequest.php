<?php

namespace App\Http\Requests;

use App\Enums\SkillType;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'languageName' => 'required|string',
            'type'         => 'required|in:' . implode(',', SkillType::values()),
            'main'         => 'nullable',
        ];
    }
}

