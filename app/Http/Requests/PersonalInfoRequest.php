<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
{
    /** Links end up in href on the public site: no javascript:/data: URLs. */
    private const SAFE_LINK = 'not_regex:/^\s*(javascript|data|vbscript):/i';

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
            'Email'     => 'required|email|max:255',
            'Address'   => 'required|string',
            'Phone'     => 'required|string',
            'ExpYear'   => 'required|string|max:20',
            'profile'   => 'required|string',
            'linked_in' => ['required', 'string', 'max:2048', self::SAFE_LINK],
            'behance'   => ['required', 'string', 'max:2048', self::SAFE_LINK],
            'github'    => ['required', 'string', 'max:2048', self::SAFE_LINK],
            'my_site'   => ['required', 'string', 'max:2048', self::SAFE_LINK],
            'layout'    => 'required|in:pdf,pdf1',
        ];
    }
}

