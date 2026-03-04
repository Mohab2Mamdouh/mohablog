<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageProcessingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt'              => 'required|string|max:2000',
            'negative_prompt'     => 'nullable|string|max:2000',
            'guidance_scale'      => 'nullable|numeric|min:1|max:20',
            'num_inference_steps' => 'nullable|integer|min:1|max:100',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'prompt.required' => 'A prompt is required to generate/process the image.',
            'image.image'     => 'The uploaded file must be an image.',
            'image.max'       => 'The image must not exceed 10MB.',
        ];
    }
}

