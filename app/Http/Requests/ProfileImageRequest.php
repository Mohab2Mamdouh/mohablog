<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'          => 'required',
            'profile_pic' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'oldPic'      => 'required|string',
        ];
    }
}

