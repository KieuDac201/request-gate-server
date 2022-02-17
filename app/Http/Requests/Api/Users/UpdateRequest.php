<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class UpdateRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'       => 'required|email',
            'password'       => 'required',
            'name'      => 'required|max:25',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'A email is required',
            'password.required' => 'A password is required',
            'name.required' => 'A name is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
        ];
    }
}
