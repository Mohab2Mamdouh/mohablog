<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'FullName'  => 'required|string',
            'Username'  => 'required|string',
            'Title'     => 'required|string',
            'Email'     => 'required|string|min:4|max:255',
            'Address'   => 'required|string',
            'Phone'     => 'required|string',
            'ExpYear'   => 'required',
            'profile'   => 'required|string',
            'linked_in' => 'required|string',
            'behance'   => 'required|string',
            'github'    => 'required|string',
            'my_site'   => 'required|string',
            'layout'    => 'required|string',
        ];
    }
}

